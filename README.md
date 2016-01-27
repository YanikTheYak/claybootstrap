# Clay Boostrap package for Laravel 4.3

## Installation

```bash
"cyberduck/claybootstrap": "dev-master"
```

After adding the key, run composer update from the command line to install the package:

```bash
composer update
```

Add the service provider to the `providers` array in your `app/config/app.php` file.

```php
'Clay\Bootstrap\Providers\BootstrapServiceProvider',
'Clay\Bootstrap\Providers\HtmlServiceProvider',
```

Add the alias to the `aliases` array

```php
'Field' => 'Clay\Bootstrap\Facades\Field',
'Alert' => 'Clay\Bootstrap\Facades\Alert',
```

### Translations

Translations for labels are automatically picked up from app/lang/formlabels.php or the `attributes` key within app/lang/validation.php.