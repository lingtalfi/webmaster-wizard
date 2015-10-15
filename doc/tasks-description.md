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





### printEnv

This task display the keys and values of the CONFIG array.
If you extend the webwizard, it could be useful for debugging purposes.
  
  
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








    
    














