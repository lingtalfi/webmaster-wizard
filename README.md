Webmaster Wizard
=======================
2015-10-14



The webmaster wizard is a tool for webmasters that allows you to quickly perform basic administration tasks.
It's all about automation.



![wwiz-demo](http://s19.postimg.org/v24diue8z/wwiz_demo.gif)




Audience
------------

- you have an application with a database that resides on your local machine, and you have the online version of your 
    application on a remote server. From time to time, you need to perform administrative tasks on the 
    database of the application.
    
    
- you want to execute tasks on a batch of files (resizing images, renaming files).     





Features
-------------

- cool native tasks: download remote db, recreate remote db in local, apply sql patch to remote or local machine, resize all the images in a directory, rename files, ...
- writing a new task is easy (native tasks are coded in php) 
- create your own alias 
- built on top of bash manager with phpManager plugin



> As far as I'm concerned, the main benefit of the webmaster wizard is probably that instead of typing long lines 
like this (which I personally don't alwyas remember by the way):

  
```bash  
ssh 12.34.56.78 -p 2424 -i ~/.ssh/id_dsa_keyone -l lingtalfi 'mysqldump -usketch -pZERj07Fe1 sketch' > /tmp/sketch.mysql; mysql -uroot -proot sketch < /tmp/sketch.mysql  
```
  
We can simply type this:
```bash  
wwiz mirror sketch  
```



What are the native tasks exactly?
-------------------------------------


Task            |      my alias    |      description
--------------   |  -------------------- | ---------------------
downloadDb       |     ddb               |  download a remote database and put it in a given file   
mirror           |     mirror            |  download a remote database, put it in a given file, and inject it in your local database   
patch2Local      |     patchl            |  apply a sql file (bunch of sql statements) to the local database  (use this when you update your database structure for instance)   
patch2Remote     |     patchr            |  apply a sql file (bunch of sql statements) to the remote database  (use this when you update your database structure for instance)   
backupDataLocal  |     bd                |  creates a backup of your local database with data, and put it in a given location     
backupStructureLocal  |     bs           |  creates a backup of your local database without data, just the structure, and put it in a given location
saveFromLocal  |     sl           |  dumps the local database to a given tmp file
saveFromLocalDestructive  |     sld           |  dumps the local database to a given tmp file, using drop database statement
applyToLocal  |     al           |  applies the statements in the tmp file to the local database
saveFromRemote  |     sr           |  dumps the remote database to a given (local) tmp file
saveFromRemoteDestructive  |     srd           |  dumps the remote database to a given (local) tmp file, using drop database statement
applyToRemote  |     ar           |  applies the statements in the (local) tmp file to the remote database
batchFileImport  |     import           |  import a directory into a tmp working directory
batchFileImportClean  |     importc           |  import a directory into a tmp working directory, cleans the tmp working directory before hand
batchFileResize  |     resize           |  resize images (using [image magick](http://www.imagemagick.org/script/index.php)) in place from the tmp working directory
batchFileRename  |     rename           |  rename files (using [ornella tag notation](https://github.com/lingtalfi/ornella/blob/master/ornella-tag-notation.md)) in place from the tmp working directory
batchFileExport  |     export           |  export a the tmp working directory to a given destination directory
batchFileExportDestructive  |     exportd           |  export a the tmp working directory to a given destination directory, cleans the destination directory before hand


Want more, check out the complete [tasks description](https://github.com/lingtalfi/webmaster-wizard/blob/master/doc/tasks-description.md).


Other available tasks
-----------------------

The following tasks are also available since 1.4.0.


Task            |      my alias    |      description
--------------   |  -------------------- | ---------------------
openHome       |     home               |  mac only: open the home of the web wizard in finder
listTasks       |     list               |  list the tasks of the currently parsed config file, organized by directories, and show aliases if any
ai2jpg       |     ai               |  scan the given directory and create a jpg file for every ai file found. If on mac, open the dir afterward. 





I personally put them in a local.txt config file (see local.demo.txt in the home/config.d directory), and use the following alias

```bash
alias wloc='bashman -h "/path/to/your/home" -c local.txt -v'
```

Also, I added those bashmanager aliases:

```bash
#--------------------------
# Mac
#--------------------------
home = -t openHome -p _none_


#--------------------------
# Native
#--------------------------
list = -t listTasks -p _none_

#--------------------------
# Image
#--------------------------
ai = -t ai2jpg -p _none_
```



So to call those tasks, I do the following from a terminal:


```bash
wloc home       
wloc list
wloc ai
```



### What does this command do?

The above commands are almost just aliases for simple bash commands.
Here are some correspondances between the wwiz commands and the bash commands.



- downloadDb 

```bash
ssh 12.34.56.78 -p 2424 -i ~/.ssh/id_dsa_keyone -l lingtalfi 'mysqldump -usketch -pZERj07Fe1 sketch' > /tmp/sketch.mysql    
```    

- mirror

```bash
ssh 12.34.56.78 -p 2424 -i ~/.ssh/id_dsa_keyone -l lingtalfi 'mysqldump -usketch -pZERj07Fe1 sketch' > /tmp/sketch.mysql;  mysql -uroot -proot sketch < /tmp/sketch.mysql    
```    

- patch2Local

```bash
mysql -uroot -proot sketch < "/path/to/app/patches/last.sql"    
```    

- patch2Remote

```bash
ssh 12.34.56.78 -p 2424 -i ~/.ssh/id_dsa_keyone -l lingtalfi 'mysql -usketch -pZERj07Fe1 sketch' < "/path/to/app/patches/last.sql"    
```    


- backupDataLocal

```bash
# this task actually allows us to use the {datetime} tag, or the {date} tag
mysqldump -uroot -proot sketch > /tmp/db_and_data.{datetime}.sql    
```    


- backupStructureLocal

```bash
# this task actually allows us to use the {datetime} tag, or the {date} tag
mysqldump --no-data -uroot -proot sketch > /tmp/db_no_data.{datetime}.sql
```    




hello tutorial
-------------------

I will assume that you know the basic mechanisms of [bash manager](https://github.com/lingtalfi/bashmanager)
and that you have a bashman command in your $PATH.
(see [this section](https://github.com/lingtalfi/bashmanager#creating-the-bashman-command) if you don't have it yet)


### Downloading the code

[Install the bashman]( https://github.com/lingtalfi/bashmanager/blob/master/doc/install-bashmanager.eng.md )
command on your system (if it's not there already)


Then download the webWizard code (or clone it) in a directory of your choice.


### Configuring the wizard

Next, configure the wizard for an imaginary project named sketch, which is already online, and you have a working copy
on your local machine.

Rename the **[home]/config.d/myconf.demo.txt** file to **[home]/config.d/myconf.txt**, 
you should see the following content in it:

```
#----------------------------------------
# Configuration tasks
#----------------------------------------


secure(php)*:
sketch=1


sshString(php)*:
sketch=conn1


localDbInfo(php)*:
sketch=sketch:root:root


remoteDbInfo(php)*:
sketch=sketch:sketch:ZERj07Fe1


patchLocation(php)*:
sketch=/path/to/app/patches/last.sql



tmpFile(php)*:
sketch=/tmp/wwiz.tmp.sql



#----------------------------------------
# debug task
#----------------------------------------
printEnv(php):
sketch=




#----------------------------------------
# Database tasks
#----------------------------------------

downloadDb(php):
sketch=/tmp/last.sql


mirror(php):
sketch=/tmp/last.sql


patch2Local(php):
sketch=


patch2Remote(php):
sketch=


backupDataLocal(php):
sketch=/tmp/sketch.data.{datetime}.sql


backupStructureLocal(php):
sketch=/tmp/sketch.schema.{datetime}.sql



# Database apply - save (2015-10-15 by lingTalfi)
#----------------------------------------
saveFromLocal(php):
sketch=

saveFromLocalDestructive(php):
sketch=

applyToLocal(php):
sketch=

saveFromRemote(php):
sketch=

saveFromRemoteDestructive(php):
sketch=

applyToRemote(php):
sketch=



```


Adapt the values to fit your application.
Read more about the 
[tasks here](https://github.com/lingtalfi/webmaster-wizard/blob/master/doc/tasks-description.md).


For now, we are done with the task configuration.
If later you want to add a new project, duplicate all the lines starting with "sketch=",
and adapt the values (and replace sketch by the name of your project of course). 



### Testing the setup

At this point, our software is ready and we can call its methods.
Before we execute some database tasks, let's check the setup first.

We will execute the printEnv task, which is totally safe to execute (it only prints the CONFIG array).
If this works, then we know that we have our wwiz setup right.  


Type the following command: 

```bash
bashman -h /path/to/your/home -c myconf -v -t printEnv -p sketch 
```

Which, as you should know, means: execute the bashmanager with:

- home:  /path/to/your/home
- config file:  myconf
- task:  printEnv
- project:  sketch
- verbose:  1

Actually the verbose flag is crucial here, if you forget it, you will get no output at all.


You should see something like this (more or less):

```bash
webmaster-wizard > bashman -h "/path/to/your/home" -v -c myconf -t printEnv -p sketch
webWizard(v): Collecting config files: 
webWizard(v): -- ./myconf.txt
webWizard(v): Collecting tasks: 
webWizard(v): -- printEnv
webWizard(v): Collecting projects: 
webWizard(v): -- sketch
webWizard(v): Scanning config file ./myconf.txt
webWizard(v): Processing project sketch
webWizard(v): ---- TASK:  secure ------------
webWizard(v): populating CONFIG[SECURE]=1
webWizard(v): -------------------------------
webWizard(v): ---- TASK:  sshString ------------
webWizard(v): populating CONFIG[SSH_STRING]=conn1
webWizard(v): ----------------------------------
webWizard(v): ---- TASK:  localDbInfo ------------
webWizard(v): populating CONFIG[LOCAL_DB]=sketch
webWizard(v): populating CONFIG[LOCAL_DB_USER]=root
webWizard(v): populating CONFIG[LOCAL_DB_PASS]=(the given password)
webWizard(v): ------------------------------------
webWizard(v): ---- TASK:  remoteDbInfo ------------
webWizard(v): populating CONFIG[REMOTE_DB]=sketch
webWizard(v): populating CONFIG[REMOTE_DB_USER]=sketch
webWizard(v): populating CONFIG[REMOTE_DB_PASS]=(the given password)
webWizard(v): -------------------------------------
webWizard(v): ---- TASK:  patchLocation ------------
webWizard(v): populating CONFIG[PATCH_LOCATION]=/path/to/app/patches/last.sql
webWizard(v): --------------------------------------
webWizard(v): ---- TASK:  printEnv ------------
webWizard(v): BASH_MANAGER_CONFIG_SECURE: 1
webWizard(v): BASH_MANAGER_CONFIG__PROGRAM_NAME: webWizard
webWizard(v): BASH_MANAGER_CONFIG__HOME: /path/to/your/home
webWizard(v): BASH_MANAGER_CONFIG_BACKUP_DIR_LOCAL: /path/to/private/mysql/backup
webWizard(v): BASH_MANAGER_CONFIG_SSH_STRING: conn1
webWizard(v): BASH_MANAGER_CONFIG_PATCH_LOCATION: /path/to/app/patches/last.sql
webWizard(v): BASH_MANAGER_CONFIG__VALUE:
webWizard(v): BASH_MANAGER_CONFIG_REMOTE_DB_PASS: ZERj07Fe1
webWizard(v): BASH_MANAGER_CONFIG_REMOTE_DB: sketch
webWizard(v): BASH_MANAGER_CONFIG_LOCAL_DB: sketch
webWizard(v): BASH_MANAGER_CONFIG_REMOTE_DB_USER: sketch
webWizard(v): BASH_MANAGER_CONFIG_LOCAL_DB_USER: root
webWizard(v): BASH_MANAGER_CONFIG_LOCAL_DB_PASS: root
webWizard(v): ---------------------------------------
```


This is the default bash manager output.
We can see that all our configuration tasks (whose names end with the asterisk) have been executed.
The last task executed is printEnv, which displays the keys and values of the CONFIG array.


If you made it to this point, congratulations.
You now know how to execute a web wizard task, and you might want to play with the other action tasks.


In the next sections, I give you more tips to improve your web wizard workflow.





Adding the wwiz alias
-------------------------------------

The web wizard being a bash manager software, we need to call the bashmanager program every time. 

```bash
bashman -h /path/to/your/home -c myconf -v -t printEnv -p sketch 
```

This command is too long to type, let's make a wwiz alias that will replace the first part of the command from the beginning to the -v flag included,
so that we can type this instead: 

```bash
wwiz -t printEnv -p sketch 
```

Note: while it's possible to not include the -v flag in the wwiz alias, I would not recommend it. 
Bash manager being either very verbose or not at all, if you don't use the -v flag, your commands will be totally 
quiet (except for errors); so it's probably best to include the -v flag to see what's going on.


To create the alias, if you don't know how, open the ~/.bashrc file and put the following line in it:

```bash
alias wwiz='bashman -h "/path/to/your/home" -c myconf -v'
```

Then you have to reopen your terminal in order to see the changes (or source the ~/.bashrc file).






Adding your own wwiz aliases
-------------------------------------

In the previous section, we managed to reduce the web wizard call to this one liner:

```bash
wwiz -t printEnv -p sketch 
```

To be honest, I think it's still too wordy.
Our goal in this section is to reduce it to something like this:

```bash
wwiz print sketch 
```

which is a clean and straight forward command, as I like them.


It turns out that this type of aliasing is a native feature of bashmanager as of version 1.04.
The documentation for [bashmanager aliases is here](https://github.com/lingtalfi/bashmanager/blob/master/doc/aliases.eng.md).

Open/create the ~/.bashmanager file and write the following content in it:

```bash
alias[webWizard]:


#--------------------------
# database
#--------------------------
ddb = -t downloadDb -p
mirror = -t mirror -p
patchl = -t patch2Local -p
patchr = -t patch2Remote -p
bd = -t backupDataLocal -p
bs = -t backupStructureLocal -p
print = -t printEnv -p




#--------------------------
# database: save-apply
#--------------------------
al = -t applyToLocal -p
ar = -t applyToRemote -p
sld = -t saveFromLocalDestructive -p
sl = -t saveFromLocal -p
srd = -t saveFromRemoteDestructive -p
sr = -t saveFromRemote -p


#--------------------------
# batch file treatment
#--------------------------
import = -t batchFileImport -p _none_ --option-_VALUE_batchFileImport
importc = -t batchFileImportClean -p _none_ --option-_VALUE_batchFileImportClean
export = -t batchFileExport -p _none_ --option-_VALUE_batchFileExport
exportd = -t batchFileExportDestructive -p _none_ --option-_VALUE_batchFileExportDestructive
resize = -t batchFileResize -p _none_ --option-_VALUE_batchFileResize 
rename = -t batchFileRename -p _none_ --option-_VALUE_batchFileRename  
```
    


Obviously, you can change/add/remove the aliases there, but that's my personal defaults.




Links
----------------------


Web wizard uses [phpManager plugin]( https://github.com/lingtalfi/bashmanager_plugin_phpmanager ) for bash manager.
  


History Revisions
--------------------


- 1.5.0 -- 2016-03-03 09:54

    Add imagemagick montage command to ai2jpg task
    
    
- 1.4.0 -- 2016-02-27 21:12

    Add local.txt config file and openHome, listTasks and ai2jpg tasks
    

- 1.3.0 -- 2015-10-24 09:12

    For batch file treatment tasks, on mac, the import and importClean tasks also opens the working directory in the finder

- 1.2.0 -- 2015-10-22 12:00

    Add Batch File Treatment tasks
    
    
- 1.1.0 -- 2015-10-15 23:38

    Add Database save-apply tasks

    
- 1.0.0 -- 2015-10-15 09:47

    Initial revision



