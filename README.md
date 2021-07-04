[![Build Status](https://travis-ci.org/hollax/ArrayConfigWriter.svg?branch=develop)](https://travis-ci.org/hollax/ArrayConfigWriter)
[![Coverage Status](https://coveralls.io/repos/github/hollax/ArrayConfigWriter/badge.svg?branch=develop)](https://coveralls.io/github/hollax/ArrayConfigWriter?branch=master)
[![php: >=5.3.0](https://img.shields.io/badge/php->=5.3-8892BF.svg)](https://php.net/) 

# Array Config Writer 

This php library can be used to update array values in a php  file.
The library can be used by applications that use php array to store configuration values. It makes updating config array possible programatically.

## Installation 

* Download the library and extract it to a folder in your application. The folder choice depends on your application structure.

## Usage
* `include` the class library in your script

    ```php 
require_once 'class-array-config-writer.php';```

**The class supports autoload via composer**

* Create an instance of  `Array_Config_Writer` class for the file that needs to be updated:

```php
$config_writer = new Array_Config_Writer($config_file, $variable_name , $auto_save );
```

Where :

* **$config_file** (string) : The absolute path to the file where the array is declared. 
* **$variable_name** (string) : The variable name of the array  to update. 
* **$auto_save** (boolean) : Whether the library should automatically save the changes.

We can start updating values:

```
$config_writer->write('key' , value );
```

**Notes:** 
* You can set value to any php variable type. 
* The library treats numeric index "as is". Meaning '21' is different from 21

Supported variable Styles:

1. Single index
```php
 $config[ 'key'] = 'value' ;
```

2. Multi dimensional

* ```php
$config['key1']['key2'] = 'value';
```

**note** You can not use the library to update the following format: 

```php
$config = array( 'key' => 'value' );
```

**Notes:** 
* The library expect the variable to be indexed. 
* The file can have other variables aside our target variable.

## Examples

**PHP File** config.php

```php
    /*
    |--------------------------------------------------------------------------
    | Site Name
    |--------------------------------------------------------------------------
    |
    | 
    |
    */
    $config[ 'site_name'] = 'Example Site';


    /*
    |--------------------------------------------------------------------------
    |  Enable caching
    |-------------------==-------------------------------------------------------
    |
    |
    */
    $config[ 'enable_caching'] = true;

    /*
    |--------------------------------------------------------------------------
    |  Custom Array
    |-------------------==-------------------------------------------------------
    |
    |
    */
    $config[ 'message'] = array(
                                'title' => 'Welcome' ,
                                 'body' => 'Thanks for your interest in the library'
                            );


    /*
    |--------------------------------------------------------------------------
    |  Another Config Variable for the database 
    |-------------------==-------------------------------------------------------
    |
    |
    */
    $db[ 'database'] =  '';
    $db[ 'username'] =  '';
```

Create an instance of the library:

```php
    $config_writer = new Array_Config_Writer( APP_PATH.'config/config.php', 'config' );
```

 Update a value by index. The *site_name* for instance:
 
```php
    $config_writer->write('site_name' , "New Site Name' );
```
The file *config.php* should be updated

## Method chaining 

```php
    $config_writer->write('site_name' , "New Site Name' )
    ->write('enable_caching' , false );
```


To update the `'message'` index which has array has value

* First get the current value 

```php
$message = $config['message'];
```

* Then change its value(s)
    
```php
    $message['title'] = 'My New title' ;
    $message['body'] = 'New message body' ;
```

* Or completely set new value for the message index
(assuming the admin posted form. Ideally you would validate submission)

`$message = $_POST['message'];`


* Save it with the library 

    `$config_writer->write('message' , $message );`
    
## Testing
You need phpunit to run the test cases

`$ phpunit`

[Read More](http://hollax.github.io/ArrayConfigWriter)
