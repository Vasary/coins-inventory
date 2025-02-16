<?php

declare(strict_types=1);

namespace Domain\Common\Enum;

enum Country: string
{
    case USA = 'usa';
    case Australia = 'australia';
    case UnitedKingdom = 'unitedKingdom';

    case Canada = 'canada';

    case SouthAfrica = 'southAfrica';
}
