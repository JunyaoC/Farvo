Developed By Team===============================================================================

	███████╗███████╗████████╗████████╗ █████╗ ██████╗ ██╗   ██╗████████╗███████╗
	╚══███╔╝██╔════╝╚══██╔══╝╚══██╔══╝██╔══██╗██╔══██╗╚██╗ ██╔╝╚══██╔══╝██╔════╝
	  ███╔╝ █████╗     ██║      ██║   ███████║██████╔╝ ╚████╔╝    ██║   █████╗  
	 ███╔╝  ██╔══╝     ██║      ██║   ██╔══██║██╔══██╗  ╚██╔╝     ██║   ██╔══╝  
	███████╗███████╗   ██║      ██║   ██║  ██║██████╔╝   ██║      ██║   ███████╗
	╚══════╝╚══════╝   ╚═╝      ╚═╝   ╚═╝  ╚═╝╚═════╝    ╚═╝      ╚═╝   ╚══════╝		
										                
=============================================================================== © 2019 Zettabyte

Readme for FARVO V1.0 release date 30/12/2019 by Team Zettabyte

This is a readme file for the Farvo System, a web system for farm management.
While it is meant to be hosted on a web server, the system can also run locally using local
web server.


To host this system on a remote web server, simply upload all the contents in hosting/source folder
into the web server's directory. Database should also be configured in order to enable communcation
with the web server. Database connection can be configured manually to your needs using the file
hosting/source/assets/php/dbconnect.php. The file farvodb.sql can be used for importing database.

This readme file comes together with 2 folders, you should see them at the same time you see this
readme file. Consider downloading the latest release of Farvo System if those 2 folders are
missing.


farvo 1.0 (the folder which you would obtain from extracting the .zip file)
│   readme.txt
│
├───hosting
│	│   farvodb.sql
│	│
│	└───source
└───localhost
	│   farvodb.sql
	│
	└───source

This readme will give the instruction for localhost installation in detail.

Steps for Local Installation

1. Depends on the web server the host machine is running, copy all contents in the localhost
   folder (not the folder itself, but contents in the folder) into the web server’s directory.
   For XAMPP’s Apache server, the web server’s directory folder will be named htdocs, usually
   located at C:\xampp\htdocs.

2. Log in to the phpMyAdmin’s admin page (XAMPP user can access it from the XAMPP control panel
   by clicking the Admin button. The server must be first started before admin page can be
   visited).

3. Create a new database named farvodb if it does not already exist. Select farvodb and click
   the import database on the navigation bar. Click choose file and select the SQL file that we
   had extracted earlier from the .zip file. This will import required table into the database.

4. Start the web server if it is not running already. XAMPP users can start the web server from
   the control panel.

5. By default, the web server runs on port 80. Hence, to access the system just open an internet
   browser and enter localhost in the address bar.  If the web server runs on a custom port, for
   example port 1234, enter localhost:1234 instead of address bar.