<?php

namespace BrainGames\Engine;

use function BrainGames\Cli\printString;
use function BrainGames\Cli\printStringVar;
use function BrainGames\Cli\getStringLine;

use function BrainGames\Games\tasks;
use function BrainGames\Games\taskSolutions;
use function BrainGames\Games\taskQuestions;
use function BrainGames\Games\compareResults;
use function BrainGames\Games\convertTaskResults;

#GAMES-start: brain-games
function printGreetingStart()
{
    printString("Welcome to the Brain Games!");
}

function getUserName()
{
    $userName = getStringLine('May I have your name?') ?: 'noname';

    return $userName;
}

function printGreetingUser($user)
{
    printStringVar("Hello, %s!", $user['name']);
}

function setUser()
{
    return [
        'name' => getUserName()
    ];
}

#game-kinds, game-unit: one-task
function setGameParams($gameName, $gameAmount = null)
{
    return [
        'name' => $gameName,
        'amount' => $gameAmount ?? 3,
        'lineQuestion' => "Question: %s",
        'lineAnswer' => 'Your answer:',
        'taskResultConverted' => null,
        'userAnswer' => null
    ];
}

function printQuestion($gameParams, $taskQuestion)
{
    printStringVar($gameParams['lineQuestion'], $taskQuestion);
}

function getUserAnswer($gameParams)
{
    $userAnswer = getStringLine($gameParams['lineAnswer']);

    return $userAnswer;
}

function game(&$gameParams) {

    $task = tasks($gameParams['name']);
    $taskResult = taskSolutions($gameParams['name'], $task);
    $gameParams['taskResultConverted'] = convertTaskResults($gameParams['name'], $taskResult);

    $taskQuestion = taskQuestions($gameParams['name'], $task);
    printQuestion($gameParams, $taskQuestion);
    $gameParams['userAnswer'] = getUserAnswer($gameParams);
    
    return compareResults($gameParams['name'], $taskResult, $gameParams['userAnswer']);
}

function printGameStatus($result, $gameParams)
{
    $gameStatuses = [true => 'Correct!', false => "'%s' is wrong answer ;(. Correct answer was '%s'."];

    if ($result === true) {
        printStringVar($gameStatuses[true], $gameParams['userAnswer'], ...$gameParams['taskResultConverted']);
    } else {
        printStringVar($gameStatuses[false], $gameParams['userAnswer'], ...$gameParams['taskResultConverted']);
    }
}

function printTotalStatus($totalResult, $user)
{
    $totalStatuses = [true => "Congratulations, %s!", false => "Let's try again, %s!"];

    if ($totalResult === true) {
        printStringVar($totalStatuses[true], $user['name']);
    } else {
        printStringVar($totalStatuses[false], $user['name']);
    }
}

