<?php

namespace Code050\Codestyle\Scripts;

use Code050\Codestyle\ComposerCommand;
use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class InitializeCodestyle extends ComposerCommand
{
    public static function handle(Event $event): void
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $rootDir = dirname($vendorDir);
        self::parseArguments($event->getArguments());

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
