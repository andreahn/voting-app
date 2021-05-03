#include <mysql.h>
#include <string.h>
#include <stdlib.h>
#include <stdio.h>

int main(int argc, char ** argv){
  char command[256];
  MYSQL_ROW row;
  MYSQL *conn = mysql_init(NULL);
  
  if(mysql_real_connect(conn, "localhost", "root", "", "Voting", 0, NULL, 0) == NULL) {
    printf("connection failed\n");
    exit(1);
  }
  snprintf(command, 250, "UPDATE Users SET voted = 1 WHERE id = \'%s\'%c", argv[1], 59);
  if(mysql_real_query(conn, command, 250)!=0) {
    printf("vote flag failed\n");
    exit(1);
  }
  
  snprintf(command, 250, "UPDATE Candidates SET votes = votes + 1 WHERE name = \'%s\'%c", argv[2], 59);
  printf("%s\n", command);
  if(mysql_real_query(conn, command, 250)!=0) {
    printf("voting failed\n");
    exit(2);
  }
  mysql_close(conn);
  
  return 0;
}
