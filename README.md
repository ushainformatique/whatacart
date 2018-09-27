Overview
================================

It is an open source ecommerce system developed using YiiChimp framework. YiiChimp is an open source framework written on top of Yii2 framework.
The platform is provided with rich set of features and enable merchants to simply start selling after successful installation. The merchant has to add
product categories, products, enabling payment and shipping methods and can start selling right away.  

REQUIREMENTS
------------

The minimum requirement for this software to run is that your Web server supports PHP 5.5 or greater.


INSTALLATION
------------

### Install from composer

With Composer installed, you can then install the application using the following commands:

**composer create-project ushainformatique/whatacart whatacart**

Once the composer run completes, run http://localhost/whatacart if running on local environment. 

If you are deploying on a domain for example xyz.com, go to public_html folder and run the following command

**composer create-project ushainformatique/whatacart .**

Once the composer run completes, run http://xyz.com.

### Install from zip
 
Download the version zip from http://www.whatacart.com/download and extract it. Place the folder under webroot or public_html if on a domain.

Run http://localhost/whatacart if running on local environment.

If you are deploying on a domain for example xyz.com, go to public_html folder and http://xyz.com.

### NOTE

In case you are getting the following errors 

* No default value is provided for a column
* Error while adding the indexes

Please add the following line to either my.ini or my.cnf based on your configuration.

sql-mode = ""

   OR
   
sql-mode = "NO_ENGINE_SUBSTITUTION"

