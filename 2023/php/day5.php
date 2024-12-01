<?php declare(strict_types=1);

class Mapper
{
	public string $from;
	public string $to;
	public function __construct(
		public string $name,
		public array $ranges = [],
	) {
		list($from, $ign, $to) = explode('-', $name, 3);
		$this->from = $from;
		$this->to = $to;
	}

	public function addRange(Range $range): void
	{
		$this->ranges[] = $range;
	}
}

class UltraMapper
{
	public function __construct(
		public array $ranges = [],
	) {}

	public function addRange(Range $range): void
	{
		$this->ranges[] = $range;
	}
}

class Seeds
{
	private $seeds1 = [];
	private $seedRanges = [];
	public function __construct(
		public string $seedLine,
		public bool $part2 = false,
	) {
		$this->seeds1 = array_map('intval', explode(" ", $seedLine));
		for ($i = 0; $i < count($this->seeds1); $i += 2) {
			$range = Range::fromStartEnd($this->seeds1[$i],$this->seeds1[$i + 1], 0);
			$this->seedRanges[] = $range;
		}
	}

	public function getNextSeed(): Generator
	{
		if ($this->part2) {
			foreach ($this->seedRanges as $range) {
				$end = $range->dest + $range->size;
				for ($i = $range->dest; $i < $end; $i += 1) {
					yield $i;
				}
			}
			return;
		}

		foreach ($this->seeds1 as $num) {
			yield $num;
		}
	}
}

class Range
{
	public static function fromStartEnd(int $start, int $end, int $diff): Range
	{
		return new Range(
			$start,
			$end,
			$diff,
		);
	}

	public static function fromDestSource(int $dest, int $source, int $size): Range
	{
		return new Range(
			$source,
			$source + $size,
			$dest - $source,
		);
	}

	private function __construct(
		public int $start,
		public int $end,
		public int $diff,
	) {
	}

	public function apply(int $num): int
	{
		return $num + $this->diff;
	}

	public function matches(int $num): bool
	{
		return $this->start <= $num && $num < $this->end;
	}

	public function getDestRangeNumbers(): array
	{
		$result = [];
		for ($i = $this->start; $i < $this->end; $i += 1) {
			$result[] = $i;
		}
		return $result;
	}

	public function getNextNumber(): Generator
	{
		for ($i = $this->start; $i < $this->end; $i += 1) {
			yield $i;
		}
	}
}

//$testInput = file_get_contents('../inputs/test-day5.txt');

//echo solve($testInput). " === 35" .PHP_EOL;
//echo solvepart2($testInput). " === 46" .PHP_EOL;

$input = file_get_contents('../inputs/day5.txt');

$start = time();
echo solvePart2($input).PHP_EOL;
$end = time();
$time = $end - $start;
var_dump($start, $end, $time);



function getIntersection(Range $a, Range $b): array
{
	if ($a->start < $b->start && $b->end < $a->end) // b inside of a
	{
		return [
			Range::fromStartEnd($a->start, $b->start, $a->diff),
			Range::fromStartEnd($b->start, $b->end, $a->diff + $b->diff),
			Range::fromStartEnd($b->end, $a->end, $a->diff),
		];
	}
	else if ($b->start < $a->start && $a->end < $b->end) // a inside of b
	{
		return [
			Range::fromStartEnd($b->start, $a->start, $b->diff),
			Range::fromStartEnd($a->start, $a->end, $a->diff + $b->diff),
			Range::fromStartEnd($a->end, $b->end, $b->diff),
		];
	}
	else if ($a->start < $b->start && $b->start < $a->end && $a->end < $b->end) // intersect A-B
	{
		return [
			Range::fromStartEnd($a->start, $b->start, $a->diff),
			Range::fromStartEnd($b->start, $a->end, $a->diff + $b->diff),
			Range::fromStartEnd($a->end, $b->end, $b->diff),
		];
	}
	else if ($a->start < $b->start && $b->start < $a->end && $a->end < $b->end) // intersect B-A
	{
		return [
			Range::fromStartEnd($b->start, $a->start, $b->diff),
			Range::fromStartEnd($a->start, $b->end, $a->diff + $b->diff),
			Range::fromStartEnd($b->end, $a->end, $a->diff),
		];
	}
	else
	{
		return [$a, $b];
	}
}

function solve(string $input): int
{
	$maps = explode("\n\n", $input);

	$seedLine = substr(array_shift($maps), 7);
	$seeds = new Seeds($seedLine);

	$mappers = [];
	foreach ($maps as $map) {
		$lines = explode("\n", $map);
		$header = array_shift($lines);

		$name = substr($header, 0, -5);
		$mapper = new Mapper($name);
		foreach ($lines as $line)
		{
			[$dest, $source, $size] = explode(" ", $line, 3);

			$mapper->addRange(Range::fromDestSource(intval($dest),intval($source),intval($size)));
		}
		$mappers[] = $mapper;
	}


	$results = [];
	foreach ($seeds->getNextSeed() as $seed)
	{
		$results[$seed] = [];
		$results[$seed]['seed'] = $seed;
	}

	foreach ($seeds->getNextSeed() as $seed)
	{
		//echo $seed ."\n";
		foreach ($mappers as $mapper) {
			//echo "'$mapper->from' -> '$mapper->to'\n";
			$last = $results[$seed][$mapper->from];

			foreach ($mapper->ranges as $range) {
				if ($range->matches($last)) {
					$results[$seed][$mapper->to] = $range->apply($last);
					break;
				}
				else {
					$results[$seed][$mapper->to] = $last;
				}
			}
		}
	}

	$locations = array_map(fn($layers) => $layers['location'], $results);
	return min($locations);
}

function solvePart2(string $input): int
{
	$maps = explode("\n\n", $input);

	$seedLine = substr(array_shift($maps), 7);
	$seeds = new Seeds($seedLine, true);

	$mappers = [];
	foreach ($maps as $map) {
		$lines = explode("\n", $map);
		$header = array_shift($lines);

		$name = substr($header, 0, -5);
		$mapper = new Mapper($name);
		foreach ($lines as $line)
		{
			[$dest, $source, $size] = explode(" ", $line, 3);

			$mapper->addRange(Range::fromDestSource(intval($dest),intval($source),intval($size)));
		}
		$mappers[] = $mapper;
	}

	$min = PHP_INT_MAX;
	foreach ($seeds->getNextSeed() as $seed)
	{
		$result = $seed;
		foreach ($mappers as $mapper) {
			foreach ($mapper->ranges as $range) {
				if ($range->start <= $result && $result < $range->end) {
					$result += $range->diff;
					break;
				}
			}
		}
		if($min > $result) {
			$min = $result;
		}
	}

	return $min;
}

//var_dump($results);

//echo $testInput;