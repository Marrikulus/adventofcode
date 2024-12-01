<?php declare(strict_types=1);

$testInput =
"RL

AAA = (BBB, CCC)
BBB = (DDD, EEE)
CCC = (ZZZ, GGG)
DDD = (DDD, DDD)
EEE = (EEE, EEE)
GGG = (GGG, GGG)
ZZZ = (ZZZ, ZZZ)";
$testInput2 =
	"LLR

AAA = (BBB, BBB)
BBB = (AAA, ZZZ)
ZZZ = (ZZZ, ZZZ)";
$testInput3 =
"LR

11A = (11B, XXX)
11B = (XXX, 11Z)
11Z = (11B, XXX)
22A = (22B, XXX)
22B = (22C, 22C)
22C = (22Z, 22Z)
22Z = (22B, 22B)
XXX = (XXX, XXX)";

//solve($testInput);
//solve($testInput2);
//solve(file_get_contents("../inputs/day8.txt"));
//solve2($testInput3);
$start = time();
solve2(file_get_contents("../inputs/day8.txt"));
$end = time();
echo $start. ' ' . $end. PHP_EOL;
echo $end-$start;
function solve($input)
{
	list($instructions, $netInput) = explode("\n\n", trim($input));
	$nodes = explode("\n", trim($netInput));
	$network = [];
	foreach ($nodes as $node) {
		sscanf($node, "%3s = (%3s, %3s)", $key, $left, $right);
		$network[$key] = ['L' => $left, 'R' => $right];
	}

	$current = 'AAA';
	$find = 'ZZZ';
	$steps = 0;
	while($current !== $find) {
		for($i = 0; $i < strlen($instructions); $i++) {
			$inst = $instructions[$i];
			//echo $inst . "\n";
			$steps++;
			$choices = $network[$current];
			$current = $choices[$inst];

		}
	}
	echo $steps."\n";

}
function solve2($input)
{
	list($instructions, $netInput) = explode("\n\n", trim($input));
	$nodes = explode("\n", trim($netInput));
	$network = [];
	foreach ($nodes as $node) {
		sscanf($node, "%3s = (%3s, %3s)", $key, $left, $right);
		$network[$key] = ['L' => $left, 'R' => $right];
	}


	$currents = array_filter(array_keys($network), fn($n) => str_ends_with($n, 'A'));

	$allEndInZ = function($arr) {
		foreach ($arr as $v) {
			if(!str_ends_with($v, 'Z')) {
				return false;
			}
		}
		return true;
	};

	$find = 'ZZZ';
	$steps = 0;
	while(!$allEndInZ($currents)) {
		for($i = 0; $i < strlen($instructions); $i++) {
			$inst = $instructions[$i];
			$steps++;
			foreach($currents as $k => $v) {
				$choices = $network[$v];
				$currents[$k] = $choices[$inst];
			}
		}
	}
	echo $steps."\n";

}
