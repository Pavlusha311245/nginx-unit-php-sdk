<?php

namespace UnitPhpSdk\Enums;

/**
 * https://datatracker.ietf.org/doc/html/rfc7231#section-4
 * https://datatracker.ietf.org/doc/html/rfc5789#section-2
 */
enum HttpMethodsEnum: string
{
    /**
     * The GET method requests transfer of a current selected representation for the target resource.
     * GET is the primary mechanism of information retrieval and the focus of almost all performance optimizations.
     * Hence, when people speak of retrieving some identifiable information via HTTP, they are generally referring to making a GET request.
     * Unless otherwise specified, the GET method is assumed when making an HTTP request.
     */
    case GET = 'GET';

    /**
     * The HEAD method asks for a response identical to that of a GET request, but without the response body.
     */
    case HEAD = 'HEAD';

    /**
     * The POST method requests that the target resource process the representation enclosed in the request according to the resource's own specific semantics.
     * For example, POST is used for the following functions (among others):
     * - Providing a block of data, such as the fields entered into an HTML form, to a data-handling process;
     * - Posting a message to a bulletin board, newsgroup, mailing list, blog, or similar group of articles;
     * - Creating a new resource that has yet to be identified by the origin server; and
     * - Appending data to a resource's existing representation(s).
     */
    case POST = 'POST';

    /**
     * The PUT method requests that the state of the target resource be created or replaced with the state defined by the representation enclosed in the request message payload.
     */
    case PUT = 'PUT';

    /**
     * The DELETE method requests that the origin server remove the association between the target resource and its current functionality.
     */
    case DELETE = 'DELETE';

    /**
     * The CONNECT method establishes a tunnel to the server identified by the target resource.
     */
    case CONNECT = 'CONNECT';

    /**
     * The OPTIONS method requests information about the communication options available for the target resource,
     * at either the origin server or an intervening intermediary.
     */
    case OPTIONS = 'OPTIONS';

    /**
     * The TRACE method requests a remote, application-level loop-back of the request message.
     */
    case TRACE = 'TRACE';

    /**
     * The PATCH method requests that a set of changes described in the request entity be applied to the resource identified by the Request-URI.
     */
    case PATCH = 'PATCH';

    /**
     * Returns an array of available HTTP methods.
     *
     * @return string[] An array containing the available HTTP methods.
     */
    public static function getValues(): array
    {
        return [
            self::GET,
            self::HEAD,
            self::POST,
            self::PUT,
            self::DELETE,
            self::CONNECT,
            self::OPTIONS,
            self::TRACE,
            self::PATCH,
        ];
    }
}
