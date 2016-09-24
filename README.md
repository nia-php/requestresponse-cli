# nia - CLI request response pattern

Implementation of the request response pattern for the CLI environment. This implementation does not support an interactive mode nor the stdin.

## Installation

Require this package with Composer.

```bash
	composer require nia/requestresponse-cli
```

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/

## How to use
The following sample shows you how to use the CLI request response component for a CLI script. For routing and presenting the `nia/routing` and `nia/presenter` component can be used.

```php
	#! /usr/bin/php
	<?php
	// file: bin/cli

	use Nia\RequestResponse\Cli\CliRequest;
	use Nia\RequestResponse\Cli\CliResponse;

	require_once __DIR__ . '/../vendor/autoload.php';

	// create the request.
	$request = new CliRequest($_SERVER['argv'], STDIN);

	// [...]
	//
	//  routing:
	//      [...]
	//  controller/presenter:
	//      $response = $request->createResponse();
	//      $response->set<XYZ>(...);
	//
	// [...]

	// send the response.
	echo $response->getContent();
	exit ($response->getStatusCode());
```
