api-php
==========

A php package to connected to the Genkgo System


## Using

After installing the application you can use the Genkgo Api

```php
<?php
require_once __DIR__."/../vendor/autoload.php";

use Genkgo\Api\GenkgoApi;
$api = new GenkgoApi('','');

var_dump($results);

```

## Testing

* Copy test-settings.php.sample to test-settings.php
* Change the url to your domain
* Change the Api key to a key given by the Genkgo system
* Make sure the entry with api key has rights to execute your operations

run the test script
```bash
phpunit tests
```

## Info

* [https://github.com/genkgo/api-docs](https://github.com/genkgo/api-docs)
* [https://www.genkgo.com/](https://www.genkgo.com/)
