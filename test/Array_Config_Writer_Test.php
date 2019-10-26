<?php


require_once dirname(__DIR__).'/class-array-config-writer.php';


class Array_Config_Writer_Test extends  \PHPUnit\Framework\TestCase {

    /**
     * @var string Path to config file to write 
     */
    public $configFile;

    /**
     * @var Array_Config_Writer 
     */
    public $configWriter;


    public function setup()
    {
        $config_src = __DIR__.'/config-src.php';
        $config = __DIR__.'/config.php';
        $this->configFile = $config;
        file_put_contents($config, file_get_contents($config_src));        
    }

    public function testConstructor()
    {
        $this->configWriter = new Array_Config_Writer($this->configFile);
        $this->assertInstanceOf( Array_Config_Writer::class,  $this->configWriter);
        $this->assertEmpty($this->configWriter->getLastError(), 'Should not have error');
    }

    public function testConstructorError()
    {
        $config_writer = new Array_Config_Writer('DummyFile.php');
        $this->assertNotEmpty($config_writer->getLastError(), 'Should have file not found error');
    }
}