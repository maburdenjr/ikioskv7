# IntelliKiosk 7.0

One upon a time (circa October 2014) in a land far far away (San Francisco, CA) I used to spend all of my spare time working on personal coding projects.  On of my favorite projects was IntelliKiosk.  It's probably the most ambitions side project that I've built to date.  There have been five versions of this monolith (this was back before I was introduced to the beauty of microservices). Although I wouldn't necessarily write code today the way I did back then, it's still one of my favorite projects.  Maybe one day I will completely rebuild it using ReactJs, Node, etc.  But for now it remains as a warm reminder of many sleepliness nights and my obsession with writing code and building intuitive user experiences.

Ok nice intro, but what is it?

Version 7.0 was two big pieces:  A content management system for building and managing multiple websites and an admin application for managing users, error handling, and other fancy administrative stuff.

## Try it Out

* __Admin__: http://admin.ikioskcloudapps.com 
* __CMS__: http://www.chasingthedrift.com/cms

Contact me for the demo username and password.

## CMS Features

* Photo plbum: image uploading, album management, and dynamic thumbnail creation
* Built-in blog functionality
* WYSIWYG editor: Edit in place with inline CSS editor, resizing, and importing of code snippets
* Versioning: Quickly revert back to previous version of content
* File manager
* Template Management


### CMS Screenshots

![Cms1](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/cms1.png)
--------------------------------------------------------------------------------

![Cms2](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/cms2.png)
--------------------------------------------------------------------------------

![Cms3](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/cms3.png)
--------------------------------------------------------------------------------

![Cms4](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/cms4.png)
--------------------------------------------------------------------------------

## Admin Features

* Application Management
* Site Management
* Team Management
* User Management
* Access, Error, and MySQL Logging
* Dynamic DB Updates
* Software Management
* License Management

### Admin Screenshots

__Software Package administration__:  Allows admin users to create deployable software packages by bundling together files.  A software package could then be deployed to remote installations of IntelliKiosk.

![Admin1](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin1.png)
------------------------------------------------------------------------------------


__Dynamic DB Updates__:  Allows admin users to deploy MySQL updates to remote IntelliKiosk installations.

![Admin2](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin2.png)
------------------------------------------------------------------------------------


__User Management__:  Users can have access to various sites and be members of various teams for security and permission management.

![Admin3](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin3.png)
------------------------------------------------------------------------------------


__Code Generator__:  This is a feature I created to speed up my development time.  Automatic creation of forms for adding and modifying data in IntelliKiosk apps.

![Admin4](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin4.png)
------------------------------------------------------------------------------------


__Access Logs__:  Tracking of all access logs and DB queries.

![Admin5](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin5.png)
------------------------------------------------------------------------------------


__Site Administration__:  Create and manage multiple websites to be managed within the built-in CMS.  Includes social media and Google apps integration as well as photo uplading and thumbnail generation.

![Admin6](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin6.png)
