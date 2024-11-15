<?php

namespace UnitPhpSdk\Builders;

use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Support\Pluralizer;

/**
 * Class EndpointBuilder
 *
 * A class to build the endpoint for a given object.
 *
 * TODO: review
 */
class EndpointBuilder
{
    protected string $endpoint = '';

    /**
     * @param array|string $url
     */
    public function __construct(
        // TODO: change with http extension
        array|string $url = ''
    ) {
        $this->endpoint = '/' . (is_array($url) ? implode('/', $url) : $url);
    }

    /**
     * @param object $object
     * @return array
     */
    private static function convertNamespace(object $object): array
    {
        $fullClassName = get_class($object);
        $namespaceParts = array_map('strtolower', explode('\\', $fullClassName));
        array_shift($namespaceParts);

        return $namespaceParts;
    }

    /**
     * @param mixed|null $value
     * @return EndpointBuilder
     */
    public static function create(mixed $value = null): EndpointBuilder
    {
        $result = $value;

        if (is_a($value, Uploadable::class)) {
            $result = self::convertNamespace($value);
            $entity = Pluralizer::plural(end($result));
            array_pop($result);
            $result[] = $entity;
        }

        return new EndpointBuilder($result);
    }

    /**
     * Gets the endpoint value.
     *
     * @return string The endpoint value.
     */
    public function get(): string
    {
        return $this->endpoint;
    }
}
