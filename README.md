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

<h3>Set up database:</h3>

```
sudo mysql_secure_installation
```  
When prompted to set password, just click enter to set none. Answer yes to other questions.

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
```

Exit MYSQL with CTRL + D.
Save the <i>db-dump.sql</i> file from this repository, and cd to to where you saved it. Then import the database:

```
mysql -u root -p Login < db-dump.sql
```

You can check the database was imported correctly with these commands:
```
mysql -u root -p  
USE Login;
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

<h1>Set up SSL</h1>
```
sudo mkdir /etc/mysql/certs
cd /etc/mysql/certs
sudo su
openssl genrsa 2048 > ca-key.pem
```

For the next few commands you may be prompted to enter some information. For Common Name, enter "MariaDB admin". You can skip everything else (just click enter)
```
openssl req -new -x509 -nodes -days 365000 -key ca-key.pem -out ca-cert.pem
openssl req -newkey rsa:2048 -days 365000 -nodes -keyout server-key.pem -out server-req.pem
openssl rsa -in server-key.pem -out server-key.pem
openssl x509 -req -in server-req.pem -days 365000 -CA ca-cert.pem -CAkey ca-key.pem -set_serial 01 -out server-cert.pem
openssl req -newkey rsa:2048 -days 365000 -nodes -keyout client-key.pem -out client-req.pem
openssl rsa -in client-key.pem -out client-key.pem
openssl x509 -req -in client-req.pem -days 365000 -CA ca-cert.pem -CAkey ca-key.pem -set_serial 01 -out client-cert.pem

```

To verify it was successful, it should say 'OK' for both client and server:
```
openssl verify -CAfile ca-cert.pem server-cert.pem client-cert.pem
```
Exit root user and open file:
```
ctrl+D
sudo gedit /etc/mysql/mariadb.conf.d/50-server.cnf
```

In the opened file, scroll down to SSL and change the directiories to the following:
(Make sure you remove the #'s from the three lines)
```
ssl-ca=/etc/mysql/certs/ca-cert.pem
ssl-cert=/etc/mysql/certs/server-cert.pem
ssl-key=/etc/mysql/certs/server-key.pem
```

Save and close the file.

```
sudo chown -Rv mysql:root /etc/mysql/certs/
sudo /etc/init.d/mysql restart
sudo gedit /etc/mysql/mariadb.conf.d/50-mysql-clients.cnf
```

In the opened file, copy and paste the following under "default-character-set"

```
ssl-ca=/etc/mysql/certs/ca-cert.pem
ssl-cert=/etc/mysql/certs/client-cert.pem
ssl-key=/etc/mysql/certs/client-key.pem
```

Save and close the file. 

To verify successful installation of SSL, do the following:

```
mysql -u root -p
SHOW VARIABLES LIKE "%ssl";
status;
quit
```

<h1>Get files from repository and compile</h1>
Last step is to save all files from this repository (except sql dump file) inside /var/www/vote folder


Then compile the C code like this:  
```
cd /var/www/vote
gcc -z execstack -fno-stack-protector -z norelro -g -O0 -o login login.c `mysql_config --cflags --libs`
gcc -z execstack -fno-stack-protector -z norelro -g -O0 -o vote vote.c `mysql_config --cflags --libs`
```

You can now access it by opening 'vote.gitctf' in your browser. For testing purposes, assume you have ID: "testid" and password: "testpw".
