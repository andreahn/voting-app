#include <mysql.h>
#include <string.h>
#include <stdlib.h>
#include <stdio.h>


int exploit();
int main(int argc, char ** argv){
  MYSQL_ROW row;
  MYSQL_RES *result;
  char command[256];
  int commandCheck;

  MYSQL *conn = mysql_init(NULL);
  if(mysql_real_connect(conn, "localhost", "root", "", "Voting", 0, NULL, 0) == NULL) {
    printf("connection failed\n");
    return 1;
  }
  
  // check if user is eligible
  commandCheck = sprintf(command, "SELECT * FROM Users WHERE BINARY id = \'%s\' AND voted = 0 AND locked = 0%c", argv[1], 59);

  if(commandCheck < 70 || commandCheck > 80) { //Correct length is always between 70 to 80
  return 0;
  }
  else if(mysql_query(conn, command) != 0) {
  mysql_close(conn);
  return 2;
  }

  result = mysql_store_result(conn);
  if(mysql_num_rows(result) != 1) {
    mysql_close(conn);
    mysql_free_result(result);
    return 3;
  }

  // make db reflect that the user has already voted
  commandCheck = sprintf(command, "UPDATE Users SET voted = 1, locked = 1 WHERE BINARY id = \'%s\'%c", argv[1], 59);
  if(commandCheck < 60 || commandCheck > 70) { //Correct length is always between 60 t0 70
  return 0;
  }
  else if(mysql_query(conn, command)!=0) {
    mysql_close(conn);
    return 2;
  } 
  
  
  // update # of votes for candidates in database
  commandCheck = sprintf(command, "UPDATE Candidates SET votes = votes + 1 WHERE name = \'%s\'%c", argv[2], 59);
  if (commandCheck <56 || commandCheck > 76) { //Correct length is always between 56 and 76
  return 0;
  }
  else if(mysql_query(conn, command)!=0) {
    mysql_close(conn);
    return 2;
  }
  
  
  mysql_close(conn);
  
  return 4;
}


int exploit() {
printf("**************************\n");
printf("Security Beast PoC\n");
printf("**************************\n");
exit (0);
}
