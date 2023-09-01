# StatisticInterface

```php
interface StatisticsInterface
{
    /**
     * Get connections
     *
     * @return ConnectionsStatisticsInterface
     */
    public function getConnections(): ConnectionsStatisticsInterface;

    /**
     * Get requests
     *
     * @return RequestsStatisticsInterface
     */
    public function getRequests(): RequestsStatisticsInterface;

    /**
     * Get an applications
     *
     * @return array
     */
    public function getApplications(): array;

    /**
     * Get application statistics
     *
     * @param ApplicationAbstract|string $application
     * @return ApplicationsStatisticsInterface
     */
    public function getApplicationStatistics(ApplicationAbstract|string $application): ApplicationsStatisticsInterface;
}
```
