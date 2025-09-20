<?php

namespace UnitPhpSdk\Enums;

enum TelemetryProtocolEnum: string
{
    case HTTP = 'http';
    case GRPC = 'grpc';
}
