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

#СOMMON
function printStrings($name, $gameParams = null)
{
    $string = '';
    switch ($name) {
        case 'greetingMain':
            $string = "Welcome to the Brain Games!";
            break;
        case 'rules':
            $string = taskRules()[$gameParams['name']];
            break;
    }

    printString($string);
}

function printStringsVars($name, ...$vars)
{
    $strings = [
        'greetingUser' => "Hello, %s!",
        'question' => "Question: %s"
    ];

    printStringVar($strings[$name], ...$vars);
}

#GAMES-startMain: brain-games
function startMain()
{
    $mainParams = getMainParams();
    getParamUserName($mainParams);
    printStrings('greetingMain');
    printStringsVars('greetingUser', $mainParams['userName']);

    return $mainParams;
}

function getMainParams()
{
    return [
        'userName' => null
    ];
}

function getParamUserName(&$mainParams)
{
    $mainParams['userName'] = getStringLine('May I have your name?') ?: 'noname';

    return $mainParams['userName'];
}

#UNIT(measure)-game: one task
function startGame($gameName, $gameAmount = null)
{
    $gameParams = getGameParams();
    $gameParams['name'] = $gameName;
    $gameAmount === null ?: $gameParams['amount'] = $gameAmount;
    printStrings('rules', $gameParams);

    return $gameParams;
}

function game(&$gameParams)
{
    $task = tasks($gameParams['name']);
    $gameParams['taskResult'] = taskSolutions($gameParams['name'], $task);

    $taskQuestion = taskQuestions($gameParams['name'], $task);
    printStringsVars('question', $taskQuestion);
    getUserAnswer($gameParams);

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

        if ($result === false) {
            break;
        }
    }

    return $results;
}

function getGameParams()
{
    return [
        'name' => null,
        'amount' => 3,
        'taskResult' => null,
        'userAnswer' => null
    ];
}

function getUserAnswer(&$gameParams)
{
    $lineAnswer = 'Your answer: ';
    $gameParams['userAnswer'] = getStringLine($lineAnswer);

    return $gameParams['userAnswer'];
}

function printGameStatus($gameResult, $gameParams)
{
    $gameStatuses = [
        true => 'Correct!',
        false => "'%s' is wrong answer ;(. Correct answer was '%s'."
    ];

    $taskResultsConverted = taskResults($gameParams['name'], $gameParams['taskResult']);
    $taskResultConverted = $taskResultsConverted[array_key_first($taskResultsConverted)];
    $userAnswer = $gameParams['userAnswer'];

    if ($gameResult === true) {
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
