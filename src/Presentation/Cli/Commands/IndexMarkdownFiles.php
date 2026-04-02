<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Presentation\Cli\Commands;

use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use thofman\KnowledgeBase\Application\Index\IndexService;
use thofman\KnowledgeBase\Command\BaseCommand;
use thofman\KnowledgeBase\Domain\MarkdownFile\Index\IndexMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;

#[AsCommand(name: 'app:index-markdown-files', description: 'Index markdown files and regenerate _index.md')]
final class IndexMarkdownFiles extends BaseCommand
{
    public function __construct(
        private readonly IndexService $indexService,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $pathnameDirectory = __DIR__ . '/../../../../knowledge-base-markdown-files';
        $pathnameIndexFile = $pathnameDirectory . '/_index.md';
        $this->indexService->reindexIndexMarkdownFile(
            new MarkdownFilesDirectory(new SplFileInfo($pathnameDirectory)),
            new IndexMarkdownFile(new MarkdownFile(new SplFileInfo($pathnameIndexFile)))
        );
        return Command::SUCCESS;
    }
}
