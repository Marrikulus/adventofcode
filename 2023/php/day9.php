<?php declare(strict_types=1);

$test = [0, 3, 6, 9, 12, 15];
//$test2 = diff($test);
//echo implode(',', diff($test2))."\n";
//echo findNextNumber($test)."\n";
echo findPreviousNumber($test)."\n";

$testInput =
"0 3 6 9 12 15
1 3 6 10 15 21
10 13 16 21 30 45";
$input = file_get_contents('../inputs/day9.txt');

echo solve2($testInput).PHP_EOL;

$start = microtime(true);
echo solve2($input).PHP_EOL;
echo "Time: ".microtime(true)-$start.PHP_EOL;


function solve(string $input): int
{
	$result = 0;
	$lines = lines($input);
	//echo 'Lines:'. count($lines).PHP_EOL;
	foreach($lines as $i => $line) {
		$nums = [];
		$words = words($line);
		//echo 'Words:'. count($words).PHP_EOL;
		foreach(words($line) as $word) {
			$nums[] = intval($word);
		}
	//	echo 'last:'. $nums[array_key_last($nums)].PHP_EOL;
		$result += findNextNumber($nums);
	}
	return $result;
}
function solve2(string $input): int
{
	$result = 0;
	$lines = lines($input);
	foreach($lines as $i => $line) {
		$nums = [];
		foreach(words($line) as $word) {
			$nums[] = intval($word);
		}
		$result += findPreviousNumber($nums);
	}
	return $result;
}

function allZero($arr) {
	foreach ($arr as $v) {
		if($v !== 0 ) {
			return false;
		}
	}
	return true;
};

function findNextNumber(array $input, bool $debug = false): int
{
	$test = diff($input);
	$last = $input[array_key_last($input)];
	if (allZero($test)) {
		return $last;
	}
	$result = $last + findNextNumber($test, $debug);
	return $result;
}

function findPreviousNumber(array $input, bool $debug = false): int
{
	$test = diff($input);
	if (allZero($test)) {
		return $input[0];
	}
	$result = $input[0] - findPreviousNumber($test, $debug);
	return $result;
}

function diff(array $in): array
{
	$out = [];
	for($i = 1; $i < count($in); $i++)
	{
		$out[] = $in[$i] - $in[$i-1];
	}
	return $out;
}

function lines(string $input): array
{
	return explode("\n", trim($input));
}
function words(string $input): array
{
	return explode(" ", trim($input));
}

function dd(array $input, bool $die = false): void
{
	echo implode(',', $input)."\n";
	if($die) die();
}
