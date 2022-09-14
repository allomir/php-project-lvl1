<?php

namespace BrainGames\Engine;

use function BrainGames\Cli\printString;
use function BrainGames\Cli\printStringVar;
use function BrainGames\Cli\getStringLine;

use function BrainGames\Games\tasks;
use function BrainGames\Games\taskSolutions;
use function BrainGames\Games\taskQuestions;
use function BrainGames\Games\compareResults;
use function BrainGames\Games\taskResults;
use function BrainGames\Games\taskRules;

#GAMES-start: brain-games
function startMain()
{
    printGreetingStart();
    $mainParams = getMainParams();
    printGreetingUser($mainParams['userName']);

    return $mainParams;
}

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
    printStringVar("Hello, %s!", $user);
}

function getMainParams()
{
    return [
        'userName' => getUserName()
    ];
}

#game-kinds, game-unit: one-task
function startGame($gameName, $gameAmount = null)
{
    $gameParams = getGameParams();
    $gameParams['name'] = $gameName;
    $gameAmount === null ?: $gameParams['amount'] = $gameAmount;
    printRules($gameParams);

    return $gameParams;
}

function getGameParams()
{
    return [
        'name' => null,
        'amount' => 3,
        'lineQuestion' => "Question: %s",
        'lineAnswer' => 'Your answer:',
        'taskResult' => null,
        'userAnswer' => null
    ];
}

function printRules($gameParams)
{
    printString(taskRules()[$gameParams['name']]);
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
    $gameParams['taskResult'] = taskSolutions($gameParams['name'], $task);
    $taskQuestion = taskQuestions($gameParams['name'], $task);
    printQuestion($gameParams, $taskQuestion);
    $gameParams['userAnswer'] = getUserAnswer($gameParams);
    
    return compareResults($gameParams['name'], $gameParams['taskResult'], $gameParams['userAnswer']);
}

function gameSeria(&$gameParams)
{
    $i = 1;
    $result = true;
    $results = [];
    while ($i <= ($gameParams['amount']) && $result) {
        $result = game($gameParams);
        printGameStatus($result, $gameParams);   
        $i += 1;
        $results[$i] = $result;

        if($result === false) {
            break;
        }
    }

    return $results;
}

function printGameStatus($result, $gameParams)
{
    $gameStatuses = [
        true => 'Correct!',
        false => "'%s' is wrong answer ;(. Correct answer was '%s'."
    ];

    $taskResultConverted = array_values((taskResults($gameParams['name'])[$gameParams['taskResult']]))[0];
    $userAnswer = $gameParams['userAnswer'];

    if ($result === true) {
        printStringVar($gameStatuses[true], $userAnswer, $taskResultConverted);
    } else {
        printStringVar($gameStatuses[false], $userAnswer, $taskResultConverted);
    }
}

function printTotalStatus($totalResult, $user)
{
    $totalStatuses = [
        true => "Congratulations, %s!",
        false => "Let's try again, %s!"
    ];

    if ($totalResult === true) {
        printStringVar($totalStatuses[true], $user);
    } else {
        printStringVar($totalStatuses[false], $user);
    }
}

