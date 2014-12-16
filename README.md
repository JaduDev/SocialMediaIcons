SocialMediaIcons
================

##Social Media Icons Supplement

This supplement will allow a user (in a department for example) to setup their department's social media links and have them all listed together in nicely formatted block that can be placed on a page in any supplement region.

Here's what that looks like 

![alt text](https://github.com/JaduDev/SocialMediaIcons/blob/master/placed_social_media_supplement.png "Social Media Icons Supplement")


##Installation Notes

###_PHP_
There are 3 PHP files that you will need to place on your server.

**Main Class** 

`/jadu/custom/supplements/CustomSocialMediaIcons.php`

**Control Panel**

 `/public_html/jadu/custom/supplements/custom_social_media_icons_include.php`

**Front End**

 `/public_html/site/includes/supplements/custom_social_media_icons.php`


###_IMAGE ICONS_
I've packed up the image icons I've used as well so this can be plug-n-play.

**Image files**

`/public_html/images/blogspot_supp.png`

`/public_html/images/facebook_supp.png`

`/public_html/images/googlepluscolor_supp.png`

`/public_html/images/linkedin_supp.png`

`/public_html/images/twitter2_supp.png`

`/public_html/images/vimeo_supp.png`

`/public_html/images/wordpress_supp.png`

`/public_html/images/youtube_supp.png`

###_SQL_
There are 3 sql files that perform various setup tasks.

Supplement table to save data: `CustomSocialMedia.sql`

Configure Jadu to know where to find class and control panel files : `JaduPageSupplementWidgets.sql`

Configure Jadu to know where to find the front-end script : `JaduPageSupplementPublicCode.sql`


##Notes

I've kept the installation directory structure in tact in the repository so you can determine the default location for these files.
I've also attempted to keep to Jadu's developer coding standards regarding file placement and naming conventions.


##Quick Installation Step 1
Copy the above files to the exact locations.  If you do decide to change the locations, the coordinating SQL paths will have to change as well.  If the images directory is different on your server, you'll have to edit the `custom_social_media_icons.php` so they display.

##Quick Installation Step 2
Run the sql files in this order.  If you've done other supplement development, you may need to change the index numbers in the .sql.

`CustomSocialMedia.sql`

`JaduPageSupplementWidgets.sql`

`JaduPageSupplementPublicCode.sql`


Clear your CMS's cache using casheBash.php or from the file system.

You should now be able to log in and place the new supplement on a page.
