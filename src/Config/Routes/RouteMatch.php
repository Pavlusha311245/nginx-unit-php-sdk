<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Routes;

use Pavlusha311245\UnitPhpSdk\Enums\HttpMethodsEnum;
use Pavlusha311245\UnitPhpSdk\Enums\HttpSchemeEnum;

class RouteMatch
{
    /**
     * Host header field, converted to lower case and normalized by removing the port number and the trailing period (if any).
     *
     * @var string
     */
    private string $_host;

    /**
     * Method from the request line, uppercase.
     *
     * @var HttpMethodsEnum
     */
    private HttpMethodsEnum $_method;

    private string $_source;

    /**
     * Target IP address and optional port of the request.
     *
     * @var string
     */
    private string $_destination;

    /**
     * URI scheme. Accepts only two patterns, either http or https.
     *
     * @var HttpSchemeEnum
     */
    private HttpSchemeEnum $_scheme;

    /**
     * Request target, percent decoded and normalized by removing the query string and
     * resolving relative references (“.” and “..”, “//”).
     *
     * @var array|string
     */
    private array|string $_uri;

    /**
     * Arguments supplied with the request’s query string; these names and value pairs are percent decoded,
     * with plus signs (+) replaced by spaces.
     *
     * @var array
     */
    private array $_arguments;

    /**
     *    Query string, percent decoded, with plus signs (+) replaced by spaces.
     *
     * @var array
     */
    private array $_query;

    /**
     *    Cookies supplied with the request.
     *
     * @var array
     */
    private array $_cookies;

    /**
     *    Header fields supplied with the request.
     *
     * @var array
     */
    private array $_headers;

    public function __construct($data = null)
    {
        if (!empty($data)) {
            $this->parseFromArray($data);
        }
    }

    /**
     * Get method
     *
     * @return HttpMethodsEnum
     */
    public function getMethod(): HttpMethodsEnum
    {
        return $this->_method;
    }

    /**
     * @param HttpMethodsEnum $method
     */
    public function setMethod(HttpMethodsEnum $method): void
    {
        $this->_method = $method;
    }

    /**
     * Get uri
     *
     * @return array|string|null
     */
    public function getUri(): array|string|null
    {
        return $this->_uri;
    }

    /**
     * Get http scheme
     *
     * @return HttpSchemeEnum|null
     */
    public function getScheme(): ?HttpSchemeEnum
    {
        return $this->_scheme;
    }

    /**
     * Set HTTP scheme
     *
     * @param string $scheme
     * @return void
     */
    public function setScheme(string $scheme): void
    {
        $this->_scheme = match ($scheme) {
            'http' => HttpSchemeEnum::HTTP,
            'https' => HttpSchemeEnum::HTTPS,
            default => null
        };
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->_arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->_arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->_cookies;
    }

    /**
     * @param array $cookies
     */
    public function setCookies(array $cookies): void
    {
        $this->_cookies = $cookies;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->_destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination): void
    {
        $this->_destination = $destination;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->_headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->_headers = $headers;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->_host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->_host = $host;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->_query;
    }

    /**
     * @param array $query
     */
    public function setQuery(array $query): void
    {
        $this->_query = $query;
    }


    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->_source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->_source = $source;
    }


    /**
     * @param array|string $uri
     */
    public function setUri(array|string $uri): void
    {
        $this->_uri = $uri;
    }

    public function parseFromArray(array $data): void
    {
        if (array_key_exists('arguments', $data)) {
            $this->setArguments($data['arguments']);
        }

        if (array_key_exists('cookies', $data)) {
            $this->setCookies($data['cookies']);
        }

        if (array_key_exists('destination', $data)) {
            $this->setDestination($data['destination']);
        }

        if (array_key_exists('headers', $data)) {
            $this->setHeaders($data['headers']);
        }

        if (array_key_exists('host', $data)) {
            $this->setHost($data['host']);
        }

        if (array_key_exists('method', $data)) {
            $this->setMethod(HttpMethodsEnum::from(strtoupper($data['method'])));
        }

        if (array_key_exists('query', $data)) {
            $this->setQuery($data['query']);
        }

        if (array_key_exists('scheme', $data)) {
            $this->setScheme(HttpSchemeEnum::from($data['scheme'])->value);
        }

        if (array_key_exists('source', $data)) {
            $this->setSource($data['source']);
        }

        if (array_key_exists('uri', $data)) {
            $this->setUri($data['uri']);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'arguments' => $this->getArguments(),
            'cookies' => $this->getCookies(),
            'destination' => $this->getDestination(),
            'headers' => $this->getHeaders(),
            'host' => $this->getHost(),
            'method' => $this->getMethod(),
            'query' => $this->getQuery(),
            'scheme' => $this->getScheme(),
            'source' => $this->getSource(),
            'uri' => $this->getUri()
        ];
    }
}
