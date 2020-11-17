<?php

namespace App\Enum;

use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;

class RoleEnums extends Enum
{
    use AutoDiscoveredValuesTrait;

    public const ROLE_WRITER = "ROLE_WRITER";
    public const ROLE_EDITOR = "ROLE_EDITOR";
    public const ROLE_ADMIN = "ROLE_ADMIN";
    public const ROLE_USER = "ROLE_USER";
    public const ROLE_REVIEWER = "ROLE_REVIEWER";
    public const ROLE_SUPER_EDITOR = "ROLE_SUPER_EDITOR";
}