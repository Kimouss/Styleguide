<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:init:template',
    description: 'This command init template for work',
)]
class InitTemplateCommand extends Command
{
    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the path of your template:'.PHP_EOL, null);

        $templateArg = $helper->ask($input, $output, $question);
        if (!$templateArg) {
            $io->error('You need to specify a path to init your template.');

            return Command::FAILURE;
        }

        if ($templateArg[0] === '/') {
            $templateArg = substr($templateArg, 1);
        }

        $filesystem = new Filesystem();
        $templatePath = 'templates/' . $templateArg;
        $templatePathIndex = $templatePath . '/index.html.twig';
        if ($filesystem->exists($templatePathIndex)) {
            $confirmation = new ConfirmationQuestion(
                sprintf('The Twig file "%s" already exists. Do you want to replace it ?'.PHP_EOL, $templatePathIndex),
                false,
                '/^(y|yes|o|oui)/i'
            );

            if (!$helper->ask($input, $output, $confirmation)) {
                $io->error('Twig file generation canceled.');

                return Command::SUCCESS;
            }
        }

        $filesystem->dumpFile($templatePathIndex, $this->indexHtml($templateArg));
        $filesystem->dumpFile($templatePath . '/code.html.twig', $this->codeHtml($templateArg));
        $filesystem->dumpFile($templatePath . '/doc.html.twig', $this->docHtml($templateArg));
        $filesystem->dumpFile($templatePath . '/usage.html.twig', $this->usageHtml($templateArg));
        $io->success('Twig file generated successfully with custom code in:');
        $io->listing([
            $templatePathIndex,
            $templatePath . '/code.html.twig',
            $templatePath . '/doc.html.twig',
            $templatePath . '/usage.html.twig',
        ]);

        return Command::SUCCESS;
    }

    private function indexHtml(string $templateArg): string
    {
        return <<<EOF
        {% extends 'base.html.twig' %}
        
        {% block body %}
                {% include '$templateArg/doc.html.twig' %}
                {% include '$templateArg/usage.html.twig' %}
                <h1 class="km-text --peta --bold">Example for $templateArg</h1>
        {% endblock %}

        EOF;
    }

    private function usageHtml(string $templateArg): string
    {
        return <<<EOF
        
            <h1 class="km-text --peta --bold">Usage</h1>
            
            {# Not necessary to touch this part #}
            <pre>
                <code class="language-html">
            {{ include('$templateArg/code.html.twig') | escape }}
                </code>
            </pre>

        EOF;
    }

    private function docHtml(string $templateArg): string
    {
        return <<<EOF
            <h1 class="km-text --peta --bold">Doc of $templateArg</h1>

            EOF;
    }

    private function codeHtml(string $templateArg): string
    {
        return <<<EOF
            <h1 class="km-text --peta --bold">$templateArg</h1>

            EOF;
    }
}
