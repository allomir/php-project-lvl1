<?php

namespace BrainGames\Cli;

use function cli\line;
use function cli\prompt;

function greeting()
{
    line("Welcome to the Brain Games!");
}

function whatIsName()
{
    $user = prompt('May I have your name?', 'noname', ' = ');
    line("Hello, %s!", $user);
}
