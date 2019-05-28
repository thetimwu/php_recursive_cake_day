#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Console\Application;
use Console\MyCommand1;

/**
* Author: Tim WU
*/
$app = new Application('Console App', 'v1.0.0');
$app -> add(new MyCommand1());
$app -> run();