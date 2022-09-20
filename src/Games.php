<?php

namespace BrainGames\Games;

use function BrainGames\Cli\printString;
use function BrainGames\Cli\printStringVar;
use function BrainGames\Cli\getStringLine;

function getListTasks()
{
    return [
        'brain-even',
        'brain-calc',
        'brain-gcd',
        'brain-progression',
        'brain-primes',
    ];
}

function taskRules()
{
    return [
        'brain-even' => 'Answer "yes" if the number is even, otherwise answer "no".',
        'brain-calc' => 'What is the result of the expression?',
        'brain-gcd' => 'Find the greatest common divisor of given numbers.',
        'brain-progression' => 'What number is missing in the progression?',
        'brain-primes' => 'Answer "yes" if given number is prime. Otherwise answer "no".',
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
        case 'brain-gcd':
            return taskGCD($params = []);
            break;
        case 'brain-progression':
            return taskProgression($params = []);
            break;
        case 'brain-primes':
            return taskPrimes($params = []);
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
        case 'brain-gcd':
            return taskSolutionGCD($task);
            break;
        case 'brain-progression':
            return taskSolutionProgression($task);
            break;
        case 'brain-primes':
            return taskSolutionPrimes($task);
            break;
    }
}

function taskQuestions($gameName, $task)
{
    switch ($gameName) {
        case 'brain-even':
            return "$task";
            break;
        case 'brain-calc':
            return "{$task['num1']} {$task['operator']} {$task['num2']}";
            break;
        case 'brain-gcd':
            return implode(' ', $task);
            break;
        case 'brain-progression':
            return implode(' ', $task['progression']);
            break;
        case 'brain-primes':
            return "$task";
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
        case 'brain-gcd':
            $results = [$taskResult => [(string) $taskResult]];
            break;
        case 'brain-progression':
            $results = [$taskResult => [(string) $taskResult]];
            break;
        case 'brain-primes':
            $results = [true => ['yes'], false => ['no']];
            break;
    }

    if ($taskResult === null) {
        return $results;
    }

    return $results[$taskResult];
}

function compareResults($gameName, $taskResult, $userAnswer)
{
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
        case 'brain-gcd':
            $taskResultsConverted = taskResults($gameName, $taskResult);

            return in_array($userAnswer, $taskResultsConverted, true);
            break;
        case 'brain-progression':
            $taskResultsConverted = taskResults($gameName, $taskResult);

            return in_array($userAnswer, $taskResultsConverted, true);
            break;
        case 'brain-primes':
            $taskResults = taskResults($gameName);
            in_array($userAnswer, $taskResults[true]) ?: $taskResults[false][] = $userAnswer;
            $taskResultsConverted = $taskResults[$taskResult];

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

#TASK-3
function taskGCD($params = [])
{
    $params = array_merge([
        'min' => 1,
        'max' => 10
    ], $params);

    return [
        'num1' => rand($params['min'], $params['max']),
        'num2' => rand($params['min'], $params['max'])
    ];
}

function taskSolutionGCD($task)
{
    sort($task);
    $min = $task[array_key_first($task)];

    $GCD = 1;
    for ($i = $min; $i >= 2; $i -= 1) {
        $GCD = $i;
        foreach ($task as $num) {
            if ($num % $i !== 0) {
                $GCD = 1;
                break;
            }
        }
    }

    return $GCD;
}

#TASK-4 progression
function taskProgression($params = [])
{
    $params = array_merge([
        'stepMin' => 1,
        'stepMax' => 10,
        'keyOffsetMin' => 1,
            # номер первого значения 1 в арифметической прогрессии, аналог ID но начинается от 1
        'keyOffsetMax' => 100,
        'startMin' => 1,
        'startMax' => 10,
        'rangeMin' => 5,
        'rangeMax' => 10,
        'hiddenSymbol' => '..'
    ], $params);

    $step = rand($params['stepMin'], $params['stepMax']);
    $keyOffset = rand($params['keyOffsetMin'], $params['keyOffsetMax']);
    $start = rand($params['startMin'], $params['startMax']);
    $range = rand($params['rangeMin'], $params['rangeMax']);

    $progression = array_fill($keyOffset, $range, $start);
    foreach ($progression as $key => $value) {
        $progression[$key] = $start + ($key - 1) * $step;
    }

    $keyHidden = array_rand($progression);
    $progression[$keyHidden] = '..';

    return ['progression' => $progression, 'params' => $params];
}

function taskSolutionProgression($task)
{
    $progression = $task['progression'];
    $params = $task['params'];
    $keyN = array_search($params['hiddenSymbol'], $progression, true);

    $tempProgression = $progression;
    unset($tempProgression[$keyN]);
    $keyI = array_key_first($tempProgression);
    $keyJ = array_key_last($tempProgression);
    $step = ($tempProgression[$keyJ] - $tempProgression[$keyI]) / ($keyJ - $keyI);
    $start = $tempProgression[$keyI] - ($keyI - 1) * $step;

    $valueN = $start + ($keyN - 1) * $step;

    return $valueN;
}

#TASK-5 primes
function taskPrimes($params = [])
{
    $primes = getPrimes();

    $params = array_merge([
        'min' => 1,
        'max' => $primes[array_key_last($primes)],
    ], $params);

    return rand($params['min'], $params['max']);
}

function getPrimes($params = [])
{
    $primes = [
        2, 3, 5, 7, 11, 13, 17, 19, 23, 29,
        31, 37, 41, 43, 47, 53, 59, 61, 67, 71,
        73, 79, 83, 89, 97, 101, 103, 107, 109, 113,
        127, 131, 137, 139, 149, 151, 157, 163, 167, 173,
        179, 181, 191, 193, 197, 199, 211, 223, 227, 229
    ];

    $params = array_merge([
        'offset' => 0,
        'length' => count($primes)
    ], $params);

    return array_slice($primes, $params['offset'], $params['length'], true);
}

function taskSolutionPrimes($task)
{
    $primes = getPrimes();
    return in_array($task, $primes, true);
}
