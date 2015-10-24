Tasks description
======================
2015-10-15



Tasks in web wizard (wwiz) are divided in three categories: configuration, debug, and action.<br>
The configuration tasks role is to prepare the config values for the action tasks.

The debug tasks are utility for wwiz hackers.



The configuration category tasks are all suffixed with the asterisk symbol (*).<br>
This is a new feature from bash manager 1.04, which allows a task to be executed no matter what.<br>
This feature was clearly designed to create configuration tasks.


So now let's go through each task and explain briefly what it does.


Configuration Tasks
-----------------------

### The secure task

possible values: 0 | 1
- 0: indicates to other tasks that passwords should be displayed in plain text in the terminal
- 1: indicates to other tasks that passwords should not be displayed in plain text in the terminal

If you are not paranoid and have no one behind your shoulders, you probably want to set this setting to 
0 so that you know exactly which command is executed.

It has no consequence on the actual command being executed, it just alter the visual output.

### sshString

Imagine you execute an ssh command in bash.
The part between the ssh keyword and the distant command that you execute is what sshString represents.

If you use the 
[ssh config trick](https://github.com/lingtalfi/webmaster-tricks/blob/master/tricks/ssh-config.md), 
this can actually be only one word.
If you don't, it can be something like:


```
sshString(php)*:
sketch=12.34.56.78 -p 2424 -i ~/.ssh/id_dsa_keyone -l lingtalfi
 
```

The value of this task is executed in every command that connects to the remote server via ssh.




### localDbInfo & remoteDbInfo

Those are respectively the db parameters for your local machine and your remote machine.
The task value is composed of three components separated by the colon symbol (:).
The first component is the database name, the second component is the database user, and the third
component is the database pass.

    taskValue:  <databaseName> <:> <databaseUser> <:> <databasePass>
    
    
### patchLocation
    
This tasks's value is used whenever a **patch** is applied, using either the 
patch2Local task or the patch2Remote task.

A patch here refers to a simple file which contains sql statements.<br>
This type of patch might be useful if you make small changes in your local database
that can be applied directly on the remote database without the need to interrupt the application.
For instance, adding a new table can be patched to your remote database without the need to interrupt the application.

The task's value represents the location of the patch on the filesystem of your local machine.<br>


### tmpFile (1.1+)

Defines the tmpFile that "database save-apply" tasks use.



Util Tasks
-----------------------

### printEnv

This task display the keys and values of the CONFIG array.
If you extend the webwizard, it could be useful for debugging purposes.
  
  
  
Database Tasks
-----------------------
  
  
### downloadDb
  
This is the first database task.
From now on, the tasks use the values put in the CONFIG by configuring tasks.

This task dumps the remote database and in the file which path is specified as the task's value.

  
### mirror
  
This task acts like the downloadDb: it dumps the remote database and in the file which path is specified 
as the task's value.
However, it also applies the downloaded file (which is a bunch of sql statements) to your local database.


### patch2Local

As we said before, a patch in this context is a file containing a bunch of sql statements.
This task applies the patch (which path was given by the patchLocation task) to your local database.



### patch2Remote

This task applies the patch (which path was given by the patchLocation task) to your remote database.


### backupDataLocal

This task dumps your local database (structure and data) to the file which path is given by the task's value


### backupStructureLocal

This task dumps your local database (structure only) to the file which path is given by the task's value


Database Tasks, save-apply (1.1+)
-----------------------

Do the basic mysql < file and mysqldump operations in any direction using two consecutive commands.
Gives more power to your fingertips.


![wwiz -- apply-save ](http://s19.postimg.org/hx2nhyoir/wwiz_save_apply.jpg)


### saveFromLocal

Takes no value.
Dumps the local database to the tmpFile defined by the tmpFile task.
Uses the basic mysqldump command.


### saveFromLocalDestructive

Takes no value.
Dumps the local database to the tmpFile defined by the tmpFile task.
Uses the mysqldump command with the drop-database feature.



### applyToLocal

Takes no value.
Applies the sql statements stored in the tmpFile defined by the tmpFile task to the local database.



### saveFromRemote

Takes no value.
Dumps the remote database to the tmpFile defined by the tmpFile task.
Uses the basic mysqldump command.


### saveFromRemoteDestructive

Takes no value.
Dumps the remote database to the tmpFile defined by the tmpFile task.
Uses the mysqldump command with the drop-database feature.



### applyToRemote

Takes no value.
Applies the sql statements stored in the tmpFile defined by the tmpFile task to the remote database.



Batch File Tasks, (1.2+)
-----------------------

Those tasks help doing batch tasks, like renaming all the files in a folder, or resizing all images in a folder,
that kind of things.

Batch File Treatments is based on a workflow that you can adopt if you want.


![wwiz -- batch-file-treatment ](http://s19.postimg.org/kmyr4dmzn/wwiz_batch_file_treatment.jpg)


First, you copy a directory to a working directory, so that your original files are left untouched. This is called import.
Then, you work on the files in the working directory (resize, rename, ...)
The last step is to export your work to a destination directory of your choice. This is called export.



### defaultImportDir

Defines the value of the default import dir.
If you don't specify the import dir location via the command line, the defaultImportDir value
will be used.

### defaultExportDir

Defines the value of the default export dir.
If you don't specify the export dir location via the command line, the defaultExportDir value
will be used.


### tmpDir

Defines the location of the tmp dir (working directory).



### batchFileImport

Copies the content of the import directory to the working directory.
As of 1.3, on mac, it also opens the working directory in the finder.


### batchFileImportClean

Cleans the working directory, and copies the content of the import directory to the working directory.
As of 1.3, on mac, it also opens the working directory in the finder.


### batchFileResize

Resize the images (jpeg, png, gif) in the working directory.
The syntax (assuming you are using ling aliases) is:

```bash
wwiz resize 600x400
```

Where 600 is the max width and 400 the max height.
The image keeps its proportion.
Images are replaced inline (no copy).



### batchFileRename

Rename the files in the working directory.
The syntax (assuming you are using ling aliases) is:

```bash
wwiz rename {fileName}.{ext}
```

The allowed tags are:

- {fileName}: the file name as defined in [the file name convention](https://github.com/lingtalfi/ConventionGuy/blob/master/convention.fileNames.eng.md)
- {ext}: the file extension

We can apply some functions to the tags using the [ornella tag notation](https://github.com/lingtalfi/ornella/blob/master/ornella-tag-notation.md).


### batchFileExport

Copies the content of the working directory to the export directory.


### batchFileImportClean

Cleans the export directory, and copies the content of the working directory to the export directory.






    
    














