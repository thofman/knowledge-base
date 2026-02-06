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

                return htmlspecialchars(strip_tags($value));
            }
        );
        $author = $helper->ask($input, $output, $authorQuestion);
        $output->writeln(sprintf('You have just selected: %s', $author));
        $titleQuestion = new Question('Please enter the title of the article: ', '');
        $titleQuestion->setValidator(
            static function (string $value): string {
                if (trim($value) === '') {
                    throw new RuntimeException('Title cannot be empty');
                }

                return htmlspecialchars(strip_tags($value));
            }
        );
        $title = $helper->ask($input, $output, $titleQuestion);
        $output->writeln(sprintf('You have just typed: %s', $title));
        $urlQuestion = new Question('Please enter the URL of the article: ', '');
        $urlQuestion->setValidator(
            static function (string $value): string {
                if (trim($value) === '') {
                    throw new RuntimeException('URL cannot be empty');
                }

                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    throw new RuntimeException('Value is not a URL');
                }

                if (parse_url($value, PHP_URL_SCHEME) !== 'https') {
                    throw new RuntimeException('URL must be secure (https)');
                }

                return htmlspecialchars(strip_tags($value));
            }
        );
        $url = $helper->ask($input, $output, $urlQuestion);
        $output->writeln(sprintf('You have just typed: %s', $url));
        $tagQuestion = new ChoiceQuestion(
            sprintf('Select tag (defaults to %s)', Tag::AGILE->getTitle()),
            $this->getQuestionChoicesForTag(),
            Tag::AGILE->value,
        );
        $chosenTag = $helper->ask($input, $output, $tagQuestion);
        $tag = Tag::from($chosenTag);
        $output->writeln(sprintf('You have just selected: %s', $tag->getTitle()));
        $descriptionQuestion = new Question('Please enter the description of the article (optional): ', null);
        $descriptionQuestion->setValidator(
            static fn(?string $value): ?string => $value ? htmlspecialchars(strip_tags($value)) : null
        );
        $description = $helper->ask($input, $output, $descriptionQuestion);
        $output->writeln(sprintf('You have just typed: %s', $description ?: ''));
        $output->writeln(
            implode(
                PHP_EOL,
                [
                    '--------------------',
                    'Summary:',
                    sprintf('Author: %s', $author),
                    sprintf('Title: %s', $title),
                    sprintf('URL: %s', $url),
                    sprintf('Tag: %s', $tag->getTitle()),
                    sprintf('Description: %s', $description ?: ''),
                    '--------------------',
                ]
            )
        );
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
