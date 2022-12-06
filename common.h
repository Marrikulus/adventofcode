#include "stdlib.h"
#include "stdio.h"
#include <assert.h>
#include <ctype.h>
#include <string.h>
#include <stdbool.h>

#define STB_DS_IMPLEMENTATION
#include "stb_ds.h"

#define FOREACH_LINE(LINE, TEXT) \
    char *LINE, *_at = strdup(TEXT); \
    while((LINE = strsep(&_at, "\n")) != NULL)

char * file_get_content(char* filename)
{
    char* result;
    FILE *file;
    file = fopen(filename, "r");
    if(file == NULL) return NULL;
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
