<?php

declare(strict_types=1);

namespace Code050\Codestyle\Commands;

use Composer\Script\Event;

use function assert;
use function explode;
use function is_string;
use function str_replace;
use function str_starts_with;

abstract class ComposerCommand
{
    protected const HANDLE_PREFIX = 'code050:codestyle:';

    public static string $handle;

    protected static string $vendorDir;

    /** @var array<string, string|bool> */
    protected static array $arguments = [];

    protected string $description;

    public static function handle(Event $event): void
    {
        self::parseArguments($event->getArguments());
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        assert(is_string($vendorDir));
        self::$vendorDir = $vendorDir;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool|string|null
     */
    protected static function getArgument(string $key)
    {
        return self::$arguments[$key] ?? null;
    }

    /**
     * @param array<string,string> $arguments
     */
    protected static function parseArguments(array $arguments): void
    {
        foreach ($arguments as $argument) {
            //if -- is the only content of the argument, skip it
            if ($argument === '--') {
                continue;
            }

            if (!str_starts_with($argument, '--')) {
                continue;
            }

            $argument = str_replace('--', '', $argument);
            //explode the argument on the = sign
            $argument = explode('=', $argument);

            //if the argument has a value, add it to the array
            self::$arguments[$argument[0]] = $argument[1] ?? true;
        }
    }
}
