<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Redis\DAO;

use Generator;
use Infrastructure\Persistence\Redis\Entity\Coin as CoinEntity;
use Infrastructure\Persistence\Redis\Mapper\CoinMapper;
use Predis\Client;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;

readonly final class Coin
{
    private const string NAMESPACE = 'coin:{id}';

    public function __construct(
        private Client $client,
        private SerializerInterface $serializer,
        private CoinMapper $mapper,
    ) {
    }

    public function saveOrReplace(CoinEntity $coin): void
    {
        $serialized = $this->serializer->serialize($coin, 'json');
        $key = $this->getKey($coin);

        $this->client->set($key, $serialized);
    }

    /**
     * @return Generator<CoinEntity>
     */
    public function findAll(): Generator
    {
        $iterator = 0;
        $pattern = str_replace('{id}', '*', self::NAMESPACE);

        do {
            $result = $this->client->scan($iterator, ['MATCH' => $this->addPrefix($pattern)]);

            [$iterator, $keys] = $result;

            if ($keys) {
                foreach ($keys as $key) {
                    if (null !== $serialized = $this->client->get($this->removePrefix($key))) {
                        yield $this->mapper->fromSerialized($serialized);
                    }
                }
            }
        } while (0 != $iterator);
    }

    public function remove(CoinEntity $coin): void
    {
        $key = str_replace('{id}', $coin->id, self::NAMESPACE);

        if (1 !== $this->client->del($key)) {
            throw new RuntimeException('Impossible to remove: ' . $key);
        }
    }

    private function getKey(CoinEntity $coin): string
    {
        return str_replace('{id}', $coin->id, self::NAMESPACE);
    }

    private function removePrefix(string $key): string
    {
        $prefix = (string) $this->client->getOptions()->prefix;

        return str_replace($prefix, '', $key);
    }

    private function addPrefix(string $key): string
    {
        $prefix = (string) $this->client->getOptions()->prefix;

        return $prefix . $key;
    }
}
