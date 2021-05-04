#include <mysql.h>
#include <string.h>
#include <stdlib.h>
#include <stdio.h>

int main(int argc, char ** argv){
  char command[256];
  MYSQL_ROW row;
  MYSQL_RES *result;
  MYSQL *conn = mysql_init(NULL);
  
  if(mysql_real_connect(conn, "localhost", "root", "", "Voting", 0, NULL, 0) == NULL) {
    printf("connection failed\n");
    exit(1);
  }
  
  // check if user is eligible
  sprintf(command, "SELECT * FROM Users WHERE BINARY id = \'%s\' AND voted = 0 AND locked = 0%c", argv[1], 59);
  mysql_real_query(conn, command, 250);
  result = mysql_store_result(conn);
  if(mysql_num_rows(result) != 1) {
    mysql_close(conn);
    mysql_free_result(result);
    exit(2);
  }
  
  // make db reflect that the user has already voted
  snprintf(command, 250, "UPDATE Users SET voted = 1, locked = 1 WHERE BINARY id = \'%s\'%c", argv[1], 59);
  if(mysql_real_query(conn, command, 250)!=0) {
    mysql_close(conn);
    exit(3);
  } 
  
  
  // update # of votes for candidates in database
  snprintf(command, 250, "UPDATE Candidates SET votes = votes + 1 WHERE name = \'%s\'%c", argv[2], 59);
  printf("%s\n", command);
  if(mysql_real_query(conn, command, 250)!=0) {
    mysql_close(conn);
    exit(4);
  }
  
  
  mysql_close(conn);
  
  return 0;
}
