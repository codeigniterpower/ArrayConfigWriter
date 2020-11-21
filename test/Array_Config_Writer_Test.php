<?php

ini_set('error_reporting', E_ALL);;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

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

    public $testDir;

    public function setup()
    {
        $this->testDire = dirname(__DIR__);
        $config_src = __DIR__.'/config-src.php';
        $config = __DIR__.'/config.php';
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
     */
    public function testUpdate($writer)
    {

        $writer->write('siteName', 'Foo');
        $this->assertContains("\$config['siteName'] = 'Foo'", $writer->getContent());
        
        $writer->save();

        $config = require __DIR__.'/config.php';

        $this->assertTrue(is_array($config));
        $this->assertEquals('Foo', $config['siteName']);
        $this->assertFalse($writer->hasError());
    }

	/**
     * @depends testConstructor
     * @covers Array_Config_Writer::write
     */
    public function testUpdateInt($writer)
    {
                
        $writer->write('age', 20);
        $this->assertContains("\$config['age'] = 20", $writer->getContent());
        $this->assertContains("\$config['siteName'] = 'Foo'", $writer->getContent(), 'Changes only target');

        $writer->save();

        $config = require __DIR__.'/config.php';

        $this->assertTrue(is_array($config));
        $this->assertEquals(20, $config['age']);
        $this->assertFalse($writer->hasError());

        return $writer;

    }
	
	

    /**
     * @depends testUpdateInt
     */
    public function testUpdateArray($writer)
    {
                
        $currentConfig = require __DIR__.'/config.php';

        $this->assertEquals('New York', $currentConfig['address']['city']);
        $this->assertEquals('USA', $currentConfig['address']['country']);
        
        $newAddress = [
            'line' => 'Line One',
            'city' => 'Lagos',
            'country' => 'Nigeria'
        ];
        $writer->write('address', $newAddress);

        $this->assertContains("\$config['age'] = 20", $writer->getContent());
        $this->assertContains("\$config['siteName'] = 'Foo'", $writer->getContent(), 'Changes only target');

        $writer->save();

        $config = require __DIR__.'/config.php';

        $this->assertTrue(is_array($config));
        $this->assertTrue(is_array($config['address']));
        $this->assertEquals('Lagos', $config['address']['city']);
        $this->assertEquals('Nigeria', $config['address']['country']);
        $this->assertFalse($writer->hasError());

    }
	
	/**
     * @depends testUpdateInt
     */
    public function testUpdateArrayWithASemicolon($writer)
    {
                
        $currentConfig = require __DIR__.'/config.php';

        $this->assertEquals('New York', $currentConfig['address']['city']);
        $this->assertEquals('USA', $currentConfig['address']['country']);
        
        $newAddress = [
            'line' => 'Line One; More Line',
            'city' => 'Lagos',
            'country' => 'Nigeria'
        ];
        $writer->write('address', $newAddress);

        $this->assertContains("\$config['age'] = 20", $writer->getContent());
        $this->assertContains("\$config['siteName'] = 'Foo'", $writer->getContent(), 'Changes only target');

        $writer->save();

        $config = require __DIR__.'/config.php';

        $this->assertTrue(is_array($config));
        $this->assertTrue(is_array($config['address']));
	    $this->assertEquals('Line One; More Line', $config['address']['line']);
        $this->assertEquals('Lagos', $config['address']['city']);
        $this->assertEquals('Nigeria', $config['address']['country']);
        $this->assertFalse($writer->hasError());

    }


    /**
     * @depends testConstructor
     * @covers Array_Config_Writer::write
     */
    public function testUpdateHtml($writer)
    {
                
        $element = '<div class="color:green">Foo</div>';
        $writer->write('html_element', $element);
        $this->assertContains("\$config['html_element'] = '".$element."'", $writer->getContent());

        $writer->save();

        $config = require __DIR__.'/config.php';
        $this->assertTrue(is_array($config));
        $this->assertEquals(20, $config['age']);
        $this->assertFalse($writer->hasError());

        return $writer;

    }

    /**
     * @depends testConstructor
     * @covers Array_Config_Writer::setAutoSave Array_Config_Writer::getAutoSave
     */
    public function testSetAutoSave($writer)
    {
        $this->assertTrue($writer->getAutoSave(), 'Auto Save by default');
        $writer->setAutoSave(false);
        $this->assertFalse($writer->getAutoSave(), "Disables autosave");
        $writer->setAutoSave(true);
        $this->assertTrue($writer->getAutoSave(), 'Reset to autosave');
    }

}