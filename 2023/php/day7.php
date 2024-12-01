<?php declare(strict_types=1);

$testInput =
"32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483";

function scoreHand(string $hand): array
{
	$test = ' 23456789TJQKA';
	$counts = [];
	$score = 0;
	for($i = 1; $i < strlen($test); $i++) {
		$count = substr_count($hand, $test[$i]);
		if ($count > 0) {
			$counts[] = $count;
		}
		echo $i .' '. $test[$i] .' '. $count. "\n";
		$score += $count*$i;
	}
	rsort($counts, SORT_NUMERIC);
	$rank = 0;
	if($counts[0] === 5)
		$rank = 6;
	else if($counts[0] === 4)
		$rank = 5;
	else if($counts[0] === 3 && $counts[1] === 2)
		$rank = 4;
	else if($counts[0] === 3 && $counts[1] === 1 && $counts[2] === 1)
		$rank = 3;
	else if($counts[0] === 2 && $counts[1] === 2 && $counts[2] === 1)
		$rank = 2;
	else if($counts[0] === 2)
		$rank = 1;
	//match ($counts) {
	//};
	return ['rank' => $rank, 'score' => $score];
}

function solve(string $input):int
{
	$lines = explode("\n", trim($input));
	$hands = [];
	foreach ($lines as $line) {
		list($hand, $bid) = explode(" ", $line);
		$ble = [
			'hand' => $hand,
			'bid' => $bid,
		];
		$hands[] = array_merge($ble,scoreHand($hand));
	}
	//rankHands($hands);

	usort($hands, function ($a, $b) {
		return $a['rank'] <=> $b['rank'] ?:
			 $a['score'] <=> $b['score'];
	});
	var_dump($hands);
	$result = 0;
	foreach ($hands as $rank => $hand) {
		$rank += 1;
		print($hand['hand']. ' '. $rank.PHP_EOL);
		$result += $rank * $hand['bid'];
	}

	echo $result.PHP_EOL;
	return $result;
}

assert(solve($testInput) === 6440);