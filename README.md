#1. Introduction and Demo
![](http://documentator.org/assets/img/introduction.png)
***
>Documentator is an easy to setup, easy to use, visual markdown documentation builder

If you are a developer, designer, coder or apps builder you will find Documentator really useful. It will streamline your work documentation process helping you build better and faster instructions for your apps.

From creating and exporting README.md files to include with your app package to building a vast knowledge base website for your service or scripts, Documentator will help you do it all.

> Documentator is Opensource so you can improve it

We built Documentator with extend-ability in mind. You can find the core on GitHub to download and use and you can contribute on improving it.  
We also added hooks so you can tap into different areas and actions of the core, and setup a useful plugin system so you can extend Documentator while leaving the core untouched for future updates.

>Documentator is "Database-less" 

The core script does not use a database. It makes use of the global variables you setup on installation in config.php, BUT you can make use of the extend-ability features to implement and use a database for files/user management.

**Documentation folders and files create/edit/delete:**  
When you create a new folder Documentator creates a physical folder in the global folder you setup at installation. When you edit a folder's name it changes the current physical folder's name. When you delete a folder Documentator deletes the specified physical folder and all its contents.  

Similar actions are taken when you create/edit/delete a file, Documentator handles a .md physical file in your global folder / created folders.  

All these create/edit/delete functions are setup as hooks that also hold hooks when the action has been completed. What that means is that you can create plugins to override the Documentator's create/edit/delete hooks and setup your own, for instance instead of creating physical files and folders you can setup a database and store folders and files info in a table. OR you can keep the physical folder and files actions and tap into the action completed hooks to store info about the folder and files and the action taken in a database table.  

**User login:**  
In order to manage your documentation sets you need to be logged in Documentator. The login path is *http://mydocumentatorwebsite.com* **/login**  
You can login with the username and password setup at installation process. These login credentials are saved in config.php with the password md5 encrypted.

With the core Documentator you can only have one user since there is no db of users setup, BUT because the login function is setup as a hook you can create a database table for users and override the login hook to search accounts in your db instead of the config.php file.

>Documentator requires PHP 5.3

Before installing make sure your server has atleast **PHP version 5.3** installed

**Other dependencies:**  

* PSR-0-compatible autoloader  
* ZipArchive PHP class

>Best demo to check is documentator.org

The main Documentator website [documentator.org](http://documentator.org) is built using the Documentator script and plugins.

###1. Download Documentator from GitHub and unzip the archive on your computer

![](http://documentator.org/assets/img/instructions-download.png)

###2. Using your favorite FTP client or using your hosting cPanel upload Documentator downloaded files and folders

![](http://documentator.org/assets/img/instructions-upload.png)  

NOTE: if you want documentator to be your main website upload the source in your public\_html, if you want to host it in a subfolder upload everything in that folder, ie. public\_html/docs and you will be able to access Documentator at http://mysite.com/docs

NOTE: if you have a wordpress installation in your root folder (or any other script that makes use of .htaccess) before moving to step 3 you will need to follow the instructions specified in [Wordpress fix](http://documentator.org/1.%20Getting%20started/4.%20Wordpress%20fix)

###3. Visit the URL location of your Documentator installation and complete the Installer fields  
![](http://documentator.org/assets/img/instructions-installer.png)

####4. Once you hit "Run installer" button the script will create the config.php file and the folder that will hold docs and will redirect you to the login screen.  
![](http://documentator.org/assets/img/instructions-login.png)

###5. Check the instructions on how to write documentation [HERE](http://documentator.org/1.%20Getting%20started/3.%20Writing%20documentation)