<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

abstract class AbstractCoinInventory extends Command
{
    protected const int EXIT_SUCCESS = Command::SUCCESS;
    protected const int EXIT_FAILURE = Command::FAILURE;

    abstract protected function name(): string;

    abstract protected function description(): string;

    abstract protected function handle(): int;

    protected function configure(): void
    {
        $this
            ->setName($this->name())
            ->setDescription($this->description())
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Starting ' . static::class);
        $io->comment($this->description());

        try {
            $result = $this->handle();

            $io->success('Done');

            return $result;
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());
        }

        $io->note('Exiting with exit code 1');

        return self::EXIT_FAILURE;
    }
}
