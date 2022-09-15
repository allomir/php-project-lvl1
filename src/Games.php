<?php

namespace BrainGames\Games;

use function BrainGames\Cli\printString;
use function BrainGames\Cli\printStringVar;
use function BrainGames\Cli\getStringLine;

function getListTasks()
{
    return [
        'brain-even',
        'brain-calc'
    ];
}

function taskRules()
{
    return [
        'brain-even' => 'Answer "yes" if the number is even, otherwise answer "no".',
        'brain-calc' => 'What is the result of the expression?',
    ];
}

function tasks($gameName, $params = [])
{
    switch ($gameName) {
        case 'brain-even':
            return taskEven($params = []);
            break;
        case 'brain-calc':
            return taskCalculator($params = []);
            break;
    }
}

function taskSolutions($gameName, $task)
{
    switch ($gameName) {
        case 'brain-even':
            return taskSolutionEven($task);
            break;
        case 'brain-calc':
            return taskSolutionCalculator($task);
            break;
    }
}

function taskQuestions($gameName, $task)
{
    switch ($gameName) {
        case 'brain-even':
            return $task;
            break;
        case 'brain-calc':
            return "{$task['num1']} {$task['operator']} {$task['num2']}";
            break;
    }
}

function taskResults($gameName, $taskResult = null)
{
    switch ($gameName) {
        case 'brain-even':
            $results = [true => ['yes'], false => ['no']];
            break;
        case 'brain-calc':
            $results = [$taskResult => [(string) $taskResult]];
            break;
    }

    if ($taskResult === null) {
        return $results;
    }

    return $results[$taskResult];
}

function compareResults($gameName, $taskResult, $userAnswer)
{
    echo '!!!'; echo $gameName;
    switch ($gameName) {
        case 'brain-even':
            $taskResults = taskResults($gameName);
            in_array($userAnswer, $taskResults[true]) ?: $taskResults[false][] = $userAnswer;
            $taskResultsConverted = $taskResults[$taskResult];

            return in_array($userAnswer, $taskResultsConverted, true);
            break;
        case 'brain-calc':
            $taskResultsConverted = taskResults($gameName, $taskResult);

            return in_array($userAnswer, $taskResultsConverted, true);
            break;
    }
}

#TASK-1
function taskEven($params = [])
{
    $params = array_merge([
        'min' => 1,
        'max' => 100
    ], $params);

    return rand($params['min'], $params['max']);
}


function taskSolutionEven($task)
{
    $result = $task % 2 === 0;

    return $result;
}

#TASK-2
function taskCalculator($params = [])
{
    $params = array_merge([
        'min' => 1,
        'max' => 10
    ], $params);

    $operators = ['+', '-', '*', '/'];

    return [
        'operator' => $operators[array_rand($operators, 1)],
        'num1' => rand($params['min'], $params['max']),
        'num2' => rand($params['min'], $params['max'])
    ];
}

function taskSolutionCalculator($task)
{
    $num1 = $task['num1'];
    $num2 = $task['num2'];

    $taskResult = null;
    switch ($task['operator']) {
        case '+':
            $taskResult = $num1 + $num2;
            break;
        case '-':
            $taskResult = $num1 - $num2;
            break;
        case '*':
            $taskResult = $num1 * $num2;
            break;
        case '/':
            $taskResult = $num1 / $num2;
            break;
    }

    return $taskResult;
}
