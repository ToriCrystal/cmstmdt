<?php

namespace App\Enums\Setting;

use App\Supports\Enum;

enum SettingGroup: int
{
    use Enum;

    case General = 1;
    case Job = 2;
    case Appearance = 3;

    case System = 4;
}
