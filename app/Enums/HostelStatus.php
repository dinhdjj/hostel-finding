<?php

declare(strict_types=1);

namespace App\Enums;

enum HostelStatus: int
{
    // Hostel is available for rent
    case FINDING = 0;

    // Hostel is not available for rent
    case FOUND = 1;
}
