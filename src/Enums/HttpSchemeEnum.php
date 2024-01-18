<?php

namespace UnitPhpSdk\Enums;

/**
 * List of HTTP schemes
 */
enum HttpSchemeEnum: string
{
    /**
     * HTTP scheme
     */
    case HTTP = 'http';

    /**
     * HTTPS scheme
     */
    case HTTPS = 'https';

    /**
     * @return HttpSchemeEnum[]
     */
    public static function getValues(): array
    {
        return [
            self::HTTP,
            self::HTTPS,
        ];
    }
}
