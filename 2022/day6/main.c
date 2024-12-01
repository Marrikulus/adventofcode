#include "../common.h"

char *test1 = "mjqjpqmgbljsphdztnvjfqwrcgsmlb";
char *test2 = "bvwbjplbgvbhsrlpgdmjqwftvncz";
char *test3 = "nppdvjthqldpwncqszvftbrmjlhg";
char *test4 = "nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg";
char *test5 = "zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw";

int part2(char*input, int count);
int part1(char*input);
bool check(char *input, int count);

int main()
{
    char* input = file_get_content("input.txt");
    int i = 1000;
    while(i--)
    {
        test(input);
    }
    return 0;
}
int test(char *input)
{
    printf("test1 expecting %d = %d\n", 7,  part1(test1));
    printf("test2 expecting %d = %d\n", 5,  part1(test2));
    printf("test3 expecting %d = %d\n", 6,  part1(test3));
    printf("test4 expecting %d = %d\n", 10, part1(test4));
    printf("test5 expecting %d = %d\n", 11, part1(test5));
    printf("part1 expecting %d\n", part1(input));

    printf("test1 expecting %d = %d\n", 19,  part2(test1,14));
    printf("test2 expecting %d = %d\n", 23,  part2(test2,14));
    printf("test3 expecting %d = %d\n", 23,  part2(test3,14));
    printf("test4 expecting %d = %d\n", 29,  part2(test4,14));
    printf("test5 expecting %d = %d\n", 26,  part2(test5,14));
    printf("part1 expecting %d\n", part2(input, 14));
    return 0;
}

int part1(char*input)
{
    return part2(input, 4);
}


bool check(char *input, int count){
    for(int outer = 0; outer < count;outer++){
        char a = input[outer];
        for(int inner = outer+1; inner < count;inner++) {
            char b = input[inner];
            //printf("%c %c\n",a,b);
            if(a == input[inner])
                return false;
        }
    }
    return true;
}

int part2(char*input, int count)
{
    char *input1, *input2, *input3;

    int result = 0;
    char a,b,c,d;
    int len = strlen(input);
    int test = 0;
    for(int i = 0; i < len-count; i++)
    {
        if(check(&input[i], count))
        {
            result = i+count;
            break;
        }
    }

    return result;
}
