<?php

namespace Code050\Codestyle\Commands;

use Composer\Script\Event;

abstract class ComposerCommand
{
    private string $description;

    protected static array $arguments = [];

    public function __construct()
    {
        self::parseArguments();
    }

    abstract public static function handle(Event $event): void;

    protected static function getArgument(string $key)
    {
        return self::$arguments[$key] ?? null;
    }

    protected static function constructArgumentClasses(): void
    {
        foreach (self::$arguments as $key => $argument) {
            if (class_exists($argument)) {
                self::$arguments[$key] = new $argument(self::class);
            }
        }
    }

    protected static function parseArguments(array $arguments = []): void
    {
        self::constructArgumentClasses();

        $arguments = $arguments ?? $_SERVER['argv'];
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

    public function getDescription(): string
    {
        return $this->description;
    }
}
