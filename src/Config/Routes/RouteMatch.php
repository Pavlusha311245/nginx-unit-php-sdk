<?php

namespace UnitPhpSdk\Config\Routes;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Enums\HttpSchemeEnum;

class RouteMatch implements Arrayable
{
    /**
     * Host header field, converted to lower case and normalized by removing the port number and the trailing period (if any).
     *
     * @var string
     */
    private string $host = '';

    /**
     * Method from the request line, uppercase.
     *
     * @var HttpMethodsEnum|null
     */
    private ?HttpMethodsEnum $method = null;

    private string $source = '';

    /**
     * Target IP address and optional port of the request.
     *
     * @var string
     */
    private string $destination = '';

    /**
     * URI scheme. Accepts only two patterns, either http or https.
     *
     * @var HttpSchemeEnum|null
     */
    private ?HttpSchemeEnum $scheme = null;

    /**
     * Request target, percent decoded and normalized by removing the query string and
     * resolving relative references (“.” and “..”, “//”).
     *
     * @var array|string
     */
    private array|string $uri = '';

    /**
     * Arguments supplied with the request’s query string; these names and value pairs are percent decoded,
     * with plus signs (+) replaced by spaces.
     *
     * @var array
     */
    private array $arguments = [];

    /**
     *    Query string, percent decoded, with plus signs (+) replaced by spaces.
     *
     * @var array
     */
    private array $query = [];

    /**
     *    Cookies supplied with the request.
     *
     * @var array
     */
    private array $cookies = [];

    /**
     *    Header fields supplied with the request.
     *
     * @var array
     */
    private array $headers = [];

    public function __construct($data = null)
    {
        if (!empty($data)) {
            $this->parseFromArray($data);
        }
    }

    /**
     * Get method
     *
     * @return HttpMethodsEnum|null
     */
    public function getMethod(): ?HttpMethodsEnum
    {
        return $this->method;
    }

    /**
     * @param HttpMethodsEnum $method
     */
    public function setMethod(?HttpMethodsEnum $method): void
    {
        $this->method = $method;
    }

    /**
     * Get uri
     *
     * @return array|string|null
     */
    public function getUri(): array|string|null
    {
        return $this->uri;
    }

    /**
     * Get http scheme
     *
     * @return HttpSchemeEnum|null
     */
    public function getScheme(): ?HttpSchemeEnum
    {
        return $this->scheme;
    }

    /**
     * Set HTTP scheme
     *
     * @param HttpSchemeEnum $scheme
     * @return void
     */
    public function setScheme(?HttpSchemeEnum $scheme): void
    {
        $this->scheme = $scheme;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * @param array $cookies
     */
    public function setCookies(array $cookies): void
    {
        $this->cookies = $cookies;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @param array $query
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }


    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }


    /**
     * @param array|string $uri
     */
    public function setUri(array|string $uri): void
    {
        $this->uri = $uri;
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
            if (is_string($data['method'])) {
                $httpMethod = HttpMethodsEnum::tryFrom(strtoupper($data['method']));

                if (empty($httpMethod)) {
                    throw new \InvalidArgumentException('Invalid HTTP method');
                }

                $this->setMethod($httpMethod);
            } else {
                $this->setMethod($data['method']);
            }
        }

        if (array_key_exists('query', $data)) {
            $this->setQuery($data['query']);
        }

        if (array_key_exists('scheme', $data)) {
            $this->setScheme(is_string($data['scheme']) ?
                HttpSchemeEnum::from($data['scheme']) : $data['scheme']);
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
    #[\Override] public function toArray(): array
    {
        $data = [];

        if (!empty($this->getHost())) {
            $data['host'] = $this->getHost();
        }

        if (!empty($this->getMethod())) {
            $data['method'] = $this->getMethod();
        }

        if (!empty($this->getDestination())) {
            $data['destination'] = $this->getDestination();
        }

        if (!empty($this->getScheme())) {
            $data['scheme'] = $this->getScheme();
        }

        if (!empty($this->getUri())) {
            $data['uri'] = $this->getUri();
        }

        if (!empty($this->getArguments())) {
            $data['arguments'] = $this->getArguments();
        }

        if (!empty($this->getQuery())) {
            $data['query'] = $this->getQuery();
        }

        if (!empty($this->getCookies())) {
            $data['cookies'] = $this->getCookies();
        }

        if (!empty($this->getHeaders())) {
            $data['headers'] = $this->getHeaders();
        }

        if (!empty($this->getSource())) {
            $data['source'] = $this->getSource();
        }

        return $data;
    }
}
