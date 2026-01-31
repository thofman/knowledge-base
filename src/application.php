#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use thofman\KnowledgeBase\Command\AddArticle;

$application = new Application();
$application->addCommand(new AddArticle());
$application->run();
