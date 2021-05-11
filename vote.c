#include <mysql.h>
#include <string.h>
#include <stdlib.h>
#include <stdio.h>


int exploit();
int main(int argc, char ** argv){
  MYSQL_ROW row;
  MYSQL_RES *result;
  char command[256];
  char commandResult[256];
  int commandCheck;
  
  MYSQL *conn = mysql_init(NULL);
  if(mysql_real_connect(conn, "localhost", "root", "", "Voting", 0, NULL, 0) == NULL) {
    printf("connection failed\n");
    return 1;
  }
  
  // check if user is eligible
  commandCheck = sprintf(command, "SELECT * FROM Users WHERE BINARY id = \'%s\' AND BINARY password = \'%s\' AND voted = 0 AND locked = 0%c", argv[1], argv[2], 59);
  
  if(commandCheck < 70 || commandCheck > 110) { //Correct length is always between 70 to 110
    return 0;
  }
  else if(mysql_real_query(conn, command, 110) != 0) {
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
  commandCheck = snprintf(command, 250, "UPDATE Users SET voted = 1, locked = 1 WHERE BINARY id = \'%s\'%c", argv[1], 59);
  if(commandCheck < 60 || commandCheck > 70) { //Correct length is always between 60 t0 70
    return 0;
  }
  else if(mysql_real_query(conn, command, 110)!=0) {
    mysql_close(conn);
    return 2;
  } 
  
  // update # of votes for candidates in database
  commandCheck = snprintf(command, 250, "UPDATE Candidates SET votes = votes + 1 WHERE name = \'%s\'%c", argv[3], 59);
  if (commandCheck <56 || commandCheck > 80) { //Correct length is always between 56 and 80
    return 0;
  }
  else if(mysql_real_query(conn, command, 110)!=0) {
    mysql_close(conn);
    return 2;
  }
  mysql_close(conn);
  return 4;
}

int exploit() {
  printf("[Security Beasts] Dummy Function for PoC\n");
  return 0;
}
