#include "../common.h"

char *test =
"vJrwpWtwJgWrhcsFMMfFFhFp\n"
"jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL\n"
"PmmdzqPrVvPwwTWBwg\n"
"wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn\n"
"ttgJtRGJQctTZtZT\n"
"CrZsJsPPZsGzwwsLwLmpwMDw";

int ascii2priority(char c)
{
    if(islower(c))
        return (int)(c - 'a') + 1;
    if(isupper(c))
        return (int)(c - 'A') + 27;
    return 0;
}



int part1(char *input);
int part2(char *input);
int main()
{
    assert(ascii2priority('a') == 1);
    assert(ascii2priority('A') == 27);
    assert(part1(test) == 157);
    assert(part2(test) == 70);

    char *real = file_get_content("input.txt");
    if(real == NULL){
        printf("The file '%s' found" "\n", "input.txt");
        return 1;
    }
    int result = part1(real);
    printf("part1=%d\n", result);

    result = part2(real);
    printf("part2=%d\n", result);

    return 0;
}


int part1(char *input)
{

    int len = 0;
    int result = 0;
    char found, c;
    FOREACH_LINE(line, input)
    {
        found = -1;
        len = strlen(line)/2;

        for(int i = 0; i < len; i++)
        {
            for(int j = len; j < len*2; j++)
            {

                if(line[i] == line[j])
                    found = line[i];
            }
        }
        result += ascii2priority(found);
        //printf("%.*s %s: %d, f=%c\n", len, line, (line+len), len, found);
    }
    return result;
}

int part2(char *input)
{
    char **list = NULL;
    int result = 0;
    FOREACH_LINE(line, input)
    {
        arrput(list, line);
    }

    for(int i = 0; i < arrlen(list)/3; i++)
    {
        int idx = i*3;
        char badge = -1;
        for(char *it = list[idx]; *it != 0; it++)
        {
            if(strchr(list[idx+1], *it) &&
               strchr(list[idx+2], *it))
                badge = *it;
        }
        result += ascii2priority(badge);
    }

    return result;
}

