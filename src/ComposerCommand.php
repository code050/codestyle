<?php

namespace Code050\Codestyle;

use Composer\Script\Event;

abstract class ComposerCommand
{
    protected static array $arguments = [];

    public static function handle(Event $event): void
    {
    }

    protected static function getArgument(string $key)
    {
        return self::$arguments[$key] ?? null;
    }

    protected static function parseArguments(): void
    {
        $arguments = $_SERVER['argv'];
        array_shift($arguments);
        foreach ($arguments as $argument) {
            //if -- is the only content of the argument, skip it
            if ($argument === '--') {
                continue;
            }

            if (strpos($argument, '--') === 0) {
                $argument = str_replace('--', '', $argument);
                //explode the argument on the = sign
                $argument = explode('=', $argument);
                //if the argument has a value, add it to the array
                if (isset($argument[1])) {
                    self::$arguments[$argument[0]] = $argument[1];
                } else {
                    self::$arguments[$argument[0]] = true;
                }
            }
        }
    }
}