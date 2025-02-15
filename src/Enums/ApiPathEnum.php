<?php

namespace UnitPhpSdk\Enums;

enum ApiPathEnum: string
{
    case UNIT = '/';
    case CONFIG = '/config';
    case ROUTES = '/config/routes';
    case APPLICATIONS = '/config/applications';
    case LISTENERS = '/config/listeners';
    case UPSTREAMS = '/config/upstreams';
    case ROUTE = '/config/routes/{route}';
    case APPLICATION = '/config/applications/{application}';
    case LISTENER = '/config/listeners/{listener}';
    case UPSTREAM = '/config/upstreams/{upstream}';
    case CERTIFICATES = '/certificates';
    case CERTIFICATE = '/certificates/{certificate}';
    case STATUS = '/status';
    case ACCESS_LOG = '/config/access_log';
    case JS_MODULES = '/js_modules';
    case APPLICATION_RESET = '/config/applications/{application}/reset';
    case SETTINGS = '/config/settings';
    case HTTP = '/config/settings/http';

    public function getPath(string $name): string
    {
        return match ($this) {
            self::LISTENER => str_replace('{listener}', $name, $this->value),
            self::ROUTE => str_replace('{route}', $name, $this->value),
            self::APPLICATION, self::APPLICATION_RESET => str_replace('{application}', $name, $this->value),
            self::UPSTREAM => str_replace('{upstream}', $name, $this->value),
            self::CERTIFICATE => str_replace('{certificate}', $name, $this->value),
            default => $this->value
        };
    }
}
