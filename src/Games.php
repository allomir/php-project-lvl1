<?php

namespace BrainGames\Games;

use function BrainGames\Cli\printString;
use function BrainGames\Cli\printStringVar;
use function BrainGames\Cli\getStringLine;



function getListTasks()
{
    return [
        'brain-even'
    ];
}

function taskRules()
{
    return [
        'brain-even' => 'Answer "yes" if the number is even, otherwise answer "no".'
    ];
}

function tasks($gameName, ...$params)
{
    switch($gameName) {
        case 'brain-even':
            return taskEven(...$params);
        break;
    }
}

function taskSolutions($gameName, $task)
{
    switch($gameName) {
        case 'brain-even':
            return taskSolutionEven($task);
        break;
    }
}

function taskQuestions($gameName, $task)
{
    switch($gameName) {
        case 'brain-even':
            return $task;
        break;
    }
}

function taskResults($gameName)
{
    switch($gameName) {
        case 'brain-even':
        case 0:
            return [true => ['yes'], false => ['no']];
        break;
    }
}

function compareResults($gameName, $taskResult, $userAnswer)
{
    switch($gameName) {
        case 'brain-even':
        case 0:
            $userResult = in_array($userAnswer, taskResults($gameName)[true]);
            return $userResult === $taskResult;
        break;
    }
}

function taskEven(...$params)
{
    $paramMin = $params[0] ?? 1;
    $paramMax = $params[1] ?? 100;

    return rand($paramMin, $paramMax);
}

function taskSolutionEven($task)
{
    $result = $task % 2 === 0;

    return $result;
}


