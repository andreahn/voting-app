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
  fprintf(fp, "[Security Beasts] Dummy Function for PoC only if %u == 33\n", (unsigned)uid);
  fclose(fp);
  return 0;
}
