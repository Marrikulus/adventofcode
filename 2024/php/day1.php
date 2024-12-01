<?php declare(strict_types=1);

$testInput = file_get_contents('../inputs/day1-test.txt');
$input = file_get_contents('../inputs/day1.txt');

assert(solve1($testInput) === 11);
solve1($input);
assert(solve2($testInput) === 31);
solve2($input);

function solve1(string $input): int
{
	$list1 = [];
	$list2 = [];
	$lines = explode("\n", $input);
	foreach ($lines as $line) {
		list($n1, $n2) = explode("   ", $line, 2);
		$list1[] = intval($n1);
		$list2[] = intval($n2);
	}

	sort($list1);
	sort($list2);
	$distances = [];
	for($i = 0; $i < count($list1); $i++) {
		$distances[] = abs($list1[$i] - $list2[$i]);
	}
	$result = array_sum($distances);
	echo $result. PHP_EOL;
	return $result;
}

function solve2(string $input): int
{
	$list1 = [];
	$list2 = [];
	$lines = explode("\n", $input);
	foreach ($lines as $line) {
		list($n1, $n2) = explode("   ", $line, 2);
		$list1[] = intval($n1);
		$list2[] = intval($n2);
	}

	$countMap = array_count_values($list2);
	$similarity = 0;
	foreach ($list1 as $value) {
		$count = $countMap[$value] ?? 0;
		$similarity += ($value * $count);
	}
	echo $similarity. PHP_EOL;
	return $similarity;
}

