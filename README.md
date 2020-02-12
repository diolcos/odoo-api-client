Odoo API Client
====
A simple XML-RPC wrapper library for Odoo. For the time being, only a very limited set of Odoo API calls is exposed.

Installation via Composer
-------------------------
The recommended method to install _Odoo API Client_ is through [Composer](http://getcomposer.org).

1. Add ``diolcos/odoo-api-client`` as a dependency in your project's ``composer.json``:

    ```json
        {
            "require": {
                "diolcos/odoo-api-client": "~0.1"
            }
        }
    ```

2. Download and install Composer:

    ```bash
        curl -s http://getcomposer.org/installer | php
    ```

3. Install your dependencies:

    ```bash
        php composer.phar install --no-dev
    ```

4. Require Composer's autoloader

    Composer also prepares an autoload file that's capable of autoloading all of the classes in any of the libraries that it downloads. To use it, just add the following line to your code's bootstrap process:

    ```php
    <?php

    use OdooApiClient\XmlRpcApiWrapper as OdooXmlRpcApiWrapper;
    
    require_once 'vendor/autoload.php';
    ```
You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at [getcomposer.org](http://getcomposer.org).

You'll notice that the installation command specified `--no-dev`.  This prevents Composer from installing the various testing and development dependencies.  For average users, there is no need to install the test suite. If you wish to contribute to development, just omit the `--no-dev` flag to be able to run tests.

Example
---

```php
<?php

use OdooApiClient\XmlRpcApiWrapper as OdooXmlRpcApiWrapper;
use OdooApiClient\Entities\Contacts as OdooContacts;

require_once 'vendor/autoload.php';

$odooApiWrapper = new OdooXmlRpcApiWrapper([
    'url'       => "http://odoo.my.site",
    'db'        => "my_odoo_db",
    'username'  => "myuser@example.com",
    'password'  => "example_password",
]);

$odooContacts = new OdooContacts($odooApiWrapper);
$contacts = $odooContacts->list();

print_r($contacts);
```
