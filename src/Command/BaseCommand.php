<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Command;

use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
{
    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }

        return $this->execute($input, $output);
    }

    protected function getQuestionHelper(): QuestionHelper
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');
        return $questionHelper;
    }
}
