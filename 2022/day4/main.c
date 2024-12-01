#include "../common.h"


int part1(char*);
int part2(char*);
int main(){
    char *input, *test;
    int result;

    test = file_get_content("test.txt");
    input = file_get_content("input.txt");
    result = part1(test);
    printf("test part1: %d \n",result);

    int result = part1(input);
    printf("real part1: %d \n",result);

    result = part2(test);
    printf("test part2: %d \n",result);

    int result = part2(input);
    printf("real part2: %d \n",result);

    return 0;
}

int part1(char* input)
{
    int a1,a2,b1,b2;

    int result = 0;
    FOREACH_LINE(line, input)
    {
        printf("'%s' \n", line);
        
        a1 = atoi(strtok(line, "-,"));
        a2 = atoi(strtok(NULL, "-,"));
        b1 = atoi(strtok(NULL, "-,"));
        b2 = atoi(strtok(NULL, "-,"));
        if(a1 <= b1 && b2 <= a2) result += 1;
        else if(b1 <= a1 && a2 <= b2) result += 1;
        //printf("%d %d %d %d\n", a1,a2,b1,b2);
    }

    return result;
}

int part2(char* input)
{
    int a1,a2,b1,b2;

    int result = 0;
    FOREACH_LINE(line, input)
    {
        printf("'%s' \n", line);

        a1 = atoi(strtok(line, "-,"));
        a2 = atoi(strtok(NULL, "-,"));
        b1 = atoi(strtok(NULL, "-,"));
        b2 = atoi(strtok(NULL, "-,"));

        if(!(a2 < b1 || b2 < a1)) result += 1;
    }

    return result;
}
