# Totaltekst logger

## Enables logging through monolog or Google logs

## Installation

Install the latest version with

```bash
composer require totaltekst/logger
```

## Basic Usage

```php
<?php

use Totaltekst\Logger\Log;

// Setup to use google logger, level DEBUG
Log::init_logger('my_app_name', Level::Debug, 'google');

// Write to the log using static methods:
Log::alert('Starting up my app', ["data" => $args]);
# 
# 
Log::info('Shutting down');

```