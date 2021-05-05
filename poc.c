#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

int main () {
FILE *fp;
uid_t uid;
uid = geteuid();
fp = fopen("poc.txt", "w");
 if(fp == NULL) {
 return 0;
 }
fprintf(fp, "[Security Beasts PoC]\nOnly www-data can print this without sudo!\nUser id is: %u\nand should be 33", (unsigned)uid);
fclose(fp);
return 0;
}
