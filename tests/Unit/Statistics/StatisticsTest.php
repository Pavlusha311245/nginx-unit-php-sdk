use UnitPhpSdk\Contracts\ApplicationStatisticsInterface;
use UnitPhpSdk\Contracts\ConnectionsStatisticsInterface;
use UnitPhpSdk\Contracts\RequestsStatisticsInterface;
use UnitPhpSdk\Contracts\ModuleStatisticsInterface;
use UnitPhpSdk\Statistics\Statistics;
use UnitPhpSdk\Statistics\ApplicationStatistics;
use UnitPhpSdk\Statistics\ModuleStatistics;

$statData = [
'modules' => [
['version' => '1.0.0', 'lib' => '/path/to/modulelib.so'],
],
'connections' => [
'accepted' => 7,
'active' => 2,
'idle' => 5,
'closed' => 2,
],
'requests' => [
'total' => 50,
],
'applications' => [
'application1' => [
'requests' => [
'active' => 0,
],
'processes' => [
'running' => 14,
'starting' => 0,
'idle' => 4,
],
],
],
];

$moduleData = $statData['modules'][0];
$connectionsData = $statData['connections'];
$appData = $statData['applications']['application1'];

it('tests connections methods', function () use ($statData, $connectionsData) {
$statistics = new Statistics($statData);
expect($statistics->getConnections())->toBeInstanceOf(ConnectionsStatisticsInterface::class);
expect($statistics->getConnections()->getActiveConnections())->toBe($connectionsData['active']);
});

it('tests requests methods', function () use ($statData) {
$statistics = new Statistics($statData);
expect($statistics->getRequests())->toBeInstanceOf(RequestsStatisticsInterface::class);
});

it('tests applications methods', function () use ($statData, $appData) {
$statistics = new Statistics($statData);
$expectedApplicationStatistics = new ApplicationStatistics($appData);
$application = 'application1';
expect($statistics->getApplications())->toBeArray();
expect($statistics->getApplicationStatistics($application))->toBeInstanceOf(ApplicationStatisticsInterface::class);
expect($statistics->getApplicationStatistics($application)->getActiveRequests())->toBe($expectedApplicationStatistics->getActiveRequests());
expect($statistics->getApplicationStatistics($application)->getProcesses())->toEqual($expectedApplicationStatistics->getProcesses());
expect($statistics->getApplicationStatistics($application)->getRunningProcesses())->toBe($expectedApplicationStatistics->getRunningProcesses());
expect($statistics->getApplicationStatistics($application)->getStartingProcesses())->toBe($expectedApplicationStatistics->getStartingProcesses());
expect($statistics->getApplicationStatistics($application)->getIdleProcesses())->toBe($expectedApplicationStatistics->getIdleProcesses());
expect($statistics->getApplicationStatistics($application)->getRequests())->toBeArray();
});

it('throws exception for invalid application', function () use ($statData) {
$statistics = new Statistics($statData);
$this->expectException(InvalidArgumentException::class);
$this->expectExceptionMessage('Application with name nonexistentApplication not found');
$statistics->getApplicationStatistics('nonexistentApplication');
});

it('tests modules methods', function () use ($statData, $moduleData) {
$statistics = new Statistics($statData);
$expectedModuleStatistics = new ModuleStatistics($moduleData);
$module = '1.0.0'; // Assuming version is used for identifying modules
expect($statistics->getModules())->toBeArray();
expect($statistics->getModules()[0])->toBeInstanceOf(ModuleStatisticsInterface::class);
expect($statistics->getModules()[0]->getVersion())->toBe($expectedModuleStatistics->getVersion());
expect($statistics->getModules()[0]->getLibPath())->toBe($expectedModuleStatistics->getLibPath());
});

it('throws exception for invalid module', function () use ($statData) {
$statistics = new Statistics($statData);
$this->expectException(InvalidArgumentException::class);
$this->expectExceptionMessage('Module with name nonexistentModule not found');
$statistics->getModuleStatistics('nonexistentModule');
});

it('tests toArray method', function () use ($statData) {
$statistics = new Statistics($statData);
expect($statistics->toArray())->toBeArray();
expect($statistics->toArray())->toEqual($statData);
});

it('tests toJson method', function () use ($statData) {
$statistics = new Statistics($statData);
$json = $statistics->toJson();
expect($json)->toEqual(json_encode($statData));
});