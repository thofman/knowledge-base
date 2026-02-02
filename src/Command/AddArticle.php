<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Command;

use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use thofman\KnowledgeBase\Tag\Tag;

#[AsCommand(name: 'app:add-article', description: 'Add an article')]
final class AddArticle extends BaseCommand
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $authorQuestion = new Question('Please enter the name of the author: ', '');
        $authorQuestion->setValidator(
            static function (string $value): string {
                if (trim($value) === '') {
                    throw new RuntimeException('Author cannot be empty');
                }

                return $value;
            }
        );
        $author = $helper->ask($input, $output, $authorQuestion);
        $output->writeln(sprintf('You have just selected: %s', $author));
        $tagQuestion = new ChoiceQuestion(
            sprintf('Select tag (defaults to %s)', Tag::AGILE->getTitle()),
            $this->getQuestionChoicesForTag(),
            Tag::AGILE->value,
        );
        $chosenTag = $helper->ask($input, $output, $tagQuestion);
        $tag = Tag::from($chosenTag);
        $output->writeln(sprintf('You have just selected: %s', $tag->getTitle()));
        return Command::SUCCESS;
    }

    private function getQuestionChoicesForTag(): array
    {
        $choices = [];
        foreach (Tag::cases() as $case) {
            $choices[$case->value] = $case->getTitle();
        }
        return $choices;
    }
}
