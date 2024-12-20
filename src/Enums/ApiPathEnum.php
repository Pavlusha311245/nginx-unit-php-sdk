<?php

namespace UnitPhpSdk\Enums;

enum ApiPathEnum: string
{
    case UNIT = '/unit';
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
}
