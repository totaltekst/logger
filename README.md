# Totaltekst logger

## Enables logging through monolog or Google logs



## Requirements
- PHP 8.0+

**Note** To use Google logging, you need to make sure the application has google credentials set. (Normally through env var GOOGLE_APPLICATION_CREDENTIALS).

## Installation

Install the latest version with

```bash
composer require totaltekst/logger
```

## Basic Usage for Google logging

```php
<?php

use Totaltekst\Logger\Log;

// Setup to use Google logger, level DEBUG
Log::init_logger('my_app_name', Level::Debug, 'google', 'my-project-id');

// Write to the log using static methods:
Log::alert('Starting up my app', ["data" => $args]);
# 
# 
Log::info('Shutting down');

```

## Basic usage for logging to errorlog using monolog

```php
<?php

use Totaltekst\Logger\Log;

// Setup to use monolog, level DEBUG
Log::init_logger('my_app_name', Level::Debug, 'errorlog');

// Write to the log using static methods:
Log::alert('Starting up my app', ["data" => $args]);
# 
# 
Log::info('Shutting down');

```