<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use thofman\KnowledgeBase\App\Question\TagQuestion;
use thofman\KnowledgeBase\App\Question\TextQuestion;
use thofman\KnowledgeBase\Domain\Question\Sanitization\StringSanitizer;
use thofman\KnowledgeBase\Domain\Question\Tag;
use thofman\KnowledgeBase\Domain\Question\Validation\AlwaysValidValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\CompositeValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\NonEmptyStringValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\UrlSchemeHttpsValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\UrlValidator;

#[AsCommand(name: 'app:add-article', description: 'Add an article')]
final class AddArticle extends BaseCommand
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $questionHelper = $this->getQuestionHelper();
        $authorQuestion = new TextQuestion(
            'Please enter the name of the author: ',
            new NonEmptyStringValidator('Author'),
            new StringSanitizer(),
        );
        $author = $questionHelper->ask($input, $output, $authorQuestion->getQuestion());
        $output->writeln(sprintf('You have just selected: %s', $author));
        $titleQuestion = new TextQuestion(
            'Please enter the title of the article: ',
            new NonEmptyStringValidator('Title'),
            new StringSanitizer(),
        );
        $title = $questionHelper->ask($input, $output, $titleQuestion->getQuestion());
        $output->writeln(sprintf('You have just typed: %s', $title));
        $urlQuestion = new TextQuestion(
            'Please enter the URL of the article: ',
            new CompositeValidator(
                [
                    new NonEmptyStringValidator('URL'),
                    new UrlSchemeHttpsValidator(new UrlValidator()),
                ]
            ),
            new StringSanitizer(),
        );
        $url = $questionHelper->ask($input, $output, $urlQuestion->getQuestion());
        $output->writeln(sprintf('You have just typed: %s', $url));
        $tagQuestion = new TagQuestion();
        $chosenTag = $questionHelper->ask($input, $output, $tagQuestion->getQuestion());
        $tag = Tag::from($chosenTag);
        $output->writeln(sprintf('You have just selected: %s', $tag->value));
        $descriptionQuestion = new TextQuestion(
            'Please enter the description of the article (optional): ',
            new AlwaysValidValidator(),
            new StringSanitizer(),
        );
        $description = $questionHelper->ask($input, $output, $descriptionQuestion->getQuestion());
        $output->writeln(sprintf('You have just typed: %s', $description));
        $output->writeln(
            implode(
                PHP_EOL,
                [
                    '--------------------',
                    'Summary:',
                    sprintf('Author: %s', $author),
                    sprintf('Title: %s', $title),
                    sprintf('URL: %s', $url),
                    sprintf('Tag: %s', $tag->value),
                    sprintf('Description: %s', $description),
                    '--------------------',
                ]
            )
        );
        $confirmationQuestion = new ConfirmationQuestion('Continue adding article?');
        if (!$questionHelper->ask($input, $output, $confirmationQuestion)) {
            $output->writeln('Nothing is added');
            return Command::SUCCESS;
        }

        $markdownFilesDirectory = __DIR__ . '/../../knowledge-base-markdown-files';
        $output->writeln($markdownFilesDirectory);
        $authorAndTitle = sprintf('%s_%s', $author, $title);
        $fileName = preg_replace('/[^A-Za-z0-9-_]+/', '_', $authorAndTitle);
        $lowerCasedFilename = strtolower($fileName);
        $fileNameWithExtension = sprintf('%s.md', $lowerCasedFilename);
        $directoryAndFileNameWithExtension = sprintf('%s/%s', $markdownFilesDirectory, $fileNameWithExtension);
        $templateFile = __DIR__ . '/../Helper/template.md';
        $output->writeln($templateFile);
        copy($templateFile, $directoryAndFileNameWithExtension);
        $fileContents = file_get_contents($directoryAndFileNameWithExtension);
        $output->writeln($fileContents);
        $fileContents1 = preg_replace('/##author##/', $author, $fileContents);
        $output->writeln($fileContents1);
        $fileContents2 = preg_replace('/##title##/', $title, $fileContents1);
        $output->writeln($fileContents2);
        $fileContents3 = preg_replace('/##url##/', $url, $fileContents2);
        $output->writeln($fileContents3);
        $fileContents4 = preg_replace('/##tag##/', $tag->value, $fileContents3);
        $output->writeln($fileContents4);
        $fileContents5 = preg_replace('/##description##/', $description, $fileContents4);
        $output->writeln($fileContents5);
        file_put_contents($directoryAndFileNameWithExtension, $fileContents5);
        $output->writeln(sprintf('Article with .md-file "%s" is added', $fileNameWithExtension));
        $output->writeln(
            sprintf(
                'You can use this as commit message: "%s"`',
                sprintf('Add article: %s - %s', $author, $title)
            )
        );
        return Command::SUCCESS;
    }
}
