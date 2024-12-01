#include "stdio.h"
#include "stdlib.h"
#include "string.h"
#include "../common.h"

char * test_input = 
"1000\n"
"2000\n"
"3000\n"
"\n"
"4000\n"
"\n"
"5000\n"
"6000\n"
"\n"
"7000\n"
"8000\n"
"9000\n"
"\n"
"10000";

static int cal_cmp(const void* a, const void* b)
{
    return -( *(int*)a - *(int*)b);
}


int main() {
    char* input = file_get_content("test1.txt");
    int list_len = 0;
    int list[2000];
    int highest = find_highest_calories(input, &list, &list_len);
    printf("highest calories: %d\n", highest);
    free(input); 

    qsort(list, list_len, sizeof(int), cal_cmp);
    int sum = 0;
    for(int i = 0; i < 3; i++)
    {
        sum += list[i];
        printf("%d: %d\n", i, list[i]);
    }
    printf("top3: %d\n", sum);

    //test1();
    return 0;
}

int test1(){
    int highest = find_highest_calories(test_input);
    printf("highest calories: %d\n", highest);
    return 0;
}


int find_highest_calories(char *input, int *list, int *list_len){
    char *rest = strdup(input);
    char *elf;
    int highest_calories = 0;
    int elf_calories = 0;
    int num = 0;

    int i = 0;
    while((elf = strsep(&rest, "\n")) != NULL){
        if(strlen(elf) == 0){
            if(elf_calories > highest_calories){
                highest_calories = elf_calories;
            }
            if(list != NULL)
                list[i++] = elf_calories;
            elf_calories = 0;
        }else {
            num = atoi(elf);
            elf_calories += num;
        }
    }
    *list_len = i;

    return highest_calories;
}

