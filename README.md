FLiteCMS
========

A boilerplate CMS built on the Codeigniter PHP framework with user and page management.

Installation
------------

Here is a basic rundown for how to get things installed and setup (note - I may be missing a step here, so let me know if you have any issues)

1. Setup your codeigniter installation - I'm assuming you know how to do all this - http://www.codeigniter.com
2. Replace the folders and files in your fresh CI install EXCEPT the /system folder with FLiteCMS code
3. Create a new MySQL database - call it whatever you like
4. Download the sql schema file in the 'downloads' section on this github page, import sql into database
5. EDIT FILE: Open the /application/config/config.php file, add your url to 'base_url', you will want to change the 'encryption_key' to something secure, the included .htaccess file should remove the index.php in the url path so you can leave the 'index_page' setting empty
6. EDIT FILE: Open the /application/config/database.php file, add your database details 
7. Create a /img/upload/images folder in the app root (where application and resources folders live) - this will be used to store any uploaded files 

There may be a few other minor edits needed but you should be able to work through those - let me know if you need any help with that.


Credits
-------

This app takes advantage of the following 3rd party libraries (already included in source):

* Tank Auth authentication package authored by Ilya Konyukhov - https://github.com/ilkon/Tank-Auth
* KCFinder - javascript web file manager by Pavel Tzonkov - http://kcfinder.sunhater.com/
* TinyMCE - javascript WYSIWYG editor - http://www.tinymce.com/
* Google API php client - for accessing analytics data on dashboard - https://code.google.com/p/google-api-php-client/
* Highcharts - javascript chart library for displaying analytics data on dashboard - https://github.com/highslide-software/highcharts.com
* jQuery - duh! - https://github.com/jquery/jquery
* HTML5Boilerplate - fantastic html5 and CSS boilerplate - cause boilerplates save me time - https://github.com/h5bp/html5-boilerplate
* Twitter Bootstrap - styling the admin section - https://github.com/twitter/bootstrap
* jQuery qTip2 - tooltips - https://github.com/Craga89/qTip2
* if I missed any...sorry