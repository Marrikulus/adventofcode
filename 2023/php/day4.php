<?php declare(strict_types=1);

$testInput =
'Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53'.PHP_EOL.
'Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19'.PHP_EOL.
'Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1'.PHP_EOL.
'Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83'.PHP_EOL.
'Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36'.PHP_EOL.
'Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11'.PHP_EOL
;


class Card
{
	public function __construct(
		public int $id,
		public array $wNums,
		public array $nums,
		public int $score = 0,
		public int $matches = 0,
	) {}
}

class Parser
{
	public array $cards = [];
	public int $total = 0;
	public array $copies = [];
	public int $total2 = 0;

	public function __construct(
		public int $winCount,
		public int $numCount,
		public string $input,
	) {}

	public function parseCards()
	{
		$lines = explode("\n", $this->input);
		$cards = [];
		foreach ($lines as $line) {
			[$tag, $rest] = explode(':', $line, 2);
			$id = intval(substr($tag, 4));
			[$first, $second] = explode('|', $rest, 2);
			$winningNumbers = array_filter(explode(' ', trim($first)), 'intval');
			assert(count($winningNumbers) === $this->winCount, "Winning numbers({$this->winCount}): wrong '".implode("','", $winningNumbers)."'");

			$numbers = array_filter(explode(' ', trim($second)), 'intval');
			assert(count($numbers) === $this->numCount, "Numbers({$this->numCount}) is wrong '".implode("','", $numbers)."'");
			$cards[] = new Card($id, $winningNumbers, $numbers);
			$this->copies[$id] = 1;
		}
		return $cards;
	}

	public function calcScore()
	{
		$this->cards = $this->parseCards();
		foreach ($this->cards as $card)
		{
			$matches = 0;
			$score = 0;
			foreach($card->nums as $num)
			{
				if(in_array($num, $card->wNums))
				{
					$matches++;
					$score = $score === 0 ? 1 : $score * 2;
				}
			}
			$count = $this->copies[$card->id];
			for($i = 1; $i <= $matches; $i++)
			{
				echo "card $card->id adding $count to card $i \n";
				$this->copies[$card->id+$i] += $count;
			}
			$card->score = $score;
			$card->matches = $matches;
			$this->total += $card->score;
			$this->total2 += $count;
		}
	}
}

$testParser = new Parser(5, 8, trim($testInput));
$testParser->calcScore();

foreach ($testParser->cards as $card)
{
	printf("card %d: matches %d\n", $card->id, $card->matches);
}
echo "first: ".$testParser->total.PHP_EOL;
assert($testParser->total === 13, "test example failed");
echo "second: ".$testParser->total2.PHP_EOL;
assert($testParser->total2 === 30, "test example failed");

$input = file_get_contents('../inputs/day4.txt');
$parser = new Parser(10, 25, trim($input));
$parser->calcScore();
echo "first: ".$parser->total.PHP_EOL;
echo "second: ".$parser->total2.PHP_EOL;
