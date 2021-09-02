[![php: >=5.3.0](https://img.shields.io/badge/php->=5.3-8892BF.svg)](https://php.net/) 
[![Linux ready](https://img.shields.io/badge/linux-ready-success)](https://debian.org)

# Codeigniter Array ConfigWriter 

This php library can be used to update array config valuies dinamically of codeigniter.
The library can be used by applications that use php array to store configuration values. 
It makes updating config array possible programatically.

## Requirements

* Codeigniter 2.x or 3.x
* PHP 5.3; GD module need for image loading and preview

## Installation

The folder structure should match the CodeIgniter directory structure.
Download the library and extract it to `libraries` in your application.

### Quick setup

1. Copy the `application/libraries/ConfigWriter.php` file to `application/libraries/`
2. Initialise the ConfigWriter library and include it in your controller or whatever. Example below:

        public function myform()
        {
                $this->load->library('ConfigWriter', 'config.php', 'configwriter');
                $this->configwriter->write('index_page' , 'index2.php' );
        }

If you checked your `applications/config/config.php` will see how the line `$config['index_page'] = 'index.php';`
changed to `$config['index_page'] = 'index2.php';` magically!


## Configuration options

There are some configuration options which you can pass to the library in an associative array when you
performed in code  `$this->configwriter->init($config)` or by constructor like `$this->load->library('ConfigWriter', $config);`

* **file**: (string) This should be set to the file that you want to alter config array. It will default to `config.php`, each name will assume `applications/config/` as search path.
* **variable_name** (string) : The variable name of the array  to update. It will default to `$config`.as in file of codeignoter in `config.php`.
* **auto_save** (boolean) : Whether the library should automatically save the changes. It will default to `TRUE`.

## USAGE

**note** You can not use the library to update the following format: 

```php
$config = array( 'key' => 'value' );
```
A complex code sample to change dinamically the database settings:

```php
    $init = array();
    $init['file'] = 'database.php';
    $init['variable_name'] = 'db';
    $this->load->library('ConfigWriter', $initialization, 'configwriter');
    $this->configwriter->write( array('default' , 'hostname') , 'my_hostname' );
    $this->configwriter->write( array('default' , 'username') , 'my_username' );
    $this->configwriter->write( array('default' , 'pconnet') , FALSE );
```

**Notes:** 
* You can set value to any php variable type. 
* The library treats numeric index "as is". Meaning '21' is different from 21

## Method chaining 

```php
    $config_writer->write('site_name' , "New Site Name' )->write('enable_caching' , false );
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
    
## Credits

This is specific AD-HOC folk for Codeigniter-powered, see original project for.

- Copyright © Wakeel Ogunsanya - https://github.com/hollax/ArrayConfigWriter

