<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Presentation\Cli\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use thofman\KnowledgeBase\Command\BaseCommand;

#[AsCommand(name: 'app:index-markdown-files', description: 'Index markdown files and regenerate _index.md')]
final class IndexMarkdownFiles extends BaseCommand
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('You have chosen command "IndexMarkdownFiles"');
        return Command::SUCCESS;
    }
}
