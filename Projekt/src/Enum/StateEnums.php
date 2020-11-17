<?php

namespace App\Enum;

use Elao\Enum\Enum;
use Elao\Enum\AutoDiscoveredValuesTrait;

class StateEnums extends Enum
{
    use AutoDiscoveredValuesTrait;

    public const WORK_IN_PROGRESS = "Work In Progress";
    public const SUBMITTED = "Submited";
    public const IN_ACCEPTENCE = "In Acceptence";
    public const INAPPROPRIAT_THEME = "Inappropriat_theme";
    public const ACCEPTED = "Accepted";
    public const READY_FOR_REVIEW = "Ready for review";
    public const IN_REVIEW = "In Review";
    public const READY_FOR_QA = "Ready for QA";
    public const IN_QA = "In QA";
    public const DENIED = "Denied";
    public const ACCEPTED_WITH_ISSUES = "Accepted with issues";
    public const CONFIRMED = "Confirmed";
    public const READY_TO_SENT = "Ready to sent";
    public const SENT = "Sent";
}