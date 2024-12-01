<?php declare(strict_types=1);

$testInput =
".....
.S-7.
.|.|.
.L-J.
.....";
//$input = file_get_contents('../inputs/day9.txt');

echo solve($testInput).PHP_EOL;

//$start = microtime(true);
//echo solve($input).PHP_EOL;
//echo "Time: ".microtime(true)-$start.PHP_EOL;


class Node {
	public function __construct(
		public string $symbol,
		public array $current,
		public array $last,
	) {}
}
function solve(string $input): int
{
	$map = [
		'l' => ['', ],
		'r' => ['', ],
		'u' => ['', ],
		'd' => ['', ],
	];

	$w = strpos($input, "\n");
	$h = substr_count($input, "\n")+1;
	$getChar = fn ($x, $y) => $input[$x + ($y * ($w+1))];
	$getCharV = fn ($vec) => $input[$vec[0] + ($vec[1] * ($w+1))];
	$up = fn ($vec) => [$vec[0], $vec[1]-1];
	$down = fn ($vec) => [$vec[0], $vec[1]+1];
	$left = fn ($vec) => [$vec[0]-1, $vec[1]];
	$right = fn ($vec) => [$vec[0]+1, $vec[1]];
	$calcXY = function ($s) use ($w) {
		$y = intval($s / ($w+1));
		$x = $s - ($y*($w+1));
		return [$x, $y];
	};
	$dirs = [ $up, $down, $left, $right ];
	$startPos = $calcXY(strpos($input, "S"));
	$current = new Node(
		"S",
		$startPos,
		$startPos
	);

	if ($current->symbol === "S") {
		$l = $left($current->current);
		$c = $getCharV($l);
		if ($c == 'F' || $c == 'L'|| $c == '-') {
			// going left
		}
		$r = $right($current->current);
		$u = $up($current->current);
		$d = $down($current->current);
		//foreach ($dirs as $dir) {
		//	$testDir = $dir($);
		//	$char = $getCharV($testDir);
		//	var_dump($char, $testDir);
		//}
	}
	else if($current->symbol === "-") {
		$l = $left($current->current);
		$c = $getCharV($l);
		$r = $right($current->current);
	}
	else if($current->symbol === "-") {

	return 0;
}

//	for($y = 0; $y < $h; $y++) {
//		for($x = 0; $x < $w; $x++) {
//			$char = $getChar($x, $y);
//			if ($char === "S") {
//				var_dump(["S", $x, $y]);
//				break;
//			}
//			if ($char === "J") {
//				var_dump(["J", $x, $y]);
//				break;
//			}
//			echo $getChar($x, $y) . ' ';
//		}
//		echo PHP_EOL;
//	}
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
	if($die) {
		die();
	}
}
