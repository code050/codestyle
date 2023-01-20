<?php

namespace Code050\Codestyle;

class ComposerCommand
{
    protected static array $arguments = [];

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
        var_dump(self::$arguments);
    }
}