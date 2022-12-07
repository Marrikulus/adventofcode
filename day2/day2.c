#include "assert.h"
#include "string.h"
#include "stdlib.h"
#include "../common.h"

int result1 = 15;
int result_part2 = 12;
char *input1 =
"A Y\n" //r-p 6+2
"B X\n" //p-r 0+1
"C Z";  //s-s 3+3

int result2 = 6;
char *input2 =
"A Z\n" //r-s 0+3
"B X\n" //p-r 0+1
"C Y";  //s-p 0+2

int result3 = 24;
char *input3 =
"A Y\n" //r-p 6+2
"B Z\n" //p-s 6+3
"C X";  //s-r 6+1

int result4 = 15;
char *input4 =
"A X\n" //r-r 3+2
"B Y\n" //p-p 3+3
"C Z";  //s-s 3+1

int follow_strategy(char *input);
int calculate_strategy(char *input);
int main(){

    assert(result1 == calculate_strategy(input1));
    assert(result2 == calculate_strategy(input2));
    assert(result3 == calculate_strategy(input3));
    assert(result4 == calculate_strategy(input4));

    assert(result_part2 == follow_strategy(input1));
    
    char *input = file_get_content("input.txt");
    int score = calculate_strategy(input);
    printf("end score part1: %d\n", score);

    int fscore = follow_strategy(input);
    printf("end score part2: %d\n", fscore);

    return 0;
}

enum RPS
{
    ROCK = 1,
    PAPER,
    SCISSOR,
};

enum Result
{
    LOSE = 1,
    DRAW,
    WIN,
};

int cal_win(elf, me){
    return ( elf < me //this takes care of most cases
                // these are needed because of wrapping 
            || (elf == SCISSOR && me == ROCK)// I should also win in this case
        ) && !(elf == ROCK && me == SCISSOR) // but not win not in the reverse case
}

int cal_win2(elf, me){
    return ( elf < me //this takes care of most cases
                // these are needed because of wrapping 
            || (elf == SCISSOR && me == ROCK)// I should also win in this case
        ) && !(elf == ROCK && me == SCISSOR) // but not win not in the reverse case
}

int calc_score(elf, me){
    int score = 0;
    score += me;
    if(elf == me){ //draw
        score += 3;
    } else if(
        ( elf < me //this takes care of most cases
                // these are needed because of wrapping 
            || (elf == SCISSOR && me == ROCK)// I should also win in this case
        ) && !(elf == ROCK && me == SCISSOR) // but not win not in the reverse case
    ){ //win
        score += 6;
    }
    return score;
}

int follow_strategy(char *input)
{
    char *strategy, *column_1, *column_2, *result;
    int score = 0, elf, me, result_needed;
    strategy = strdup(input);
    while((column_1 = strsep(&strategy, " \n")) != NULL){
        column_2 = strsep(&strategy, " \n");

        elf           = (*column_1)-64; //'A'-64 == 1
        result_needed = (*column_2)-87; //'X'-87 == 1

        switch(result_needed){
        case WIN:{
            result = "win";
            switch(elf){
            case ROCK:    me = PAPER;break;
            case PAPER:   me = SCISSOR;break;
            case SCISSOR: me = ROCK;break;
            }
        }break;
        case DRAW:{
            result = "draw";
            switch(elf){
            case ROCK:    me = ROCK;break;
            case PAPER:   me = PAPER;break;
            case SCISSOR: me = SCISSOR;break;
            }
        }break;
        case LOSE:{
            result = "lose";
            switch(elf){
            case ROCK:    me = SCISSOR;break;
            case PAPER:   me = ROCK;break;
            case SCISSOR: me = PAPER;break;
            }
        }break;
        }
        //printf("elf:%d me:%d result: %s\n", elf, me, result);
        
        score += calc_score(elf, me);
    }
    

    return score;
}

int calculate_strategy(char *input)
{
    char *strategy, *column_1, *column_2;
    int score = 0, elf, me;
    strategy = strdup(input);
    while((column_1 = strsep(&strategy, " \n")) != NULL){
        column_2 = strsep(&strategy, " \n");
        elf = (*column_1)-64;
        me = (*column_2)-87;

        score += calc_score(elf, me);
    }

    return score;
}
