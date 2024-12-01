
use std::collections::VecDeque;
use std::ops::Range;

#[derive(Debug)]
struct MyRange {
    pub range: Range<usize>,
    pub diff: usize,
}

impl MyRange {
    pub fn new(dest: usize, source: usize, size: usize) -> Self {
        MyRange {
            range: source..source + size,
            diff: dest - source,
        }
    }
}

#[derive(Debug)]
struct Mapper {
    pub ranges: Vec<MyRange>,
}

struct Seeds {
    pub ranges: Vec<MyRange>,

}



fn main() {
    let r = MyRange::new(52, 50, 48);
    println!("{:?}", r);
    return;



    let filecontent = std::fs::read_to_string("../inputs/test-day5.txt").unwrap();
    let mut all = filecontent.split("\n\n").collect::<VecDeque<&str>>();
    let _seeds = all.pop_front().unwrap().to_string();


    let mut mappers = Vec::new();
    for ble in all {
        let mut lines = ble.split("\n").collect::<VecDeque<&str>>();
        let _header = lines.pop_front().unwrap().to_string();
        let mut mapper = Mapper {
            ranges: vec![]
        };
        for line in lines.iter_mut() {
            let numbers = line.split(" ").map(|x| x.parse::<usize>().unwrap()).collect::<Vec<usize>>();
            mapper.ranges.push(MyRange::new(numbers[0], numbers[1], numbers[2]))
        }
        mappers.push(mapper);
    }


    println!("{:?}\n", mappers);
}
