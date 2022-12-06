#include "../common.h"


char* test = 
"    [D]    \n"
"[N] [C]    \n"
"[Z] [M] [P]\n"
" 1   2   3 \n"
"\n"
"move 1 from 2 to 1\n"
"move 3 from 1 to 3\n"
"move 2 from 2 to 1\n"
"move 1 from 1 to 2";

char *part1(char*input);
char *part2(char*input);
int main()
{
    char* result;
    char* input = file_get_content("input.txt");
    //char* test = file_get_content("test.txt");
    printf("finding files\n");

    //if(input == NULL){
    //    printf("Input file not found\n");
    //}
    if(test == NULL){
        printf("Test file not found\n");
    }

    //printf("running part1 on test\n");
    //result = part1(test);
    //printf("test1: %d\n",result);

    //printf("running part1 on input\n");
    //result = part1(input);
    //printf("real1: %s\n", result);

    //printf("running part2 on test\n");
    //result = part2(test);
    //printf("test2: %s\n",result);
    result = part2(input);
    printf("real2: %s\n",result);

    //free(input);
    //free(test);
    return 0;
}

typedef struct instruction {
    int count, from, to;
} Inst;


void parseStacks(char **stackStrings)
{
    char *line, *stacks[9] = {0};
    int len = strlen(arrpop(stackStrings));

    while(line = arrpop(stackStrings))
    {
        printf("test: %s\n", line);
        for(int i=0,j=0;i < len; i+=4, j++){
            char c = line[i+1];
            if(c != ' '){
                arrput(stacks[j], c);
                printf("i:%d %c\n", j, c);
            }
        }
    }
}

Inst parseInstruction(char* line)
{
    char* at;
    Inst inst;

    at = strtok(line, " ");
    at = strtok(NULL, " ");
    inst.count = atoi(at);

    at = strtok(NULL, " ");
    at = strtok(NULL, " ");
    inst.from = atoi(at);

    at = strtok(NULL, " ");
    at = strtok(NULL, " ");
    inst.to = atoi(at);

    return inst;
}

char *part1(char*input){
    char **stackLines = {0};
    char result[10] = {0};

    char *line, *_at = strdup(input);
    while((line = strsep(&_at, "\n")) != NULL)
    {
        if(strlen(line) == 0){
            break;
        }
        arrput(stackLines, line);
    }

    char *stacks[9] = {0};
    int len = strlen(arrpop(stackLines));

    while(line = arrpop(stackLines))
    {
        for(int i=0,j=0;i < len; i+=4, j++){
            char c = line[i+1];
            if(c != ' '){
                arrput(stacks[j], c);
            }
        }
    }

    while((line = strsep(&_at, "\n")) != NULL)
    {
        Inst inst = parseInstruction(line);
        int i = inst.count;
        while(i--){
            char c = arrpop(stacks[inst.from-1]);
            arrput(stacks[inst.to-1], c);
        }
    }

    char *stack;
    int i = 0;

    printf("result: ");
    while((stack = stacks[i]) != NULL && i < 9)
    {
        char c = arrlast(stack);
        printf("%c", c);
        result[i++] = c;
    }
    printf("\n");

    arrfree(stackLines);
    return result;
}

char *part2(char*input){
    char **stackLines = {0};
    char result[10] = {0};

    char *line, *_at = strdup(input);
    while((line = strsep(&_at, "\n")) != NULL)
    {
        if(strlen(line) == 0){
            break;
        }
        arrput(stackLines, line);
    }

    char *stacks[10] = {0};
    for(int i = 0, end = 9;i < end; i++)
    {
        arrsetcap(stacks[i], 400);
    }
    int len = strlen(arrpop(stackLines));

    while(line = arrpop(stackLines))
    {
        for(int i=0,j=0;i < len; i+=4, j++){
            char c = line[i+1];
            if(c != ' '){
                arrput(stacks[j], c);
            }
        }
    }

    int maxCount = 0;
    char c;
    int it = 0;
    while((line = strsep(&_at, "\n")) != NULL)
    {
        //printf("Inst: %s\n", line);
        Inst inst = parseInstruction(line);
        char *from = stacks[inst.from-1];
        char *to = stacks[inst.to-1];
        it = 0;

        int len = arrlen(from);
        while(it < inst.count)
        {
            int idx = len - inst.count + it;
            c = from[idx];
            //printf("%d: %d moving %c from %d to %d\n", it, idx, c, inst.from, inst.to);
            arrput(to, c);
            it++;
        }
        while(it--){
            //printf("do popping %d\n", it);
            c = arrpop(from);
            //printf("%d popping %c from %d \n", it, c, inst.from);
        }

        //printf("it: %d\n", it);
        assert(it == -1);

/*
        char *stack;
        for(int i = 0, end = 9;i < end; i++)
        {
            printf("%d: %s", i+1, stack);
            for(int j = 0, end = arrlen(stack);j < end; j++)
                printf("%c", stack[j]);
            printf("\n");
        }
*/
    }


    char *stack;
    int i = 0;
    //for(int i = 0;(stack = stacks[i]) != NULL && i < 9; i++)
    while((stack = stacks[i]) != NULL && i < 9)
    {
        char c = arrlast(stack);
        result[i++] = c;
    }

    arrfree(stackLines);
    return strdup(result);
}
