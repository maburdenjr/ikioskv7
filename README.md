# IntelliKiosk 7.0

One upon a time (circa October 2014) in a land far far away (San Francisco, CA) I used to spend all of my spare time working on personal coding projects.  On of my favorite projects was IntelliKiosk.  It's probably the most ambitions side project that I've built to date.  There have been five versions of this monolith (this was back before I was introduced to the beauty of microservices). Although I wouldn't necessarily write code today the way I did back then, it's still one of my favorite projects.  Maybe one day I will completely rebuild it using ReactJs, Node, etc.  But for now it remains as a warm reminder of many sleepliness nights and my obsession with writing code and building intuitive user experiences.

Ok nice intro, but what is it?

Version 7.0 was two big pieces:  A content management system for building and managing multiple websites and an admin application for managing users, error handling, and other fancy administrative stuff.

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

Software Package administration:  Allows admin users to create deployable software packages by bundling together files.  A software package could then be deployed to remote installations of IntelliKiosk.

![Admin1](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin1.png)

Dynamic DB Updates:  Allows admin users to deploy MySQL updates to remote IntelliKiosk installations.

![Admin2](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin2.png)

User Management:  Users can have access to various sites and be members of various teams for security and permission management.

![Admin3](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin3.png)

Code Generator:  This is a feature I created to speed up my development time.  Automatic creation of forms for adding and modifying data in IntelliKiosk apps.

![Admin4](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin4.png)

Access Logs:  Tracking of all access logs and DB queries.

![Admin5](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin5.png)

Site Administration:  Create and manage multiple websites to be managed within the built-in CMS.  Includes social media and Google apps integration as well as photo uplading and thumbnail generation.

![Admin6](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin6.png)

![Admin7](https://github.com/maburdenjr/ikioskv7/blob/master/screenshots/admin7.png)

