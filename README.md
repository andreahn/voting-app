# Instructions
These are the instructions assuming you are setting up on a new Ubuntu 16.04 VM.

```
sudo apt-get update  
sudo apt-get upgrade  
sudo apt-get install mariadb-server  
sudo apt-get install apache2  
sudo apt-get install php7.0  
sudo apt-get install apache2 php7.0 libapache2-mod-php7.0
```
Set up database:

```
sudo mysql_secure_installation
```  
When prompted to set password, just click enter to set none. Answer yes to other questions.

Set up MYSQL:

```
sudo mysql -u root -p 
UPDATE mysql.user SET plugin = 'mysql_native_password' 
WHERE user = 'root' AND plugin = 'unix_socket'; 
exit
```

Access MYSQL again and create database:
(For the user ID and password, you can set whatever you prefer)
```
mysql -u root -p  
CREATE DATABASE Voting;
CREATE TABLE Users (id CHAR(100), password(100), voted INT);
CREATE TABLE Candidates (name CHAR(100), votes INT);

INSERT INTO Candidates (name, votes) VALUES ("Donald Trump", 0);
INSERT INTO Candidates (name, votes) VALUES ("Joe Biden", 0);

INSERT INTO Users (id, password, voted) VALUES ("someUserID", "somePassword", 0);
```

You can check the tables were created correctly with these commands:
```
SELECT * FROM Users; 
SELECT * FROM Candidates;
```
Then you can exit:
```
exit 
```
  
Now open a new terminal:
```
cd /etc/  
sudo gedit hosts  
```
Below the line that says "127.0.0.1 localhost", copy and paste the following:
```
127.0.0.1 vote.gitctf  
```
Save and exit gedit (close the file).

```
sudo mkdir -p /var/www/vote  
sudo chown -R $USER:$USER /var/www/vote
sudo chmod -R 755 /var/www  

sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/vote.conf  
sudo gedit /etc/apache2/sites-available/vote.conf  
```

Delete everything in the opened file, and replace it with the following (copy and paste):
```
<VirtualHost *:80>  
   ServerName vote.gitctf  
   ServerAdmin admin@vote.gitctf  
   DocumentRoot /var/www/vote  
   ErrorLog ${APACHE_LOG_DIR}/error.log  
   CustomLog ${APACHE_LOG_DIR}/access.log combined  
</VirtualHost>
```
Save the file and exit gedit.
```
sudo a2ensite test.conf  
systemctl reload apache2  
sudo apt-get install libmysqlclient-dev  
```
Save all files in this repository inside /var/www/vote folder


Then compile the C code like this:  
```
gcc -z execstack -fno-stack-protector -z norelro -g -O0 -o login login.c `mysql_config --cflags --libs`
gcc -z execstack -fno-stack-protector -z norelro -g -O0 -o vote vote.c `mysql_config --cflags --libs`
```

You can now access it by opening 'vote.gitctf' in your browser.
