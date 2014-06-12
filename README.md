# CakePHP Mailgun Transport

Allows sending emails via Mailgun by using the provided SDK.

## Installation

* Clone or copy the files into `app/Plugin/Mailgun`
* Include the plugin in your bootstrap's `CakePlugin::load()` or use `CakePlugin::loadAll()`

OR

* Install with composer by running `composer require codaxis/cakephp-mailgun:1.*`

## Example of usage

```php
<?php

class EmailConfig {

    public $mailgun = array(
        'transport' => 'Mailgun.Mailgun',
        'mg_domain'    => 'my-domain.mailgun.org',
        'mg_api_key'   => 'my-key'
		'from' => array('no-reply@mi-website.com' => 'Mi Website'),

		// other email config
    );
}
```
