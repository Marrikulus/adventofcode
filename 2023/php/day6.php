<?php declare(strict_types=1);

$testInput =
"Time:      7  15   30
Distance:  9  40  200";
$input =
"Time:        58     81     96     76
Distance:   434   1041   2219   1218";


$testInput = [
	['t'=> 7, 'd' => 9],
	['t'=> 15,'d' =>  40],
	['t'=> 30,'d' =>  200],
];
$input = [
	['t'=> 58,'d' => 434],
	['t'=> 81,'d' =>  1041],
	['t'=> 96,'d' =>  2219],
	['t'=> 76,'d' =>  1218],
];
$testInput2 = [
	['t'=> 71530, 'd' => 940200],
];
$input2 = [
	['t'=> 58819676,'d' => 434104122191218],
];

//assert(solve1($testInput) === 288);
//echo solve1($input);
assert(solve1($testInput2) === 71503);
echo solve1($input2);

function solve1(array $numbers): int
{
	$counts = [];
	foreach ($numbers as $number) {
		$count = 0;
		$time = $number['t'];
		$record = $number['d'];
		for ($hold = 0; $hold <= $time; $hold++) {
			$distance = ($time - $hold) * $hold;
			//echo "hold/speed:". $hold.PHP_EOL;
			//echo "dist:". $distance.PHP_EOL;
			if($distance > $record) {
				$count++;
			}
		}
		$counts[] = $count;
	}
	$result = array_reduce($counts, fn($r, $c) => $r * $c, 1);
	echo $result.PHP_EOL;
	return $result;
}

function solve2(string $input): int
{
	return 0;
}
