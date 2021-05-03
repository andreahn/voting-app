#include <mysql.h>
#include <string.h>
#include <stdlib.h>
#include <stdio.h>

int main (int argc, char **argv) {
  char command[256];
  MYSQL_ROW row;
  MYSQL *conn = mysql_init(NULL);
  
  //connect to database
  if(mysql_real_connect(conn, "localhost", "root", "", "Voting", 0, NULL, 0) == NULL) {
    printf("Connection Failed\n");
    exit(1);
  }
  
  // construct query

  
  // check login information
  
  
  return 0;
}
