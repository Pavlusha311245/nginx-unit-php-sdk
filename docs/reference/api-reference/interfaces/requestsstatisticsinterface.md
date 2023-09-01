# RequestsStatisticsInterface



```php
interface RequestsStatisticsInterface
{
    /**
     * Return all requests statistics
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Return total requests statistics
     *
     * @return int
     */
    public function getTotalRequests(): int;
}

```
