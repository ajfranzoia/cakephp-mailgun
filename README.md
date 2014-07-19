# CakePHP Mailgun Transport

Allows sending emails via Mailgun by using the provided SDK.

Supports email parameters listed in http://documentation.mailgun.com/api-sending.html#sending.

## Requirements

* PHP 5.4 or later
* Composer

## Installation

* Install with composer by running `composer require codaxis/cakephp-mailgun:1.*`
* Include the plugin in your bootstrap's `CakePlugin::load('Mailgun')` or `CakePlugin::loadAll()`

## Example of configuration

```php
<?php

class EmailConfig {

    public $mailgun = array(
        'transport' => 'Mailgun.Mailgun',
        'mg_domain'    => 'my-domain.mailgun.org',
        'mg_api_key'   => 'my-mailgun-key'
		'from' => array('no-reply@my-app.com' => 'My App'),

		// Custom mailgun email, e.g.:
        // 'o:tag' => 'tag1',
        // 'o:campaign' => 'my-campaign',
    );
}
```
