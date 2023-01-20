<?php

namespace Code050\Codestyle\Scripts;

use Code050\Codestyle\ComposerCommand;
use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class CodeStyle extends ComposerCommand
{
    public static function initialize(Event $event): void
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $rootDir = dirname($vendorDir);
        self::parseArguments($event->getArguments());

        self::writeStubToRootDir($rootDir, 'phpcs.xml', 'php-code-sniffer/phpcs.dist.xml');
        self::writeStubToRootDir($rootDir, 'phpstan.neon', 'phpstan/phpstan.dist.neon');
    }


    private static function writeStubToRootDir(string $rootDir, string $filename, string $stubFilename): void
    {
        if (file_exists($rootDir . '/' . $filename)) {
            echo 'Found ' . $filename . ' config file. Run with argument --overwrite to overwrite it.' . PHP_EOL;
        }

        //copy src/php-code-style/phpcs.dist.xml to the root dir as phpcs.xml
        echo 'Copying ' . $stubFilename . ' config file to ' . $rootDir . ' as ' . $filename . PHP_EOL;
        copy(__DIR__ . '/../Services/' . $stubFilename, $rootDir . '/' . $filename);
    }

}
