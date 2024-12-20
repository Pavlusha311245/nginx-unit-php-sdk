<?php

use UnitPhpSdk\Config;
use UnitPhpSdk\Unit;

if (!function_exists('parse_listener_pass')) {
    /**
     * Validates the listener pass string and returns the parsed data.
     *
     * @param string $string The listener pass string to validate.
     * @return array The parsed data from the listener pass string.
     * @throws ParseError If there is an error when trying to parse the listener pass.
     */
    function parse_listener_pass(string $string): array
    {
        $pattern = "/^(applications|routes|upstreams)(\/[\w+\-]+)?(\/[\w+\-]+)?(\/[\w+\-]+)*$/";

        if (preg_match($pattern, $string, $matches)) {
            $data = [
                'type' => $matches[1],
            ];

            if (isset($matches[2])) {
                $data['name'] = $matches[2];
            }

            if (isset($matches[3])) {
                $data['target'] = $matches[3];
            }

            return $data;
        } else {
            throw new ParseError('Invalid format. The string must start with applications, routes, or upstreams, followed by up to three optional segments separated by slashes, where each segment can contain letters, digits, underscores, or hyphens.');
        }
    }
}
