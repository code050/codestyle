<?php

declare(strict_types=1);

namespace Code050\Codestyle\Commands;

use Composer\Script\Event;

use function copy;
use function dirname;
use function file_exists;

use const PHP_EOL;

class InitializeCodestyle extends ComposerCommand
{
    private const LOOSE = 'loose';
    private const OVERWRITE = 'overwrite';
    private const PHPCS_LOOSE_DIST_XML = 'phpcs-loose.dist.xml';
    private const PHPCS_DIST_XML = 'phpcs.dist.xml';
    private const PHPCS_XML = 'phpcs.xml';
    private const PHPSTAN_NEON = 'phpstan.neon';

    private const PHPSTAN_DIR = 'Phpstan/phpstan.dist.neon';
    private const PHPCS_DIR = 'Php-code-sniffer/';

    public string $description = 'Copies the default config files to the root directory of the project 
                                        --overwrite: Overwrites the existing config files';

    public static function handle(Event $event): void
    {
        parent::handle($event);

        $rootDir = dirname(self::$vendorDir);
        $phpcsFileName = self::determinePhpCsFile();

        self::writeStubToRootDir($rootDir, self::PHPCS_XML, self::PHPCS_DIR . $phpcsFileName);
        self::writeStubToRootDir($rootDir, self::PHPSTAN_NEON, self::PHPSTAN_DIR);
    }

    private static function writeStubToRootDir(string $rootDir, string $filename, string $stubFilename): void
    {
        if (file_exists($rootDir . '/' . $filename) && self::getArgument(self::OVERWRITE) !== true) {
            echo 'Found ' . $filename . ' config file. Run with argument `-- --overwrite to overwrite it.`' . PHP_EOL;
            return;
        }

        echo 'Copying ' . $stubFilename . ' config file to ' . $rootDir . ' as ' . $filename . PHP_EOL;
        copy(__DIR__ . '/../Services/' . $stubFilename, $rootDir . '/' . $filename);
    }

    private static function determinePhpCsFile(): string
    {
        if (self::getArgument(self::LOOSE) === true) {
            return self::PHPCS_LOOSE_DIST_XML;
        }

        return self::PHPCS_DIST_XML;
    }
}
