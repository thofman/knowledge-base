#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use thofman\KnowledgeBase\Application\Index\IndexService;
use thofman\KnowledgeBase\Command\AddArticle;
use thofman\KnowledgeBase\Infrastructure\FrontMatter\SpatieYamlFrontMatterRepository;
use thofman\KnowledgeBase\Infrastructure\MarkdownFile\GlobMarkdownFileRepository;
use thofman\KnowledgeBase\Presentation\Cli\Commands\IndexMarkdownFiles;

$application = new Application();
$application->addCommand(new AddArticle());
$application->addCommand(
    new IndexMarkdownFiles(
        new IndexService(
            new GlobMarkdownFileRepository(),
            new SpatieYamlFrontMatterRepository(),
        ),
    )
);
$application->run();
