#include <string>
#include <istream>
#include <fstream>
#include <iostream>
#include <sstream>
#include <vector>

std::string test = 
"vJrwpWtwJgWrhcsFMMfFFhFp\n"
"jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL\n"
"PmmdzqPrVvPwwTWBwg\n"
"wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn\n"
"ttgJtRGJQctTZtZT\n"
"CrZsJsPPZsGzwwsLwLmpwMDw";

using namespace std;

int score(char c)
{
    if(islower(c))
        return (int)(c - 'a') + 1;
    if(isupper(c))
        return (int)(c - 'A') + 27;
    return 0;
}

int part2(istream &s)
{
    vector<string> lines;
    string line;
    while(std::getline(s, line, '\n')) {
        lines.push_back(line);
    }

    int result = 0;
    for(auto group = lines.begin(); group != lines.end(); group += 3){
        char found = 0;
        for(auto c : group[0]){
            if(group[1].find(c) != string::npos &&
                group[2].find(c) != string::npos){
                found = c;
            }
        }
        result += score(found);
    }

    return result;
}

int main(){
    //std::cout << test << std::endl;
    //stringstream text(test);
    string filename = "input.txt";
    ifstream text(filename);

    int result = part2(text);

    std::cout << "Result: " << result << std::endl;
    return 0;
}
