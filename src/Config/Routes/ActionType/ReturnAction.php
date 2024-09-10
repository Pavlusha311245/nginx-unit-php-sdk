<?php

namespace UnitPhpSdk\Config\Routes\ActionType;

use OutOfRangeException;
use Override;
use UnitPhpSdk\Contracts\Arrayable;

class ReturnAction implements Arrayable
{
    public function __construct(

        /**
         * HTTP status code with a context-dependent redirect location.
         * Integer (000–999); defines the HTTP response status code to be returned.
         */
        private int    $return,

        /**
         * String URI; used if the return value implies redirection.
         *
         * @var string
         */
        private string $location = ''
    ) {
        if ($return > 999 || $return < 0) {
            throw new OutOfRangeException('Return must be between 0 and 999');
        }

        if (!empty($location)) {
            $this->setLocation($location);
        }
    }

    /**
     * @param int $return
     */
    public function setReturn(int $return): void
    {
        $this->return = $return;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getReturn(): int
    {
        return $this->return;
    }


    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Converts the object to an array.
     *
     * @return array The converted array representation of the object.
     */
    #[Override] public function toArray(): array
    {
        return [
            'return' => $this->return,
            'location' => $this->location,
        ];
    }
}
