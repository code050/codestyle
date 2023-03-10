<?php

declare(strict_types=1);

namespace Code050\Codestyle\Services\Phpstan\Commands;

use Code050\Codestyle\Commands\ComposerCommand;
use Composer\Script\Event;

use function shell_exec;

use const PHP_EOL;

class GenerateBaseline extends ComposerCommand
{
    public const GENERATE_BASELINE = '--generate-baseline';
    public const OUTPUT = 'output';

    public static string $handle = self::HANDLE_PREFIX . 'stan:baseline';

    protected string $description = 'Generate baseline for phpstan
                        --path: file path from the project root to phpstan.neon
                        --output: file path for generated phpstan-baseline.neon';

    public static function handle(Event $event): void
    {
        parent::handle($event);

        $arg = self::GENERATE_BASELINE;

        if (self::getArgument(self::OUTPUT)) {
            $arg .= '=' . self::getArgument(self::OUTPUT);
        }

        echo shell_exec(self::$vendorDir . '/bin/phpstan ' . $arg);
        echo 'Baseline generated' . PHP_EOL;
        echo 'Add the following line to your phpstan.neon file:' . PHP_EOL;
        echo 'includes:' . PHP_EOL;
        echo '    - phpstan-baseline.neon' . PHP_EOL;
    }
}
