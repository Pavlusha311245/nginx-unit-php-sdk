<?php

namespace UnitPhpSdk\Enums;

use UnitPhpSdk\Config\Routes\ActionType\PassAction;
use UnitPhpSdk\Config\Routes\ActionType\ProxyAction;
use UnitPhpSdk\Config\Routes\ActionType\ReturnAction;
use UnitPhpSdk\Config\Routes\ActionType\ShareAction;

enum RouteActionTypeEnum: string
{
    case PASS = PassAction::class;

    case PROXY = ProxyAction::class;

    case RETURN = ReturnAction::class;

    case SHARE = ShareAction::class;

    public static function getByType($type): RouteActionTypeEnum
    {
        return match ($type) {
            'pass' => self::PASS,
            'proxy' => self::PROXY,
            'return' => self::RETURN,
            'share' => self::SHARE,
            default => throw new \InvalidArgumentException('Invalid action type'),
        };
    }
}
