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
  sprintf(command, "SELECT * FROM Users WHERE BINARY id = \'%s\' AND BINARY password = \'%s\'%c", argv[1], argv[2], 59);
  
  
  // check login information
  
  if(mysql_real_query(conn, command, 250) != 0) {
    printf("query failed\n");
    exit(2);
  }
  
  MYSQL_RES *result = mysql_store_result(conn);
  if(mysql_num_rows(result) != 0) {
    row = mysql_fetch_row(result);
    printf("%s\n",row[2]);
    mysql_close(conn);
    return 11;
  }
  else {
    mysql_close(conn);
    printf(argv[1]);
    printf(" does not exist, or wrong password.\n");
    return 12;
  }
  
  return 0;
}
