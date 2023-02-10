<?php

namespace Code050\Codestyle\Commands;

use Code050\Codestyle\Commands\Arguments\HelpArgument;
use Composer\Script\Event;

class InitializeCodestyle extends ComposerCommand
{
    protected static array $arguments = [
        HelpArgument::class
    ];

    public string $description = 'Copies the default config files to the root directory of the project 
                                        --overwrite: Overwrites the existing config files';

    public static function handle(Event $event): void
    {
        self::parseArguments($event->getArguments());
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $rootDir = dirname($vendorDir);

        self::writeStubToRootDir($rootDir, 'phpcs.xml', 'php-code-sniffer/phpcs.dist.xml');
        self::writeStubToRootDir($rootDir, 'phpstan.neon', 'phpstan/phpstan.dist.neon');
    }

    private static function writeStubToRootDir(string $rootDir, string $filename, string $stubFilename): void
    {
        if (file_exists($rootDir . '/' . $filename) && self::getArgument('overwrite') != 'true') {
            echo 'Found ' . $filename . ' config file. Run with argument `-- --overwrite to overwrite it.`' . PHP_EOL;
            return;
        }

        echo 'Copying ' . $stubFilename . ' config file to ' . $rootDir . ' as ' . $filename . PHP_EOL;
        copy(__DIR__ . '/../Services/' . $stubFilename, $rootDir . '/' . $filename);
    }
}
