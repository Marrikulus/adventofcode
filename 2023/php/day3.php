<?php declare(strict_types=1);

//$input =
//	"467..114..\n" .
//	"...*......\n" .
//	"..35..633.\n" .
//	"......#...\n" .
//	"617*......\n" .
//	".....+.58.\n" .
//	"..592.....\n" .
//	".......755\n" .
//	"1..$..*...\n" .
//	".664..598.";
$input =
"467..114..\n".
"...*......\n".
"..35..633.\n".
"......#...\n".
"617*......\n".
".....+.58.\n".
"..592.....\n".
"......755.\n".
"...$.*....\n".
".664.598..";
$input = file_get_contents('day3.txt');

function hashKey($x, $y, $l)
{
	//return $x.'x'.$y;
	return $x + ($y * $l);
}

class Loc
{
	public function __construct(
		public string $char,
		public int $x,
		public int $y
	) {}
}

class Parser
{
	public $number = "";
	public $numbers = [];
	/** @var array<Loc> */
	public array $currentDigitLocs = [];
	/** @var array<Loc> */
	public array $allDigitLocs = [];
	/** @var array<Loc> */
	public array $symLocs = [];
	/** @var array<string> */
	public array $allSymbols = [];
	public $lookup = [];
	public int $dotCount = 0;
	public function __construct(
		public int $width,
		public int $height,
	) {}

	public function addDigit(string $char, int $x, int $y)
	{
		$this->currentDigitLocs[] = new Loc($char,$x, $y);
		$this->number .= $char;
	}

	public function dot()
	{
		$this->dotCount += 1;
	}

	public function getNum()
	{
		$num = (int)$this->number;
		$this->numbers[] = (int)$this->number;
		$this->number = "";
		return $num;
	}

	public function addSym(string $char, int $x, int $y)
	{
		$this->symLocs[] = new Loc($char,$x, $y);
		$this->allSymbols[] = $char;
	}

	public function process()
	{
		$number = $this->getNum();
		foreach($this->currentDigitLocs as $loc) {
			$key = hashKey($loc->x,$loc->y, $this->width);
			$this->lookup[$key] = $number;
		}
		$this->allDigitLocs = array_merge($this->allDigitLocs, $this->currentDigitLocs);
		$this->currentDigitLocs = [];
	}

	public function printStats()
	{
		$numCount = count($this->numbers);
		$digitCount = count($this->allDigitLocs);
		$symCount = count($this->allSymbols);
		printf("numbers: %d\n", $numCount);
		printf("symbols: %d\n", $symCount);
		printf("dots: %d\n", $this->dotCount);
		printf("digit: %d\n", $digitCount);
		printf("lookup: %d\n", count($this->lookup));
		$total = $digitCount + $symCount + $this->dotCount;
		printf("total: %d\n", $total);
		$size = $this->width * $this->height;
		printf("gridSize: %d\n", $size);
		printf("diff: %d\n", $total - $size);
		var_dump(array_count_values($this->allSymbols));
	}
}



$lines = explode("\n", trim($input));
$max_x = strlen($lines[0]);
$max_y = count($lines);
$parser = new Parser($max_x, $max_y);

$dotCount = 0;
$symCount = 0;

$process = false;
$lastNumber = false;
for ($y = 0; $y < $max_y; $y++) {
	for ($x = 0; $x < $max_x; $x++) {
		$char = $lines[$y][$x];
		if($process) {
			$parser->process();
			$process = false;
		}

		if ($char === ".") {
			$parser->dot();
			$dotCount++;
			if($lastNumber) {
				$process = true;
			}
			$lastNumber = false;
		}
		else if (!is_numeric($char)) {
			$parser->addSym($char, $x, $y);
			$symCount++;
			if($lastNumber) {
				$process = true;
			}
			$lastNumber = false;
		}
		else {
			$lastNumber = true;
			$parser->addDigit($char, $x, $y);
		}
	}
	$parser->process();
}

//$parser->printStats();
//die();


$checks = [
	[-1, 0],
	[1, 0],
	[-1, -1],
	[1, -1],
	[1, 1],
	[-1, 1],
	[-1, 0],
	[1, 0],
];

$sum = 0;
$debugInfo = [];
foreach ($parser->symLocs as $p) {
	$ns = [];
	foreach ($checks as $c) {
		$x = $c[0] + $p->x;
		$y = $c[1] + $p->y;
		if (0 <= $x && 0 <= $y && $x <= $max_x && $y <= $max_y) {
			$key = hashKey($x,$y,$max_x);
			if(isset($parser->lookup[$key]))
				$ns[] = $parser->lookup[$key];
		}
	}

	//var_dump($p['sim'], $ns);
	$parts = array_values(array_unique($ns));
	$s = array_sum($parts);
	$sum += $s;
	$debugInfo[] = [
		'sim' => $p->char,
		'nums' => $parts,
		'sum' => $s,
		'partsCount' => count($parts),
	];
}

$partStats = [
	0 => 0,
	1 => 0,
	2 => 0,
	3 => 0,
	4 => 0,
];
foreach($debugInfo as $i) {
	if ($i['sim'] === '*') {
		$partStats[$i['partsCount']] += 1;
	}
}


//$symbols = preg_replace('/[.0-9\n]/','', $input);
//echo $symbols;
//var_dump(strlen($symbols));
//var_dump(count($symLocs));
$gearArr = [];
$gearSum = 0;
foreach($debugInfo as $j =>  $i) {
	//$big = false;
	//foreach($i['nums'] as $n)
	//{
	//	if($n >= 1000) $big = true;
	//}
	//if (count($i['nums']) > 2 || $big)
	if ($i['sim'] === '*' && count($i['nums']) === 2) {
		//printf("%d %s: %d %s\n", $j,  $i['sim'], $i['sum'], implode(",", $i['nums']));
		$gearNum = $i['nums'][0] * $i['nums'][1];
		$gearArr[] = $gearNum;
		$gearSum += $gearNum;
	}
}

var_dump(array_sum($parser->numbers));
var_dump($sum);
var_dump(count($gearArr));
var_dump($partStats);
//var_dump(array_count_values($parser->allSymbols));
var_dump($gearSum);

//$sum = array_sum($numbers);
//var_dump($sum);

