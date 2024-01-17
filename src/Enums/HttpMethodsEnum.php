<?php

namespace UnitPhpSdk\Enums;

/**
 * https://datatracker.ietf.org/doc/html/rfc7231#section-4
 * https://datatracker.ietf.org/doc/html/rfc5789#section-2
 */
enum HttpMethodsEnum: string
{
    case GET = 'GET';
    case HEAD = 'HEAD';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case CONNECT = 'CONNECT';
    case OPTIONS = 'OPTIONS';
    case TRACE = 'TRACE';
    case PATCH = 'PATCH';
}
