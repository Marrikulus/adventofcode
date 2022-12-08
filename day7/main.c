#include "../common.h"


int part2(char*input);
int part1(char*input);
int main()
{
    char* test = file_get_content("test.txt");

    printf("\ntest1 expecting %d = %d\n\n", 95437,  part1(test));
    //printf("test1 expecting %d = %d\n", 19,  part2(test));

    char* input = file_get_content("input.txt");
    printf("part1 expecting %d\n", part1(input));
    //printf("part1 expecting %d\n", part2(input, 14));
    return 0;
}


int part1(char*input)
{
    char **InDirStack = NULL;
	struct { char *key; int value; } *dir_map = NULL;
	shdefault(dir_map, 0);
    int result = 0;
	int ls_count = 0;
	int dir_count = 0;
	int file_count = 0;

    char *line, *_at = strdup(input);
    line = strsep(&_at, "\n");
    while(line != NULL)
    {
		if(strncmp(line, "$", 1) == 0)
		{
			if(strncmp(&line[2], "cd", 2) == 0)
			{
				char *cdarg = &line[5];
				if(strncmp(cdarg, "..", 2) == 0){
					//printf("Up dir '%s'\n", cdarg);
					arrpop(InDirStack);
				} else {
					//printf("change dir '%s'\n", cdarg);
					arrput(InDirStack, cdarg);
				}
				
				//printf("change dir /");
				//int len = arrlen(InDirStack);
				//int i = 0;
				//while(++i < len)
				//	printf("%s/", InDirStack[i]);
				//printf("\n");

			} else if(strncmp(&line[2], "ls", 2) == 0){
				ls_count++;
				//printf("ls\n");
    			while((line = strsep(&_at, "\n")) != NULL){
					if(strncmp(line, "$", 1) == 0)
						break;
					
					if(strncmp(line, "dir", 1) == 0) {
						dir_count++;
						//printf("\tdir %s\n", line);
					} else if(isdigit(line[0])) {
						file_count++;
						int size = atoi(strtok(line, " "));
						
						char *filename = strtok(NULL, " ");
						
						

						int i = arrlen(InDirStack);
						while(i--) {
							char *dir = InDirStack[i];
							if(shgeti(dir_map, dir) == -1)
								shput(dir_map,dir, 0);
							shget(dir_map, dir) += size;
						}
						//printf("\tfile %s %d\n", filename, size);
					}else{
						printf("anomaly %s\n", line);
					}
				}
				continue;
			} else {
				printf("command %s\n", line);
			}
		}
		else
		{
			printf("else %s\n",line);
		}

    	line = strsep(&_at, "\n");
    }

	for (int i=0; i < shlen(dir_map); ++i)
	{
		if(100000 >= dir_map[i].value)
			result += dir_map[i].value;
		//printf("%s -> %d\n",  dir_map[i].key, dir_map[i].value);
	}

	printf("ls %d\n",  ls_count);
	printf("dir %d\n",  dir_count);
	printf("file %d\n",  file_count);

    return result;
}


int part2(char*input)
{
    int result = 0;
    return result;
}

