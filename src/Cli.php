<?php

namespace BrainGames\Cli;

use function cli\line;
use function cli\prompt;

function printString($str)
{
    line($str);
}

function getStringLine($question): string
{
    $answer = prompt($question, '', '');

    return $answer;
}

function printStringVar($strVar, ...$vars)
{
    line($strVar, ...$vars);
}
