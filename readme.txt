Step 1: Go to https://www.apachefriends.org/index.html and install 'XAMPP'
Step 2: Unpack the package into a directory of your choice. Please start the "setup_xampp.bat" and beginning the installation. 
Step 3: upon successful installation, open XAMPP and  navigate to the 'Actions' part in the middle and click on 'Start'for 'Apache' and 'MySQL' or run the command 'sudo /opt/lampp/lampp start' in terminal.

Step 4: Place my folder (CO3012_CW2_am1099) in 'C:\xampp\htdocs\' (Unzip the file first)
Step 5: Open Xampp window and click on 'admin' where it refrences 'MySQL' (should be the second line, next to 'Start/Stop' button),
 which should take to a web page called phpmyadmin or you should be able to by typing in 'http://127.0.0.1/phpmyadmin/' in your browser (if this does not work try installing phpmyadmin (if you are using linux by running the command ' sudo apt-get install phpmyadmin')
 
 Step 6:Please follow the steps in this link to install composer and laravel in order to run my project https://linuxhint.com/install-laravel-on-ubuntu/
  If you come to errors this link should help, https://blog.chapagain.com.np/solved-laravel-error-failed-to-open-stream-no-such-file-or-directory-bootstrapautoload-php/#:~:text=This%20error%20generally%20occurs%20when,Cause%3A&text=The%20missing%20dependencies%20should%20be,to%20make%20Laravel%20run%20properly.
 
Step 7: Once you are in phpmyadmin, Click on the 'New' button to create a database,
Step 8: Call the database am1099_cw3_app then click on 'create'

Step 8: cd onto my project folder and run this command in terminal 'php artisan migrate' (to create the migration and create all the tables), then run 'php artisan serve' to run the website. (link should come up, just add '/login' in front of it)

DATABASE DETAILS:

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=am1099_cw3_app
DB_USERNAME=root
DB_PASSWORD=


Step 9: Insert the following sql queries into the database to be able to see the statistics page.
There are 8 queries so that u can see the websites functionality through the different pages and trials. So to be able to see the functionality add the additional 3 volunteers so the trial ends. **You will need to create you own volunteer with your own password to log in.**

Add the following to the 'vaccines' table in phpmyadmin inside database 'am1099_cw3_app'
INSERT INTO `Vaccine` VALUES ('A','Unknown','Placebo'),('B','SLCV2020','Vaccine');

Add the following to the 'volunteers' table in phpmyadmin inside database 'am1099_cw3_app'

INSERT INTO `volunteers` VALUES ('abc123@le.ac.uk','John Smith','male',28,'123 London Road, Leicester, LE1 1GF','N/A','','A',0.5,'yes');
INSERT INTO `volunteers` VALUES ('abc1234@le.ac.uk','sara jackson','female',78,'123 London Road, Leicester, LE1 1GF','N/A','','A',0.5,'yes');
INSERT INTO `volunteers` VALUES ('abc1235@le.ac.uk','Real madrid','male',18,'123 London Road, Leicester, LE1 1GF','N/A','','A',1.0,'yes');
INSERT INTO `volunteers` VALUES ('abc1236@le.ac.uk','Lionel Messi','female',28,'123 London Road, Leicester, LE1 1GF','N/A','','A',1.0,'No');
INSERT INTO `volunteers` VALUES ('abc1237@le.ac.uk','Cristiano Ronaldo','male',38,'123 London Road, Leicester, LE1 1GF','N/A','','B',1.0,'No');
INSERT INTO `volunteers` VALUES ('abc1238@le.ac.uk','John Snow','male',26,'123 London Road, Leicester, LE1 1GF','N/A','','B',1.0,'No');
INSERT INTO `volunteers` VALUES ('abc1239@le.ac.uk','Ragnar Lothbrook','male',23,'123 London Road, Leicester, LE1 1GF','N/A','','B',0.5,'No');
INSERT INTO `volunteers` VALUES ('abc1230@le.ac.uk','Bjorn ironeside','male',58,'123 London Road, Leicester, LE1 1GF','N/A','','B',0.5,'yes');

To view the vaccine makers dashboard please register through the website making sure the email is 'admin@admin' (the rest of columns such as password can be filled as you please)

NOTE: FOR TASK 2

To test task 2: 
	To test the first part. please enter 'vaccine/all_result' in the url for the json response.
	To test the second part. please enter 'vaccine/result_byGroup/{group}/byDose/{dose}' in the url for the json response. {group} -> enter either A or B && {dose} -> enter either 1 or 0.5


