# Array Config Writer 

This php library can be used to update array values in php a file.
Some applications use php array to store configuration values and to update the values
users will have to manually open the configuration file and update the value.

This library makes the task of updating the array easy. You programmatically update 
the values of the array.

##Installation 

* Download the library and extract it in a folder of your application. The folder choice depends on your application.


##Usage
* Include the class library to be available for usage `require_once 'class-array-config-writer.php';`
* Create an instance of  `Array_Config_Writer` class for the file that holds the php array we want to update

    $config_writer = new Array_Config_Writer($config_file, $variable_name , $auto_save );

Where :

* **$config_file** (string) : The absolute path to the file where the array is place 
* **$variable_name** (string) : The variable name of the array we want to update 
* **$auto_save** (boolean) : Whether to automatically save the changes after the operation

Supported variable Styles:
* `Single index $config[ 'key'] = 'value' ;`
* `Multi dimensional $config['key1']['key2'] = 'value';`

You can not use the library to update something like `$config = array( 'key' => 'value' );`

**Notes:** 
* The library expect the variable to be indexed 
* The file can have other variables aside our target variable


Now you can start updating the index of the array like this 

    $config_writer->write('key' , value );

**Note:** 
* You can set value to any php variable type 
* The library treats numeric index as it is. Meaning '21' is different from 21

##Examples

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

Create an instance of the library

    $config_writer = new Array_Config_Writer( APP_PATH.'config/config.php', 'config' );
     
    // update the site name

    $config_writer->write('site_name' , "New Site Name' );

## Method chaining 

    $config_writer->write('site_name' , "New Site Name' )->write('enable_caching' , false );


To update the `'message'` index which has array has value

* First get the current value 

    $meesage = $config['message'];

* Then change its value(s) 
    
    $message['title'] = 'My New title' ;
    $message['body'] = 'New message body' ;

* Or completely set new array for the message index
    
    // assuming the admin sent a form, Just an example, you should validate user post! :d
    $message = $_POST['message'];

* Save it with the library 

    $config_writer->write('message' , $message );

[Read More](http://hollax.github.io/ArrayConfigWriter)
