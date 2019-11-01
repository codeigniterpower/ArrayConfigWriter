<?php

ini_set('error_reporting', E_ALL);;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once dirname(__DIR__).'/class-array-config-writer.php';


class Array_Config_Writer_Multi_Test extends  \PHPUnit\Framework\TestCase {

    /**
     * @var string Path to config file to write 
     */
    public $configFile;

    /**
     * @var Array_Config_Writer 
     */
    public $configWriter;

    public $testDir;


    public function setup()
    {
        $this->testDire = dirname(__DIR__);
        $config_src = __DIR__.'/multi-config-src.php';
        $config = __DIR__.'/config-multi.php';
        $this->configFile = $config;
        file_put_contents($config, file_get_contents($config_src));        
    }

    public function testConstructor()
    {
        $writer = new Array_Config_Writer($this->configFile);
        $this->assertInstanceOf( 'Array_Config_Writer',  $writer);
        $this->assertEmpty($writer->getLastError(), 'Should not have error');
        
        return $writer;
    }    

     /**
     * @depends testConstructor
     * @covers setVariableName getVariableName
     */
    public function testSetVariableName($writer)
    {
        $writer->setVariableName('db');
        $this->assertEquals('\$db', $writer->getVariableName(), 'Sets the variable name and prepend dollar sign');
        
        $writer->setVariableName('$db');
        $this->assertEquals('\$db', $writer->getVariableName(), 'Sets the variable name and ignores dollar sign');
        
        return $writer;
    }
   

    /**
     * @depends testSetVariableName
     * 
     * @covers write setDestinationFile
     */
    public function testWrite($writer)
    {

        $writer->setAutoSave(false);

        //change destination
        $writer->setDestinationFile(__DIR__.'/custom-destination.php');

        $writer->write(['default', 'host'], 'example.com');
        
        $writer->save();

        //file name has been changed
        $config = require __DIR__.'/custom-destination.php';

        $this->assertTrue(is_array($config));
        $this->assertTrue(is_array($config[1]));
        $this->assertArrayHasKey('default', $config[1]);
        $this->assertArrayHasKey('host', $config[1]['default']);
        $this->assertEquals('example.com', $config[1]['default']['host']);
        
        $this->assertFalse($writer->hasError());
    }
    
}