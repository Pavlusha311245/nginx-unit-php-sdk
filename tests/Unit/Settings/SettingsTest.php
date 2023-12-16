<?php
use UnitPhpSdk\Config\Settings;
use function PHPUnit\Framework\assertEquals;

it('sets and gets jsmodules correctly', function(){
    // Arrange
    $settings = new Settings();
    $sampleJsModules = ['module1', 'module2'];

    // Act
    $settings->setJsmodules($sampleJsModules);

    // Assert
    assertEquals($sampleJsModules, $settings->getJsmodules());
});
