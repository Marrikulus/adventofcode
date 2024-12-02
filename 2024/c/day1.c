#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdint.h>


char* file_get_content(char* filename);
int comp(const void*, const void*);

struct CountPair {
    int64_t key;
    int64_t value;
};
#define MAX_MAP_SIZE 5000
static int mapSize = 0;
static struct CountPair map[MAX_MAP_SIZE];

void insertOrUpdateCount(int64_t key)
{
    //printf("inserting key %lu\n", key);
    for (int i = 0; i < mapSize; ++i) {
        if(map[i].key == key){
            map[i].value += 1;
            return;
        }
    }
    map[mapSize] = (struct CountPair){.key = key, .value = 1};
    mapSize += 1;
}

long int getCount(int64_t key)
{
    for (int i = 0; i < mapSize; ++i) {
        if(map[i].key == key){
            return map[i].value;
        }
    }
    return 0;
}

void printMap()
{
    for (int i = 0; i < mapSize; ++i) {
        printf("%lu: %lu \n", map[i].key, map[i].value);
    }
}
int main(int argc, char **args)
{
    if(argc < 2) {
        fprintf(stderr, "missing input dir\n");
        fprintf(stderr, "./exec <inputdir>\n");
        return 1;
    }

    char* inputDir = args[1];
    char filename[300];
    //sprintf(filename, "%s%s", inputDir, "/day1-test.txt");
    sprintf(filename, "%s%s", inputDir, "/day1.txt");

    puts(filename);
	char* input = file_get_content(filename);

	char* str = input;
	size_t count = 1;
	while(*str) if (*str++ == '\n') ++count;

	printf("%d\n", count);
    long int *list1 = calloc(count, sizeof(long int));
    long int *list2 = calloc(count, sizeof(long int));

	char* line = strtok(input, "\n");
    int i = 0;
	while(line != NULL)
	{
		char* endptr;
		list1[i] = strtol(line, &endptr, 0);
		list2[i] = strtol(endptr, NULL, 0);

        i++;
		line = strtok(NULL, "\n");
	}

#if 0 // part1
    qsort(list1, count, sizeof(long int), comp);
    qsort(list2, count, sizeof(long int), comp);

    long int sum = 0;
    for (int j = 0; j < count; ++j) {
        sum += labs(list1[j] - list2[j]);
        //printf("%lu  %lu\n", list1[j], list2[j]);
    }

    printf("\nSum: %lu \n", sum);
#else // part2
    for (int j = 0; j < count; ++j) {
        insertOrUpdateCount(list2[j]);
    }

    //printMap();

    int64_t sum = 0;
    for (int j = 0; j < count; ++j) {
        int64_t num = list1[j];
        sum += num * getCount(num);
    }
    printf("part2: %lu \n", sum);

#endif
    free(input);
    free(list1);
    free(list2);
    return 0;
}

int comp(const void* arg1, const void* arg2)
{
    unsigned long int a = *(const unsigned long int*)arg1;
    unsigned long int b = *(const unsigned long int*)arg2;

    if(a < b) return -1;
    if(a > b) return 1;
    return 0;
}

char* file_get_content(char* filename)
{
	long length = 0;
	char* buffer = 0;
	FILE *f = fopen(filename, "rb");
	if (!f)
	{
		perror("Error opening file");
		exit(1);
	}

	fseek(f, 0, SEEK_END);
	length = ftell(f);
	fseek(f, 0, SEEK_SET);
	buffer = malloc(length);
	if (!buffer)
	{
		perror("Error creating buffer for file content");
		exit(1);
	}
	fread(buffer, 1, length, f);
	fclose(f);

	return buffer;
}
