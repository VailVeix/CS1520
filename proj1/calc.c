#include <stdio.h>
#include <time.h>
#include <sys/time.h>
#include <errno.h>
#include "asm/unistd.h"

int main(int argc, char** argv){

	struct timeval t1;
	struct timeval t2;
	gettimeofday(&t1, NULL);
	printf("Calling...\n");
	syscall(__NR_hellokernel, 42);
	gettimeofday(&t2, NULL);

	printf("Difference %d\n", ((t2.tv_sec - t1.tv_sec)*1000000 + (t2.tv_usec - t1.tv_usec)));
}
