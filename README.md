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

<h1>Set up database:</h1>

```
sudo mysql_secure_installation
```  
When prompted to set password, just click enter to set none.  
Answer 'no' to `set root password? [y/n]`.  
Answer 'yes' to other questions.

```
sudo mysql -u root -p 
UPDATE mysql.user SET plugin = 'mysql_native_password' WHERE user = 'root' AND plugin = 'unix_socket';
FLUSH PRIVILEGES;
exit
```

Access MYSQL again and create database:  
*(Note! For the user ID and password, you can set whatever you prefer)*
```
mysql -u root -p  
CREATE DATABASE Voting;
```

Exit MYSQL with `CTRL + D`.  
Save the `db-dump.sql` file **from this repository**, and cd to to where you saved it.  
Then import the database:

```
mysql -u root -p Voting < db-dump.sql
```

You can check the database was imported correctly with these commands:
```
mysql -u root -p  
USE Voting;
SELECT * FROM Users; 
SELECT * FROM Candidates;
```
Then you can exit:
```
exit 
```
<h1>Setting up Apache </h1>

Now open a new terminal  
```
cd /etc/  
sudo gedit hosts  
```
Below the line that says `127.0.0.1 localhost`, copy and paste the following:
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
sudo a2ensite vote.conf  
systemctl reload apache2  
sudo apt-get install libmysqlclient-dev  
```

<h1>Get files from repository and compile</h1>
Last step is to save all files from this repository (except sql dump file) inside /var/www/vote folder.  


Then compile the C code like this:  
```
cd /var/www/vote
sudo touch poc.txt
sudo chown www-data /var/www/vote/poc.txt
gcc -z execstack -fno-stack-protector -z norelro -g -O0 -o poc poc.c `mysql_config --cflags --libs`
gcc -z execstack -fno-stack-protector -z norelro -g -O0 -o login login.c `mysql_config --cflags --libs`
gcc -z execstack -fno-stack-protector -z norelro -g -O0 -o vote vote.c `mysql_config --cflags --libs`
```
*(Note! Ignore the warning "...login.c:39:5: warning: format not a string literal...")*  
You can now access our voting app by opening 'vote.gitctf' in your browser.  
For testing purposes, assume you have `ID: testid` and `password: testpw`.

Hint: https://gist.github.com/apolloclark/6cffb33f179cc9162d0a
