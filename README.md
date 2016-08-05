Highway (Beta)
===============


A Laravel 5.0+ package that facilitates easy and simple transferring of data between different data storage and format types (CSV, Databases)

Coming Soon - (XML, JSON, YAML, Eloquent Models)

> Note: All Larablocks packages will have releases in line with the major Laravel framework version release. 
(Ex. Highway 5.2.* is tested to work with Laravel 5.2.* while Highway 5.1.* is tested to worked with Laravel 5.1.*)

## Installation

Add `larablocks/highway` as a requirement to `composer.json`:

```javascript
{
    "require": {
        "larablocks/highway": "~0.1"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

## Laravel Integration

To wire this up in your Laravel project you need to add the service provider. Open `app.php`, and add a new item to the providers array.

```php
Larablocks\Highway\HighwayServiceProvider::class,
```

Then you may add a Facade for more convenient usage. In your `app.php` config file add the following line to the `aliases` array.

```php
'Highway' => Larablocks\Highway\Highway::class,
```

Note: The Highway facade will load automatically, so you don't have to add it to the `app.php` file but you may still want 
to keep record of the alias.

To publish the default config file `config/highway.php` use the artisan command: 

`php artisan vendor:publish --provider="Larablocks\Highway\HighwayServiceProvider"`

## Usage as a Facade

```php
Highway::
```

## Format Readers

Highway allows for you to read from one content format. First add the content format type and configuration for the format you
would like Highway to read from.

```php
Highway::addReader($type, $config_options[])
```

#### CSV Reader
```php

$configs = [
    'file_path' => 'path_to_csv_file')] // required
    'delimiter' => 'delimter string')]  // optional, defaults to ','
    'enclosure' => 'enclosure string')] // optional, defaults to '"'
]


Highway::addReader('csv', $configs)
```

#### Database Reader
```php

$configs = [
    'table' => 'table_to_read_from')] // required 
    'results' => 'query builder results from table'  // optional else returns all results from table  Ex. 'results' => DB::table('users')->where('first_name', 'John')->get()
]

Highway::addReader('database', $configs)
```


## Format Writers

Highway allows for you to write to multiple content formats. After you have set up your one reader you may include multiple writers. Add these content format types and their configurations.

```php
Highway::addWriter($type, $config_options[])
```

#### CSV Writer
```php

$configs = [
    'file_path' => 'path_to_csv_file')] // required
    'delimiter' => 'delimter string')]  // optional, defaults to ','
    'enclosure' => 'enclosure string')] // optional, defaults to '"'
]


Highway::addWriter('csv', $configs)
```


#### Database Writer
```php

$configs = [
    'table' => 'table_to_write_to')] // required 
]

Highway::addWriter('database', $configs)
```

## Run the Process

Once at least one reader and writer have been added you may run the process of transferring the data.

```php
Highway::run()
```

## Examples


#### Single Writer Example

```php
Highway::addReader('database', ['table' => 'users', 'results' => DB::table('users')->where('first_name', 'Devin')->get()]);
Highway::addWriter('csv', ['file_path' => public_path('export/users.csv')]);
Highway::run();
```

#### Multiple Writer Example

```php
Highway::addReader('database', ['table' => 'users']);
Highway::addWriter('csv', ['file_path' => public_path('export/users.csv')]);
Highway::addWriter('csv', ['file_path' => public_path('export/users-tab-delimited.csv'), 'delimiter' => "\t", 'enclosure' => "'"]);
Highway::run();
```

## License

Highway is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)