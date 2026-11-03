<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Command;

use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use thofman\KnowledgeBase\Application\Article\ReplaceTemplateService;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\NewMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\TemplateMarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Sanitization\StringSanitizer;
use thofman\KnowledgeBase\Domain\Question\Tag;
use thofman\KnowledgeBase\Domain\Question\Validation\AlwaysValidValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\CompositeValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\NonEmptyStringValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\UrlSchemeHttpsValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\UrlValidator;
use thofman\KnowledgeBase\Presentation\Cli\Question\TagQuestion;
use thofman\KnowledgeBase\Presentation\Cli\Question\TextQuestion;

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
        $titleQuestion = new TextQuestion(
            'Please enter the title of the article: ',
            new NonEmptyStringValidator('Title'),
            new StringSanitizer(),
        );
        $title = $questionHelper->ask($input, $output, $titleQuestion->getQuestion());
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
        $tagQuestion = new TagQuestion();
        $chosenTag = $questionHelper->ask($input, $output, $tagQuestion->getQuestion());
        $tag = Tag::from($chosenTag);
        $descriptionQuestion = new TextQuestion(
            'Please enter the description of the article (optional): ',
            new AlwaysValidValidator(),
            new StringSanitizer(),
        );
        $description = $questionHelper->ask($input, $output, $descriptionQuestion->getQuestion());
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

        $pathnameDirectory = __DIR__ . '/../../knowledge-base-markdown-files';
        $markdownFilesDirectory = new MarkdownFilesDirectory(new SplFileInfo($pathnameDirectory));
        $authorAndTitle = sprintf('%s_%s', $author, $title);
        $fileName = preg_replace('/[^A-Za-z0-9-_]+/', '_', $authorAndTitle);
        $lowerCasedFilename = strtolower($fileName);
        $fileNameWithExtension = sprintf('%s.md', $lowerCasedFilename);
        $pathnameNewMarkdownFile = sprintf('%s/%s', $markdownFilesDirectory->getPathname(), $fileNameWithExtension);
        $newMarkdownFile = new NewMarkdownFile(new SplFileInfo($pathnameNewMarkdownFile));
        $pathnameTemplateFile = __DIR__ . '/../Domain/MarkdownFile/Template/template.md';
        $templateMarkdownFile = new TemplateMarkdownFile(new MarkdownFile(new SplFileInfo($pathnameTemplateFile)));
        $replaceTemplateService = new ReplaceTemplateService();
        $markdownFile = $replaceTemplateService->replaceTemplate(
            $templateMarkdownFile,
            $newMarkdownFile,
            $author,
            $title,
            $url,
            $tag,
            $description,
        );
        $output->writeln(sprintf('Article with .md-file "%s" is added', $markdownFile->getFilename()));
        $output->writeln(
            sprintf(
                'You can use this as commit message: "%s"`',
                sprintf('feat(article): add article: %s - %s', $author, $title)
            )
        );
        return Command::SUCCESS;
    }
}
