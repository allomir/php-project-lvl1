<?php

namespace BrainGames\Cli;

use function cli\line;
use function cli\prompt;

function printString($str)
{
    line($str);
}

function getAnswerLine($question): string
{
    $answer = prompt($question, '', ' > ');

    return $answer;
}

function printStringVar($strVar, $var, $var2 = '')
{
    line($strVar, $var, $var2);
}
