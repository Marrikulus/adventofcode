#include "stdio.h"

char * file_get_content(char* filename)
{
    char* result;
    FILE *file;
    file = fopen(filename, "r");
    fseek(file, 0L, SEEK_END);
    int filesize = ftell(file);
    fseek(file, 0L, SEEK_SET);

    result = malloc(filesize);

    char* at = result;
    while(!feof(file)){
        *at++ = fgetc(file);
    }
    
    return result;
}
