# UnitInterface



```php
/**
* Return Unit socket
*
* @return string
*/
public function getSocket(): string;

public function getAddress(): string;

public function getConfig(): ConfigInterface;

public function getStatistics(): StatisticsInterface;

public function getCertificates(): array;
 
public function setAccessLog($path, $format = null);
```
