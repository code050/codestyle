<?php

declare(strict_types=1);

namespace Code050\Codestyle\Services\Phpstan\Commands;

use Code050\Codestyle\Commands\ComposerCommand;
use Composer\Script\Event;

use function file_exists;
use function shell_exec;

use const PHP_EOL;

class Run extends ComposerCommand
{
    public const PHPSTAN_BASELINE_NEON = '/../phpstan-baseline.neon';
    public const BIN_PHPSTAN_MEMORY_LIMIT_1 = '/bin/phpstan --memory-limit=-1';

    public static string $handle = self::HANDLE_PREFIX . 'stan';
    protected string $description = 'Run phpstan analyzer';

    public static function handle(Event $event): void
    {
        parent::handle($event);

        if (!file_exists(self::$vendorDir . self::PHPSTAN_BASELINE_NEON)) {
            echo 'No baseline file found, please run composer ' .
                GenerateBaseline::$handle .
                ' to use a baseline' .
                PHP_EOL;
        }

        $command = self::$vendorDir . self::BIN_PHPSTAN_MEMORY_LIMIT_1;
        echo shell_exec($command);
    }
}
