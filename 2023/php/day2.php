<?php

$input = "Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green";
$input = file_get_contents("day2.txt");

$maxes = ['blue' => 14, 'red' => 12, 'green' => 13 ];

$totalPower = 0;
$sum = 0;
$lines = explode("\n", $input);
foreach($lines as $key =>  $line)
{
	if (!$line) continue;
    list($gameTag, $setsString) = explode( ": ", trim($line),2);
    list($tag, $gameNum) = explode(" ", trim($gameTag), 2);
    $id = intval($gameNum);
    $sets = explode("; ", $setsString);
    $test = ['blue' => 0, 'red' => 0, 'green' => 0 ];
	$power = 0;
    foreach($sets as $set)
    {
        $throws = explode(", ", $set);
        foreach($throws as $throw)
        {
            list($count, $color) = explode(" ", $throw, 2);
            $count = intval($count);
            if ($test[$color] < $count) {
                $test[$color] = $count;
            }
        }
        
    }
    if ($maxes['red']   >= $test['red'] &&
        $maxes['green'] >= $test['green'] &&
        $maxes['blue']  >= $test['blue'])
    {
        $sum += $id;
    }
	$totalPower += $test['red'] * $test['green'] * $test['blue'];
}

var_dump($sum);
var_dump($totalPower);


