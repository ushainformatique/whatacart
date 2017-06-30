-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: whatacartv2
-- ------------------------------------------------------
-- Server version	5.6.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_address`
--

DROP TABLE IF EXISTS `tbl_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address1` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relatedmodel` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relatedmodel_id` int(11) DEFAULT NULL,
  `type` smallint(1) DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_country` (`country`),
  KEY `idx_postal_code` (`postal_code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_address`
--

LOCK TABLES `tbl_address` WRITE;
/*!40000 ALTER TABLE `tbl_address` DISABLE KEYS */;
INSERT INTO `tbl_address` VALUES (1,'302','9A/1, W.E.A, Karol Bagh','New Delhi','Delhi','IN','110005','Person',1,1,1,1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47'),(2,'302','9A/1, W.E.A, Karol Bagh','New Delhi','Delhi','IN','110005','Person',2,1,1,1,1,'2017-06-21 15:22:52','2017-06-21 15:22:52'),(3,'Billing address','billing address2','Delhi','','IN','110005','Store',1,3,1,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(4,'Shipping address','shipping address2','Delhi','','IN','110005','Store',1,2,1,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(5,'address','address2','Delhi','','IN','110005','Person',3,1,1,1,1,'2017-06-21 15:23:11','2017-06-21 15:23:11'),(6,'address','address2','Delhi','','IN','110005','Person',4,1,1,1,1,'2017-06-21 15:23:21','2017-06-21 15:23:21'),(7,'address','address2','Delhi','','IN','110005','Person',5,1,1,1,1,'2017-06-21 15:23:31','2017-06-21 15:23:31');
/*!40000 ALTER TABLE `tbl_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_auth_assignment`
--

DROP TABLE IF EXISTS `tbl_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_auth_assignment` (
  `identity_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `identity_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `permission` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `resource` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_identity_name` (`identity_name`),
  KEY `idx_identity_type` (`identity_type`),
  KEY `idx_permission` (`permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_auth_assignment`
--

LOCK TABLES `tbl_auth_assignment` WRITE;
/*!40000 ALTER TABLE `tbl_auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_auth_permission`
--

DROP TABLE IF EXISTS `tbl_auth_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_auth_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `resource` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_permission` (`name`,`module`,`resource`,`alias`),
  KEY `idx_name` (`name`),
  KEY `idx_alias` (`alias`),
  KEY `idx_resource` (`resource`),
  KEY `idx_module` (`module`)
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_auth_permission`
--

LOCK TABLES `tbl_auth_permission` WRITE;
/*!40000 ALTER TABLE `tbl_auth_permission` DISABLE KEYS */;
INSERT INTO `tbl_auth_permission` VALUES (1,'access.auth','Access Tab','AuthModule','auth',1,0,'2017-06-21 15:22:47',NULL),(2,'auth.managepermissions','Manage Permissions','AuthModule','auth',1,0,'2017-06-21 15:22:47',NULL),(3,'group.create','Create Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(4,'group.view','View Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(5,'group.viewother','View Others Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(6,'group.update','Update Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(7,'group.updateother','Update Others Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(8,'group.delete','Delete Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(9,'group.deleteother','Delete Others Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(10,'group.manage','Manage Groups','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(11,'group.bulk-edit','Bulk Edit Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(12,'group.bulk-delete','Bulk Delete Group','Group','auth',1,0,'2017-06-21 15:22:47',NULL),(13,'access.home','Access Tab','HomeModule','home',1,0,'2017-06-21 15:22:47',NULL),(14,'access.language','Access Tab','LanguageModule','language',1,0,'2017-06-21 15:22:47',NULL),(15,'language.create','Create Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(16,'language.view','View Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(17,'language.viewother','View Others Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(18,'language.update','Update Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(19,'language.updateother','Update Others Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(20,'language.delete','Delete Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(21,'language.deleteother','Delete Others Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(22,'language.manage','Manage Languages','Language','language',1,0,'2017-06-21 15:22:47',NULL),(23,'language.bulk-edit','Bulk Edit Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(24,'language.bulk-delete','Bulk Delete Language','Language','language',1,0,'2017-06-21 15:22:47',NULL),(25,'access.notification','Access Tab','NotificationModule','notification',1,0,'2017-06-21 15:22:47',NULL),(26,'notification.delete','Delete Notification','Notification','notification',1,0,'2017-06-21 15:22:47',NULL),(27,'notification.manage','Manage Notifications','Notification','notification',1,0,'2017-06-21 15:22:47',NULL),(28,'notificationtemplate.create','Create Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(29,'notificationtemplate.view','View Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(30,'notificationtemplate.viewother','View Others Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(31,'notificationtemplate.update','Update Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(32,'notificationtemplate.updateother','Update Others Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(33,'notificationtemplate.delete','Delete Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(34,'notificationtemplate.deleteother','Delete Others Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(35,'notificationtemplate.manage','Manage Templates','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(36,'notificationtemplate.bulk-edit','Bulk Edit Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(37,'notificationtemplate.bulk-delete','Bulk Delete Template','NotificationTemplate','notification',1,0,'2017-06-21 15:22:47',NULL),(38,'notificationlayout.create','Create Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(39,'notificationlayout.view','View Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(40,'notificationlayout.viewother','View Others Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(41,'notificationlayout.update','Update Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(42,'notificationlayout.updateother','Update Others Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(43,'notificationlayout.delete','Delete Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(44,'notificationlayout.deleteother','Delete Others Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(45,'notificationlayout.manage','Manage Layouts','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(46,'notificationlayout.bulk-edit','Bulk Edit Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(47,'notificationlayout.bulk-delete','Bulk Delete Layout','NotificationLayout','notification',1,0,'2017-06-21 15:22:47',NULL),(48,'access.service','Access Tab','ServiceModule','service',1,0,'2017-06-21 15:22:47',NULL),(49,'service.checksystem','System Configuration','ServiceModule','service',1,0,'2017-06-21 15:22:47',NULL),(50,'service.rebuildpermissions','Rebuild Permissions','ServiceModule','service',1,0,'2017-06-21 15:22:47',NULL),(51,'service.rebuildmodulemetadata','Rebuild module metadata','ServiceModule','service',1,0,'2017-06-21 15:22:47',NULL),(52,'access.settings','Access Tab','SettingsModule','settings',1,0,'2017-06-21 15:22:47',NULL),(53,'settings.email','Email Settings','SettingsModule','settings',1,0,'2017-06-21 15:22:47',NULL),(54,'settings.site','Site Settings','SettingsModule','settings',1,0,'2017-06-21 15:22:47',NULL),(55,'settings.database','Database Settings','SettingsModule','settings',1,0,'2017-06-21 15:22:47',NULL),(56,'access.users','Access Tab','UsersModule','users',1,0,'2017-06-21 15:22:47',NULL),(57,'user.create','Create User','User','users',1,0,'2017-06-21 15:22:47',NULL),(58,'user.view','View User','User','users',1,0,'2017-06-21 15:22:47',NULL),(59,'user.viewother','View Others User','User','users',1,0,'2017-06-21 15:22:47',NULL),(60,'user.update','Update User','User','users',1,0,'2017-06-21 15:22:47',NULL),(61,'user.updateother','Update Others User','User','users',1,0,'2017-06-21 15:22:47',NULL),(62,'user.delete','Delete User','User','users',1,0,'2017-06-21 15:22:47',NULL),(63,'user.deleteother','Delete Others User','User','users',1,0,'2017-06-21 15:22:47',NULL),(64,'user.manage','Manage Users','User','users',1,0,'2017-06-21 15:22:47',NULL),(65,'user.bulk-edit','Bulk Edit User','User','users',1,0,'2017-06-21 15:22:47',NULL),(66,'user.bulk-delete','Bulk Delete User','User','users',1,0,'2017-06-21 15:22:47',NULL),(67,'user.change-password','Change Password','User','users',1,0,'2017-06-21 15:22:47',NULL),(68,'user.change-status','Change Status','User','users',1,0,'2017-06-21 15:22:47',NULL),(69,'user.settings','Settings','User','users',1,0,'2017-06-21 15:22:47',NULL),(70,'user.change-passwordother','Change Others Password','User','users',1,0,'2017-06-21 15:22:47',NULL),(71,'access.catalog','Access Tab','CatalogModule','catalog',1,0,'2017-06-21 15:22:47',NULL),(72,'productcategory.create','Create Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(73,'productcategory.view','View Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(74,'productcategory.viewother','View Others Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(75,'productcategory.update','Update Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(76,'productcategory.updateother','Update Others Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(77,'productcategory.delete','Delete Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(78,'productcategory.deleteother','Delete Others Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(79,'productcategory.manage','Manage Product Categories','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(80,'productcategory.bulk-edit','Bulk Edit Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(81,'productcategory.bulk-delete','Bulk Delete Product Category','ProductCategory','catalog',1,0,'2017-06-21 15:22:47',NULL),(82,'product.create','Create Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(83,'product.view','View Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(84,'product.viewother','View Others Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(85,'product.update','Update Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(86,'product.updateother','Update Others Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(87,'product.delete','Delete Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(88,'product.deleteother','Delete Others Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(89,'product.manage','Manage Products','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(90,'product.bulk-edit','Bulk Edit Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(91,'product.bulk-delete','Bulk Delete Product','Product','catalog',1,0,'2017-06-21 15:22:47',NULL),(92,'productreview.delete','Delete Review','ProductReview','catalog',1,0,'2017-06-21 15:22:47',NULL),(93,'productreview.manage','Manage Reviews','ProductReview','catalog',1,0,'2017-06-21 15:22:47',NULL),(94,'productreview.approve','Approve','ProductReview','catalog',1,0,'2017-06-21 15:22:47',NULL),(95,'productreview.spam','Spam','ProductReview','catalog',1,0,'2017-06-21 15:22:47',NULL),(96,'access.cms','Access Tab','CmsModule','cms',1,0,'2017-06-21 15:22:47',NULL),(97,'page.create','Create Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(98,'page.view','View Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(99,'page.viewother','View Others Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(100,'page.update','Update Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(101,'page.updateother','Update Others Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(102,'page.delete','Delete Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(103,'page.deleteother','Delete Others Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(104,'page.manage','Manage Pages','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(105,'page.bulk-edit','Bulk Edit Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(106,'page.bulk-delete','Bulk Delete Page','Page','cms',1,0,'2017-06-21 15:22:47',NULL),(107,'access.customer','Access Tab','CustomerModule','customer',1,0,'2017-06-21 15:22:47',NULL),(108,'customer.create','Create Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(109,'customer.view','View Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(110,'customer.viewother','View Others Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(111,'customer.update','Update Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(112,'customer.delete','Delete Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(113,'customer.deleteother','Delete Others Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(114,'customer.manage','Manage Customers','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(115,'customer.bulk-edit','Bulk Edit Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(116,'customer.bulk-delete','Bulk Delete Customer','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(117,'customer.change-password','Change Password','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(118,'customer.change-status','Change Status','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(119,'customer.change-passwordother','Change Others Password','Customer','customer',1,0,'2017-06-21 15:22:47',NULL),(120,'access.dataCategories','Access Tab','DataCategoriesModule','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(121,'datacategory.create','Create Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(122,'datacategory.view','View Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(123,'datacategory.viewother','View Others Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(124,'datacategory.update','Update Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(125,'datacategory.updateother','Update Others Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(126,'datacategory.delete','Delete Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(127,'datacategory.deleteother','Delete Others Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(128,'datacategory.manage','Manage Data Categories','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(129,'datacategory.bulk-edit','Bulk Edit Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(130,'datacategory.bulk-delete','Bulk Delete Data Category','DataCategory','dataCategories',1,0,'2017-06-21 15:22:47',NULL),(131,'access.enhancement','Access Tab','EnhancementModule','enhancement',1,0,'2017-06-21 15:22:47',NULL),(132,'access.extension','Access Tab','ExtensionModule','extension',1,0,'2017-06-21 15:22:47',NULL),(133,'extension.update','Update Extension','Extension','extension',1,0,'2017-06-21 15:22:47',NULL),(134,'extension.updateother','Update Others Extension','Extension','extension',1,0,'2017-06-21 15:22:47',NULL),(135,'extension.delete','Delete Extension','Extension','extension',1,0,'2017-06-21 15:22:47',NULL),(136,'extension.deleteother','Delete Others Extension','Extension','extension',1,0,'2017-06-21 15:22:47',NULL),(137,'extension.manage','Manage Extensions','Extension','extension',1,0,'2017-06-21 15:22:47',NULL),(138,'extension.manageother','Manager Others Extension','Extension','extension',1,0,'2017-06-21 15:22:47',NULL),(139,'access.localization','Access Tab','LocalizationModule','localization',1,0,'2017-06-21 15:22:47',NULL),(140,'city.create','Create City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(141,'city.view','View City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(142,'city.viewother','View Others City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(143,'city.update','Update City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(144,'city.updateother','Update Others City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(145,'city.delete','Delete City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(146,'city.deleteother','Delete Others City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(147,'city.manage','Manage Cities','City','localization',1,0,'2017-06-21 15:22:47',NULL),(148,'city.bulk-edit','Bulk Edit City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(149,'city.bulk-delete','Bulk Delete City','City','localization',1,0,'2017-06-21 15:22:47',NULL),(150,'country.create','Create Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(151,'country.view','View Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(152,'country.viewother','View Others Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(153,'country.update','Update Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(154,'country.updateother','Update Others Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(155,'country.delete','Delete Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(156,'country.deleteother','Delete Others Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(157,'country.manage','Manage Countries','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(158,'country.bulk-edit','Bulk Edit Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(159,'country.bulk-delete','Bulk Delete Country','Country','localization',1,0,'2017-06-21 15:22:47',NULL),(160,'currency.create','Create Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(161,'currency.view','View Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(162,'currency.viewother','View Others Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(163,'currency.update','Update Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(164,'currency.updateother','Update Others Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(165,'currency.delete','Delete Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(166,'currency.deleteother','Delete Others Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(167,'currency.manage','Manage Currencies','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(168,'currency.bulk-edit','Bulk Edit Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(169,'currency.bulk-delete','Bulk Delete Currency','Currency','localization',1,0,'2017-06-21 15:22:47',NULL),(170,'state.create','Create State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(171,'state.view','View State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(172,'state.viewother','View Others State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(173,'state.update','Update State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(174,'state.updateother','Update Others State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(175,'state.delete','Delete State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(176,'state.deleteother','Delete Others State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(177,'state.manage','Manage States','State','localization',1,0,'2017-06-21 15:22:47',NULL),(178,'state.bulk-edit','Bulk Edit State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(179,'state.bulk-delete','Bulk Delete State','State','localization',1,0,'2017-06-21 15:22:47',NULL),(180,'lengthclass.create','Create Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(181,'lengthclass.view','View Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(182,'lengthclass.viewother','View Others Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(183,'lengthclass.update','Update Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(184,'lengthclass.updateother','Update Others Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(185,'lengthclass.delete','Delete Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(186,'lengthclass.deleteother','Delete Others Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(187,'lengthclass.manage','Manage Length Classes','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(188,'lengthclass.bulk-edit','Bulk Edit Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(189,'lengthclass.bulk-delete','Bulk Delete Length Class','LengthClass','localization',1,0,'2017-06-21 15:22:47',NULL),(190,'weightclass.create','Create Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(191,'weightclass.view','View Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(192,'weightclass.viewother','View Others Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(193,'weightclass.update','Update Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(194,'weightclass.updateother','Update Others Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(195,'weightclass.delete','Delete Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(196,'weightclass.deleteother','Delete Others Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(197,'weightclass.manage','Manage Weight Classes','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(198,'weightclass.bulk-edit','Bulk Edit Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(199,'weightclass.bulk-delete','Bulk Delete Weight Class','WeightClass','localization',1,0,'2017-06-21 15:22:47',NULL),(200,'stockstatus.create','Create Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(201,'stockstatus.view','View Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(202,'stockstatus.viewother','View Others Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(203,'stockstatus.update','Update Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(204,'stockstatus.updateother','Update Others Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(205,'stockstatus.delete','Delete Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(206,'stockstatus.deleteother','Delete Others Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(207,'stockstatus.manage','Manage Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(208,'stockstatus.bulk-edit','Bulk Edit Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(209,'stockstatus.bulk-delete','Bulk Delete Stock Status','StockStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(210,'orderstatus.create','Create Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(211,'orderstatus.view','View Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(212,'orderstatus.viewother','View Others Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(213,'orderstatus.update','Update Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(214,'orderstatus.updateother','Update Others Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(215,'orderstatus.delete','Delete Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(216,'orderstatus.deleteother','Delete Others Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(217,'orderstatus.manage','Manage Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(218,'orderstatus.bulk-edit','Bulk Edit Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(219,'orderstatus.bulk-delete','Bulk Delete Order Status','OrderStatus','localization',1,0,'2017-06-21 15:22:47',NULL),(220,'producttaxclass.create','Create Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(221,'producttaxclass.view','View Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(222,'producttaxclass.viewother','View Others Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(223,'producttaxclass.update','Update Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(224,'producttaxclass.updateother','Update Others Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(225,'producttaxclass.delete','Delete Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(226,'producttaxclass.deleteother','Delete Others Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(227,'producttaxclass.manage','Manage Product Tax Classes','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(228,'producttaxclass.bulk-edit','Bulk Edit Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(229,'producttaxclass.bulk-delete','Bulk Delete Product Tax Class','ProductTaxClass','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(230,'taxrule.create','Create Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(231,'taxrule.view','View Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(232,'taxrule.viewother','View Others Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(233,'taxrule.update','Update Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(234,'taxrule.updateother','Update Others Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(235,'taxrule.delete','Delete Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(236,'taxrule.deleteother','Delete Others Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(237,'taxrule.manage','Manage Tax Rules','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(238,'taxrule.bulk-edit','Bulk Edit Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(239,'taxrule.bulk-delete','Bulk Delete Tax Rule','TaxRule','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(240,'zone.create','Create Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(241,'zone.view','View Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(242,'zone.viewother','View Others Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(243,'zone.update','Update Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(244,'zone.updateother','Update Others Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(245,'zone.delete','Delete Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(246,'zone.deleteother','Delete Others Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(247,'zone.manage','Manage Zones','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(248,'zone.bulk-edit','Bulk Edit Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(249,'zone.bulk-delete','Bulk Delete Zone','Zone','localization/tax',1,0,'2017-06-21 15:22:47',NULL),(250,'access.manufacturer','Access Tab','ManufacturerModule','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(251,'manufacturer.create','Create Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(252,'manufacturer.view','View Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(253,'manufacturer.viewother','View Others Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(254,'manufacturer.update','Update Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(255,'manufacturer.updateother','Update Others Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(256,'manufacturer.delete','Delete Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(257,'manufacturer.deleteother','Delete Others Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(258,'manufacturer.manage','Manage Manufacturers','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(259,'manufacturer.bulk-edit','Bulk Edit Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(260,'manufacturer.bulk-delete','Bulk Delete Manufacturer','Manufacturer','manufacturer',1,0,'2017-06-21 15:22:47',NULL),(261,'access.marketing','Access Tab','MarketingModule','marketing',1,0,'2017-06-21 15:22:47',NULL),(262,'marketing.mail','Marketing Mails','MarketingModule','marketing',1,0,'2017-06-21 15:22:47',NULL),(263,'newsletter.create','Create Newsletter','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(264,'newsletter.view','View Newsletter','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(265,'newsletter.viewother','View Others Newsletter','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(266,'newsletter.update','Update Newsletter','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(267,'newsletter.updateother','Update Others Newsletter','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(268,'newsletter.delete','Delete Newsletter','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(269,'newsletter.deleteother','Delete Others Newsletter','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(270,'newsletter.manage','Manage Newsletters','Newsletter','marketing/newsletter',1,0,'2017-06-21 15:22:47',NULL),(271,'access.order','Access Tab','OrderModule','order',1,0,'2017-06-21 15:22:47',NULL),(272,'order.create','Create Order','Order','order',1,0,'2017-06-21 15:22:47',NULL),(273,'order.view','View Order','Order','order',1,0,'2017-06-21 15:22:47',NULL),(274,'order.viewother','View Others Order','Order','order',1,0,'2017-06-21 15:22:47',NULL),(275,'order.update','Update Order','Order','order',1,0,'2017-06-21 15:22:47',NULL),(276,'order.updateother','Update Others Order','Order','order',1,0,'2017-06-21 15:22:47',NULL),(277,'order.delete','Delete Order','Order','order',1,0,'2017-06-21 15:22:47',NULL),(278,'order.deleteother','Delete Others Order','Order','order',1,0,'2017-06-21 15:22:47',NULL),(279,'order.manage','Manage Orders','Order','order',1,0,'2017-06-21 15:22:47',NULL),(280,'access.payment','Access Tab','PaymentModule','payment',1,0,'2017-06-21 15:22:47',NULL),(281,'access.shipping','Access Tab','ShippingModule','shipping',1,0,'2017-06-21 15:22:47',NULL),(282,'access.stores','Access Tab','StoresModule','stores',1,0,'2017-06-21 15:22:47',NULL),(283,'store.create','Create Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(284,'store.view','View Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(285,'store.viewother','View Others Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(286,'store.update','Update Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(287,'store.updateother','Update Others Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(288,'store.delete','Delete Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(289,'store.deleteother','Delete Others Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(290,'store.manage','Manage Stores','Store','stores',1,0,'2017-06-21 15:22:47',NULL),(291,'store.bulk-edit','Bulk Edit Store','Store','stores',1,0,'2017-06-21 15:22:47',NULL);
/*!40000 ALTER TABLE `tbl_auth_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_city`
--

DROP TABLE IF EXISTS `tbl_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_country_id` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_city`
--

LOCK TABLES `tbl_city` WRITE;
/*!40000 ALTER TABLE `tbl_city` DISABLE KEYS */;
INSERT INTO `tbl_city` VALUES (1,1,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,1,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,1,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,1,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_city_translated`
--

DROP TABLE IF EXISTS `tbl_city_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_city_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_city_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_city_translated`
--

LOCK TABLES `tbl_city_translated` WRITE;
/*!40000 ALTER TABLE `tbl_city_translated` DISABLE KEYS */;
INSERT INTO `tbl_city_translated` VALUES (1,1,'en-US','New Delhi',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,2,'en-US','Panaji',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,3,'en-US','Dispur',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,4,'en-US','Imphal',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_city_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_configuration`
--

DROP TABLE IF EXISTS `tbl_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_module` (`module`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_configuration`
--

LOCK TABLES `tbl_configuration` WRITE;
/*!40000 ALTER TABLE `tbl_configuration` DISABLE KEYS */;
INSERT INTO `tbl_configuration` VALUES (1,'application','dbAdminUsername','',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(2,'application','dbAdminPassword','',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(3,'application','siteName','Default site',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(4,'application','siteDescription','This is default site description',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(5,'application','superUsername','super',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(6,'application','superEmail','abc@y.com',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(7,'application','superPassword','admin',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(8,'application','dbHost','localhost',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(9,'application','dbPort','3306',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(10,'application','dbName','whatacartv2',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(11,'application','dbUsername','usnicart',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(12,'application','dbPassword','abc123',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(13,'application','environment','dev',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(14,'application','demoData','1',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(15,'application','timezone','Asia/Kolkata',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(16,'application','logo','',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(17,'application','uploadInstance',NULL,1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(18,'application','enableSchemaCache','1',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(19,'application','schemaCachingDuration','3600',1,1,'2017-06-21 15:22:44','2017-06-21 15:22:44'),(20,'application','appRebuild','',1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47'),(21,'users','passwordTokenExpiry','3600',1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47');
/*!40000 ALTER TABLE `tbl_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_country`
--

DROP TABLE IF EXISTS `tbl_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode_required` smallint(1) DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `iso_code_2` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_code_3` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_country`
--

LOCK TABLES `tbl_country` WRITE;
/*!40000 ALTER TABLE `tbl_country` DISABLE KEYS */;
INSERT INTO `tbl_country` VALUES (1,0,1,'IN','IND',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_country_translated`
--

DROP TABLE IF EXISTS `tbl_country_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_country_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `address_format` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_country_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_country_translated`
--

LOCK TABLES `tbl_country_translated` WRITE;
/*!40000 ALTER TABLE `tbl_country_translated` DISABLE KEYS */;
INSERT INTO `tbl_country_translated` VALUES (1,1,'en-US','India','',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_country_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_currency`
--

DROP TABLE IF EXISTS `tbl_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(1) DEFAULT NULL,
  `value` decimal(10,2) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_left` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol_right` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decimal_place` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_symbol_left` (`symbol_left`),
  KEY `idx_code` (`code`),
  KEY `idx_symbol_right` (`symbol_right`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_currency`
--

LOCK TABLES `tbl_currency` WRITE;
/*!40000 ALTER TABLE `tbl_currency` DISABLE KEYS */;
INSERT INTO `tbl_currency` VALUES (1,1,1.00,'USD','$','','2',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,1,0.58,'GBP','£','','2',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_currency_translated`
--

DROP TABLE IF EXISTS `tbl_currency_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_currency_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_currency_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_currency_translated`
--

LOCK TABLES `tbl_currency_translated` WRITE;
/*!40000 ALTER TABLE `tbl_currency_translated` DISABLE KEYS */;
INSERT INTO `tbl_currency_translated` VALUES (1,1,'en-US','US Dollars',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,2,'en-US','Pound Sterling',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_currency_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `unique_id` int(11) NOT NULL,
  `password_reset_token` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `login_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `timezone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer`
--

LOCK TABLES `tbl_customer` WRITE;
/*!40000 ALTER TABLE `tbl_customer` DISABLE KEYS */;
INSERT INTO `tbl_customer` VALUES (1,'wholesalecustomer',10000,NULL,'$2y$13$YnrZVD6pUFwdWAWHo5aG9OtmRDR2tyZhBu.OdsB/SAvT533JG7wqq','CheeRSwfN3ci_aOsZqPbHAZOqQAstsW2',1,3,NULL,NULL,'Asia/Kolkata',1,1,'2017-06-21 15:23:11','2017-06-21 15:23:11'),(2,'retailcustomer',10001,NULL,'$2y$13$82qYj6WMcyyWoW3PVMI0IOC0Gg9MAiZa/terJ/W6yu5a3lEsaiX0e','P6EhYpsDHjYEhlVeM1xW6kgTyKezt6h2',1,4,NULL,NULL,'Asia/Kolkata',1,1,'2017-06-21 15:23:21','2017-06-21 15:23:21'),(3,'defaultcustomer',10002,NULL,'$2y$13$RKtmfKu81Yd3cR5ZPaZnWOPZBcQOXv6QXIuODG92hhoslvlV3cRRG','LWjABcy11HMMact_uZOfodj2vPTcPF5D',1,5,NULL,NULL,'Asia/Kolkata',1,1,'2017-06-21 15:23:31','2017-06-21 15:23:31');
/*!40000 ALTER TABLE `tbl_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_activity`
--

DROP TABLE IF EXISTS `tbl_customer_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_activity`
--

LOCK TABLES `tbl_customer_activity` WRITE;
/*!40000 ALTER TABLE `tbl_customer_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_download_mapping`
--

DROP TABLE IF EXISTS `tbl_customer_download_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_download_mapping` (
  `customer_id` int(11) DEFAULT NULL,
  `download_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_download_id` (`download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_download_mapping`
--

LOCK TABLES `tbl_customer_download_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_customer_download_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_download_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_metadata`
--

DROP TABLE IF EXISTS `tbl_customer_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `cart` text COLLATE utf8_unicode_ci,
  `wishlist` text COLLATE utf8_unicode_ci,
  `compareproducts` text COLLATE utf8_unicode_ci,
  `currency` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_currency` (`currency`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_metadata`
--

LOCK TABLES `tbl_customer_metadata` WRITE;
/*!40000 ALTER TABLE `tbl_customer_metadata` DISABLE KEYS */;
INSERT INTO `tbl_customer_metadata` VALUES (1,1,'a:0:{}','a:0:{}','a:0:{}',NULL,NULL,1,1,'2017-06-21 15:23:11','2017-06-21 15:23:11'),(2,2,'a:0:{}','a:0:{}','a:0:{}',NULL,NULL,1,1,'2017-06-21 15:23:21','2017-06-21 15:23:21'),(3,3,'a:0:{}','a:0:{}','a:0:{}',NULL,NULL,1,1,'2017-06-21 15:23:31','2017-06-21 15:23:31');
/*!40000 ALTER TABLE `tbl_customer_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_online`
--

DROP TABLE IF EXISTS `tbl_customer_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `url` varchar(164) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referer` varchar(164) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`),
  KEY `idx_customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_online`
--

LOCK TABLES `tbl_customer_online` WRITE;
/*!40000 ALTER TABLE `tbl_customer_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_data_category`
--

DROP TABLE IF EXISTS `tbl_data_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_data_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(1) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_data_category`
--

LOCK TABLES `tbl_data_category` WRITE;
/*!40000 ALTER TABLE `tbl_data_category` DISABLE KEYS */;
INSERT INTO `tbl_data_category` VALUES (1,1,1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50');
/*!40000 ALTER TABLE `tbl_data_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_data_category_translated`
--

DROP TABLE IF EXISTS `tbl_data_category_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_data_category_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_data_category_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_data_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_data_category_translated`
--

LOCK TABLES `tbl_data_category_translated` WRITE;
/*!40000 ALTER TABLE `tbl_data_category_translated` DISABLE KEYS */;
INSERT INTO `tbl_data_category_translated` VALUES (1,1,'en-US','Root Category','This is root data category for the application under which all the data would reside',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50');
/*!40000 ALTER TABLE `tbl_data_category_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_extension`
--

DROP TABLE IF EXISTS `tbl_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_extension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_version` text COLLATE utf8_unicode_ci,
  `status` smallint(1) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_code` (`code`),
  KEY `idx_status` (`status`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_extension`
--

LOCK TABLES `tbl_extension` WRITE;
/*!40000 ALTER TABLE `tbl_extension` DISABLE KEYS */;
INSERT INTO `tbl_extension` VALUES (1,'payment','WhatACart','1.0','2.0.0',0,'cashondelivery',NULL,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(2,'payment','WhatACart','1.0','2.0.0',0,'paypal_standard',NULL,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(3,'shipping','WhatACart','1.0','2.0.0',0,'flat',NULL,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(4,'shipping','WhatACart','1.0','2.0.0',0,'free',NULL,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04');
/*!40000 ALTER TABLE `tbl_extension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_extension_translated`
--

DROP TABLE IF EXISTS `tbl_extension_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_extension_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_extension_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_extension` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_extension_translated`
--

LOCK TABLES `tbl_extension_translated` WRITE;
/*!40000 ALTER TABLE `tbl_extension_translated` DISABLE KEYS */;
INSERT INTO `tbl_extension_translated` VALUES (1,1,'en-US','Cash On Delivery',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(2,2,'en-US','Paypal Standard',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(3,3,'en-US','Flat Rate',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(4,4,'en-US','Free Shipping',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04');
/*!40000 ALTER TABLE `tbl_extension_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_group`
--

DROP TABLE IF EXISTS `tbl_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `category` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'system',
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_level` (`level`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group`
--

LOCK TABLES `tbl_group` WRITE;
/*!40000 ALTER TABLE `tbl_group` DISABLE KEYS */;
INSERT INTO `tbl_group` VALUES (1,'Administrators',0,0,1,'system','1',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,'General',0,0,1,'customer','2',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,'Wholesale',0,0,1,'customer','3',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,'Retailer',0,0,1,'customer','4',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_group_member`
--

DROP TABLE IF EXISTS `tbl_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_group_member` (
  `group_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  UNIQUE KEY `idx_group_member` (`group_id`,`member_id`,`member_type`),
  KEY `idx_member_type` (`member_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group_member`
--

LOCK TABLES `tbl_group_member` WRITE;
/*!40000 ALTER TABLE `tbl_group_member` DISABLE KEYS */;
INSERT INTO `tbl_group_member` VALUES (1,2,'user',1,1,'2017-06-21 15:22:52','2017-06-21 15:22:52'),(2,3,'customer',1,1,'2017-06-21 15:23:31','2017-06-21 15:23:31'),(3,1,'customer',1,1,'2017-06-21 15:23:11','2017-06-21 15:23:11'),(4,2,'customer',1,1,'2017-06-21 15:23:21','2017-06-21 15:23:21');
/*!40000 ALTER TABLE `tbl_group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_invoice`
--

DROP TABLE IF EXISTS `tbl_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` int(16) NOT NULL,
  `order_id` int(11) NOT NULL,
  `price_excluding_tax` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL,
  `total_items` int(11) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_unique_id` (`unique_id`),
  CONSTRAINT `fk_tbl_invoice_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_invoice`
--

LOCK TABLES `tbl_invoice` WRITE;
/*!40000 ALTER TABLE `tbl_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_invoice_translated`
--

DROP TABLE IF EXISTS `tbl_invoice_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_invoice_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `terms` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_invoice_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_invoice_translated`
--

LOCK TABLES `tbl_invoice_translated` WRITE;
/*!40000 ALTER TABLE `tbl_invoice_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_invoice_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_language`
--

DROP TABLE IF EXISTS `tbl_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_locale` (`locale`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_language`
--

LOCK TABLES `tbl_language` WRITE;
/*!40000 ALTER TABLE `tbl_language` DISABLE KEYS */;
INSERT INTO `tbl_language` VALUES (1,'English','en-US','',1,1,'en-US',1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47');
/*!40000 ALTER TABLE `tbl_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_length_class`
--

DROP TABLE IF EXISTS `tbl_length_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_length_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unit` (`unit`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_length_class`
--

LOCK TABLES `tbl_length_class` WRITE;
/*!40000 ALTER TABLE `tbl_length_class` DISABLE KEYS */;
INSERT INTO `tbl_length_class` VALUES (1,'m',1.00,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,'cm',100.00,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,'in',39.37,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,'mm',1000.00,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_length_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_length_class_translated`
--

DROP TABLE IF EXISTS `tbl_length_class_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_length_class_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_length_class_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_length_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_length_class_translated`
--

LOCK TABLES `tbl_length_class_translated` WRITE;
/*!40000 ALTER TABLE `tbl_length_class_translated` DISABLE KEYS */;
INSERT INTO `tbl_length_class_translated` VALUES (1,1,'en-US','Meter',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,2,'en-US','Centimeter',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,3,'en-US','Inch',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,4,'en-US','Millimeter',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_length_class_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_manufacturer`
--

DROP TABLE IF EXISTS `tbl_manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_manufacturer`
--

LOCK TABLES `tbl_manufacturer` WRITE;
/*!40000 ALTER TABLE `tbl_manufacturer` DISABLE KEYS */;
INSERT INTO `tbl_manufacturer` VALUES (1,'Apple',NULL,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,'Canon',NULL,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(3,'HTC',NULL,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(4,'Sony',NULL,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_manufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_newsletter`
--

DROP TABLE IF EXISTS `tbl_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `subject` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_store_id` (`store_id`),
  KEY `idx_to` (`to`),
  KEY `idx_subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_newsletter`
--

LOCK TABLES `tbl_newsletter` WRITE;
/*!40000 ALTER TABLE `tbl_newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_newsletter_customers`
--

DROP TABLE IF EXISTS `tbl_newsletter_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_newsletter_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `email` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_newsletter_customers`
--

LOCK TABLES `tbl_newsletter_customers` WRITE;
/*!40000 ALTER TABLE `tbl_newsletter_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_newsletter_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_newsletter_translated`
--

DROP TABLE IF EXISTS `tbl_newsletter_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_newsletter_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_newsletter_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_newsletter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_newsletter_translated`
--

LOCK TABLES `tbl_newsletter_translated` WRITE;
/*!40000 ALTER TABLE `tbl_newsletter_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_newsletter_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_notification`
--

DROP TABLE IF EXISTS `tbl_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulename` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1',
  `priority` smallint(1) NOT NULL DEFAULT '1',
  `senddatetime` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_modulename` (`modulename`),
  KEY `idx_type` (`type`),
  KEY `idx_status` (`status`),
  KEY `idx_priority` (`priority`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification`
--

LOCK TABLES `tbl_notification` WRITE;
/*!40000 ALTER TABLE `tbl_notification` DISABLE KEYS */;
INSERT INTO `tbl_notification` VALUES (1,'users','email','a:5:{s:8:\"fromName\";s:11:\"Super Admin\";s:11:\"fromAddress\";s:9:\"abc@y.com\";s:9:\"toAddress\";s:22:\"mayank@mayankstore.com\";s:7:\"subject\";s:32:\"My Application | Default Subject\";s:4:\"body\";s:282:\"<table><tr><td>fullName</td><td>Store Owner</td></tr><tr><td>username</td><td>storeowner</td></tr><tr><td>password</td><td>abcd123!@#</td></tr><tr><td>appname</td><td>My Application</td></tr><tr><td>confirmemail</td><td></td></tr><tr><td>confirmemailLabel</td><td></td></tr></table>\";}',1,1,'2017-06-21 15:23:04',1,0,'2017-06-21 15:23:04',NULL),(2,'customer','email','a:5:{s:8:\"fromName\";s:11:\"Super Admin\";s:11:\"fromAddress\";s:9:\"abc@y.com\";s:9:\"toAddress\";s:31:\"wholesalecustomer@whatacart.com\";s:7:\"subject\";s:32:\"My Application | Default Subject\";s:4:\"body\";s:315:\"<table><tr><td>fullName</td><td>Wholesalecustomer wholesalecustomerlast</td></tr><tr><td>username</td><td>wholesalecustomer</td></tr><tr><td>password</td><td>wc123!@#</td></tr><tr><td>appname</td><td>My Application</td></tr><tr><td>confirmemail</td><td></td></tr><tr><td>confirmemailLabel</td><td></td></tr></table>\";}',1,1,'2017-06-21 15:23:20',1,0,'2017-06-21 15:23:20',NULL),(3,'customer','email','a:5:{s:8:\"fromName\";s:11:\"Super Admin\";s:11:\"fromAddress\";s:9:\"abc@y.com\";s:9:\"toAddress\";s:28:\"retailcustomer@whatacart.com\";s:7:\"subject\";s:32:\"My Application | Default Subject\";s:4:\"body\";s:306:\"<table><tr><td>fullName</td><td>Retailcustomer retailcustomerlast</td></tr><tr><td>username</td><td>retailcustomer</td></tr><tr><td>password</td><td>rc123!@#</td></tr><tr><td>appname</td><td>My Application</td></tr><tr><td>confirmemail</td><td></td></tr><tr><td>confirmemailLabel</td><td></td></tr></table>\";}',1,1,'2017-06-21 15:23:30',1,0,'2017-06-21 15:23:30',NULL),(4,'customer','email','a:5:{s:8:\"fromName\";s:11:\"Super Admin\";s:11:\"fromAddress\";s:9:\"abc@y.com\";s:9:\"toAddress\";s:29:\"defaultcustomer@whatacart.com\";s:7:\"subject\";s:32:\"My Application | Default Subject\";s:4:\"body\";s:309:\"<table><tr><td>fullName</td><td>Defaultcustomer defaultcustomerlast</td></tr><tr><td>username</td><td>defaultcustomer</td></tr><tr><td>password</td><td>dc123!@#</td></tr><tr><td>appname</td><td>My Application</td></tr><tr><td>confirmemail</td><td></td></tr><tr><td>confirmemailLabel</td><td></td></tr></table>\";}',1,1,'2017-06-21 15:23:40',1,0,'2017-06-21 15:23:40',NULL);
/*!40000 ALTER TABLE `tbl_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_notification_layout`
--

DROP TABLE IF EXISTS `tbl_notification_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_notification_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification_layout`
--

LOCK TABLES `tbl_notification_layout` WRITE;
/*!40000 ALTER TABLE `tbl_notification_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_notification_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_notification_layout_translated`
--

DROP TABLE IF EXISTS `tbl_notification_layout_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_notification_layout_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` blob NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_notification_layout_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_notification_layout` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification_layout_translated`
--

LOCK TABLES `tbl_notification_layout_translated` WRITE;
/*!40000 ALTER TABLE `tbl_notification_layout_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_notification_layout_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_notification_template`
--

DROP TABLE IF EXISTS `tbl_notification_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_notification_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `notifykey` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `layout_id` int(11) DEFAULT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_notifykey` (`notifykey`),
  KEY `idx_type` (`type`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification_template`
--

LOCK TABLES `tbl_notification_template` WRITE;
/*!40000 ALTER TABLE `tbl_notification_template` DISABLE KEYS */;
INSERT INTO `tbl_notification_template` VALUES (1,'email','createUser',NULL,1,1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47'),(2,'email','changepassword',NULL,1,1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47'),(3,'email','forgotpassword',NULL,1,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,'email','productReview',NULL,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(5,'email','orderCompletion',NULL,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(6,'email','orderReceived',NULL,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(7,'email','orderUpdate',NULL,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(8,'email','sendMail',NULL,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(9,'email','sendNewsletter',NULL,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(10,'email','createCustomer',NULL,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10');
/*!40000 ALTER TABLE `tbl_notification_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_notification_template_translated`
--

DROP TABLE IF EXISTS `tbl_notification_template_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_notification_template_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` blob NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_subject` (`subject`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_notification_template_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_notification_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification_template_translated`
--

LOCK TABLES `tbl_notification_template_translated` WRITE;
/*!40000 ALTER TABLE `tbl_notification_template_translated` DISABLE KEYS */;
INSERT INTO `tbl_notification_template_translated` VALUES (1,1,'en-US','New User Registration','<p>Welcome {{fullName}}. Your account has been created successfully at {{appname}}</p>\r\n\r\n<p>Your login details are as below<br /><br/>\r\n    <strong>Username:</strong> {{username}}<br />\r\n    <strong>Password</strong>: {{password}}</p>\r\n\r\n{{confirmemailLabel}}\r\n{{confirmemail}}\r\n\r\nThanks,<br />\r\nSystem Admin',1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47'),(2,2,'en-US','You have changed your password','<p>Dear {{fullName}}, <br/><br/>Your password has been changed to {{password}}.\r\n<br/><br/>\r\nThanks<br/>\r\nSystem Admin</p>',1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47'),(3,3,'en-US','Forgot Password Request','<p>Dear {{fullName}},<br/>\r\nYour login details are as below<br>\r\n<strong>Username:</strong> {{username}}<br>\r\n<strong>Password</strong>: {{password}}\r\n<br/><br/>\r\nThanks<br>\r\nSystem Admin\r\n</p>',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,4,'en-US','Product Review | {{productName}}','<p>\r\n    Hello,<br/>\r\n    {{customername}} has posted a new review on {{productname}}.\r\n</p>\r\n<p>\r\n    The review is:<br/>\r\n    {{review}}<br/><br/>\r\n    Thanks,<br />\r\n    System Admin\r\n</p>',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(5,5,'en-US','Order Completion','<p>Dear, {{customername}}</p>\r\n<p>\r\n    Your order #{{ordernumber}} processing is completed on {{orderdate}}.\r\n</p>\r\n{{orderLink}}\r\n<p>\r\n    Thank You, <br/> \r\n    System Admin\r\n</p>',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(6,6,'en-US','Received Order','<div style=\"width: 680px;\">\r\n  <p style=\"margin-top: 0px; margin-bottom: 20px;\">Thank you for your interest in {{storeName}} products. Your order has been received and will be processed once payment has been confirmed.</p>\r\n  {{orderLink}}\r\n  <table style=\"border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;\">\r\n    <thead>\r\n      <tr>\r\n        <td style=\"font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;\" colspan=\"2\">\r\n            Order Details\r\n        </td>\r\n      </tr>\r\n    </thead>\r\n    <tbody>\r\n      <tr>\r\n        <td style=\"font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;\">\r\n          <b>Order ID:</b> {{orderId}}<br />\r\n          <b>Date of Order:</b> {{dateAdded}}<br />\r\n          <b>Payment Method:</b> {{paymentMethod}}<br />\r\n          {{shippingMethod}}\r\n          </td>\r\n        <td style=\"font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;\">\r\n          <b>Email:</b> {{email}}<br />\r\n          <b>Telephone:</b> {{telephone}}<br />\r\n          <b>Status:</b> {{orderStatus}}<br />\r\n        </td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n  <table style=\"border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;\">\r\n    <thead>\r\n      <tr>\r\n        <td style=\"font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;\">\r\n            Billing Address\r\n        </td>\r\n        {{shippingAddressTitle}}\r\n      </tr>\r\n    </thead>\r\n    <tbody>\r\n      <tr>\r\n        <td style=\"font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;\">\r\n            {{paymentAddress}}\r\n        </td>\r\n        {{shippingAddress}}\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n  {{orderProducts}}\r\n  <p style=\"margin-top: 0px; margin-bottom: 20px;\">Please reply to support@whatacart.com if you have any questions.</p>\r\n  <p>\r\n      Thanks,<br/>\r\n      System Admin\r\n  </p>\r\n</div>',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(7,7,'en-US','Update Order | {{ordernumber}}','<p>Dear {{customername}},</p>\r\n<p>\r\n    Your order #{{ordernumber}} status ordered on {{orderdate}} has been updated to {{orderstatus}}.\r\n</p>\r\n{{orderLink}}\r\n<p>\r\n    The comments for the order are:<br/>\r\n    {{ordercomments}}\r\n</p>\r\n<p>\r\n    Thank You, <br/> \r\n    System Admin\r\n</p>',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(8,8,'en-US','Send Mail','<h1>{{appname}}</h1>\r\n<p>\r\n    <strong>From:</strong> {{storename}}<br />\r\n    <strong>Subject:</strong>: {{subject}}<br />\r\n    <strong>Message:</strong>: {{message}}\r\n</p>',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(9,9,'en-US','Newsletter','<h1>{{appname}}</h1>\r\n<p>\r\n    <strong>From:</strong> {{storename}}<br />\r\n    <strong>Subject:</strong>: {{subject}}<br />\r\n    <strong>Message:</strong>: {{message}}\r\n</p>\r\n{{unsubscribe}}',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(10,10,'en-US','New Customer Registration','<p>Welcome {{fullName}}. Your account has been created successfully at {{appname}}</p>\r\n\r\n<p>Your login details are as below<br /><br/>\r\n    <strong>Username:</strong> {{username}}<br />\r\n    <strong>Password</strong>: {{password}}</p>\r\n\r\n{{confirmemailLabel}}\r\n{{confirmemail}}\r\n\r\nThanks,<br />\r\nSystem Admin\r\n\r\n',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10');
/*!40000 ALTER TABLE `tbl_notification_template_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order`
--

DROP TABLE IF EXISTS `tbl_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `shipping` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT '0.00',
  `unique_id` int(11) NOT NULL,
  `currency_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `currency_conversion_value` float NOT NULL DEFAULT '1',
  `interface` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_store_id` (`store_id`),
  KEY `idx_status` (`status`),
  KEY `idx_unique_id` (`unique_id`),
  KEY `idx_currency_code` (`currency_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order`
--

LOCK TABLES `tbl_order` WRITE;
/*!40000 ALTER TABLE `tbl_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_address_details`
--

DROP TABLE IF EXISTS `tbl_order_address_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_address_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobilephone` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `officephone` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address1` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_firstname` (`firstname`),
  KEY `idx_lastname` (`lastname`),
  KEY `idx_city` (`city`),
  KEY `idx_country` (`country`),
  KEY `idx_postal_code` (`postal_code`),
  CONSTRAINT `fk_tbl_order_address_details_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_address_details`
--

LOCK TABLES `tbl_order_address_details` WRITE;
/*!40000 ALTER TABLE `tbl_order_address_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_address_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_history`
--

DROP TABLE IF EXISTS `tbl_order_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `notify_customer` smallint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_tbl_order_history_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_history`
--

LOCK TABLES `tbl_order_history` WRITE;
/*!40000 ALTER TABLE `tbl_order_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_history_translated`
--

DROP TABLE IF EXISTS `tbl_order_history_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_history_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_order_history_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_history_translated`
--

LOCK TABLES `tbl_order_history_translated` WRITE;
/*!40000 ALTER TABLE `tbl_order_history_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_history_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_payment_details`
--

DROP TABLE IF EXISTS `tbl_order_payment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `payment_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_including_tax` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_payment_method` (`payment_method`),
  KEY `idx_payment_type` (`payment_type`),
  KEY `idx_total_including_tax` (`total_including_tax`),
  KEY `idx_tax` (`tax`),
  KEY `idx_shipping_fee` (`shipping_fee`),
  CONSTRAINT `fk_tbl_order_payment_details_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_payment_details`
--

LOCK TABLES `tbl_order_payment_details` WRITE;
/*!40000 ALTER TABLE `tbl_order_payment_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_payment_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_payment_details_translated`
--

DROP TABLE IF EXISTS `tbl_order_payment_details_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_payment_details_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_order_payment_details_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order_payment_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_payment_details_translated`
--

LOCK TABLES `tbl_order_payment_details_translated` WRITE;
/*!40000 ALTER TABLE `tbl_order_payment_details_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_payment_details_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_payment_transaction_map`
--

DROP TABLE IF EXISTS `tbl_order_payment_transaction_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_payment_transaction_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_record_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_amount` (`amount`),
  KEY `idx_payment_method` (`payment_method`),
  KEY `idx_transaction_record_id` (`transaction_record_id`),
  CONSTRAINT `fk_tbl_order_payment_transaction_map_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_payment_transaction_map`
--

LOCK TABLES `tbl_order_payment_transaction_map` WRITE;
/*!40000 ALTER TABLE `tbl_order_payment_transaction_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_payment_transaction_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_product`
--

DROP TABLE IF EXISTS `tbl_order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `options` text COLLATE utf8_unicode_ci,
  `displayed_options` text COLLATE utf8_unicode_ci,
  `item_code` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `options_price` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) DEFAULT '0.00',
  `tax` decimal(10,2) DEFAULT '0.00',
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `fk_tbl_order_product_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_product`
--

LOCK TABLES `tbl_order_product` WRITE;
/*!40000 ALTER TABLE `tbl_order_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_status`
--

DROP TABLE IF EXISTS `tbl_order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_status`
--

LOCK TABLES `tbl_order_status` WRITE;
/*!40000 ALTER TABLE `tbl_order_status` DISABLE KEYS */;
INSERT INTO `tbl_order_status` VALUES (1,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(5,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(6,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(7,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(8,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(9,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(10,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(11,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(12,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(13,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(14,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_status_translated`
--

DROP TABLE IF EXISTS `tbl_order_status_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_status_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_order_status_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_status_translated`
--

LOCK TABLES `tbl_order_status_translated` WRITE;
/*!40000 ALTER TABLE `tbl_order_status_translated` DISABLE KEYS */;
INSERT INTO `tbl_order_status_translated` VALUES (1,1,'en-US','Cancelled',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,2,'en-US','Canceled_Reversal',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,3,'en-US','Chargeback',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,4,'en-US','Completed',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(5,5,'en-US','Denied',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(6,6,'en-US','Expired',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(7,7,'en-US','Failed',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(8,8,'en-US','Pending',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(9,9,'en-US','Processed',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(10,10,'en-US','Processing',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(11,11,'en-US','Refunded',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(12,12,'en-US','Reversed',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(13,13,'en-US','Shipped',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(14,14,'en-US','Voided',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_order_status_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_translated`
--

DROP TABLE IF EXISTS `tbl_order_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_comments` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_order_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_translated`
--

LOCK TABLES `tbl_order_translated` WRITE;
/*!40000 ALTER TABLE `tbl_order_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_page`
--

DROP TABLE IF EXISTS `tbl_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(1) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `custom_url` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` smallint(1) NOT NULL,
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_page`
--

LOCK TABLES `tbl_page` WRITE;
/*!40000 ALTER TABLE `tbl_page` DISABLE KEYS */;
INSERT INTO `tbl_page` VALUES (1,1,0,NULL,0,'1',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,1,0,NULL,0,'2',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50'),(3,1,0,NULL,0,'3',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50'),(4,1,0,NULL,0,'4',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50');
/*!40000 ALTER TABLE `tbl_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_page_translated`
--

DROP TABLE IF EXISTS `tbl_page_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_page_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `menuitem` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `summary` text COLLATE utf8_unicode_ci,
  `metakeywords` text COLLATE utf8_unicode_ci,
  `metadescription` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_alias` (`alias`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_page_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_page_translated`
--

LOCK TABLES `tbl_page_translated` WRITE;
/*!40000 ALTER TABLE `tbl_page_translated` DISABLE KEYS */;
INSERT INTO `tbl_page_translated` VALUES (1,1,'en-US','About Us','about-us','About Us','<p>\r\n    <strong class=\"first-paragraph\">A</strong>t Usha Informatique, Web Development Company in India, we are driven by SPEED and EFFICIENCY to achieve superior quality and cost-competitiveness so as to enable our customer&rsquo;s stay at the forefront of their industry.</p><p>At Usha Informatique, you can find a right combination of Technical excellence, outstanding design, effective strategy and the results are pretty impressive, to serve clients acroos the globe. We utilizes both continued technical and intellectual education to enhance each project that is brought to Usha Informatique that stands our clients into the world of technology with class.</p><p>Our knowledge and experience in Software and Web solutions have greatly boosted our clients in business augmentation. We specialize in delivering cost-effective software/web solutions by implementing an offshore development model. We have a dedicated team of software professionals to bring quality products to the clients.\r\n</p>\r\n\r\n','About us summary','about us','about us description',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50'),(2,2,'en-US','Delivery Information','delivery-info','Delivery Information','<p>This is delivery information</p>','Delivery information summary','delivery information','deliverr information description',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50'),(3,3,'en-US','Privacy Policy','privacy-policy','Privacy Policy','<p>This is privacy policy</p>','Privacy policy summary','privacy policy','privacy policy description',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50'),(4,4,'en-US','Terms & Conditions','terms','Terms & Conditions','<p>These are terms and conditions</p>','Terms & condition summary','terms & condition','terms & condition description',1,1,'2017-06-21 15:22:50','2017-06-21 15:22:50');
/*!40000 ALTER TABLE `tbl_page_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_person`
--

DROP TABLE IF EXISTS `tbl_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobilephone` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_person`
--

LOCK TABLES `tbl_person` WRITE;
/*!40000 ALTER TABLE `tbl_person` DISABLE KEYS */;
INSERT INTO `tbl_person` VALUES (1,'Super','Admin','','abc@y.com',NULL,NULL,1,1,'2017-06-21 15:22:46','2017-06-21 15:22:46'),(2,'Store','Owner',NULL,'mayank@mayankstore.com',NULL,NULL,1,1,'2017-06-21 15:22:51','2017-06-21 15:22:51'),(3,'Wholesalecustomer','wholesalecustomerlast',NULL,'wholesalecustomer@whatacart.com',NULL,NULL,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(4,'Retailcustomer','retailcustomerlast',NULL,'retailcustomer@whatacart.com',NULL,NULL,1,1,'2017-06-21 15:23:20','2017-06-21 15:23:20'),(5,'Defaultcustomer','defaultcustomerlast',NULL,'defaultcustomer@whatacart.com',NULL,NULL,1,1,'2017-06-21 15:23:30','2017-06-21 15:23:30');
/*!40000 ALTER TABLE `tbl_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` smallint(1) DEFAULT '1',
  `model` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `buy_price` decimal(10,2) DEFAULT '0.00',
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `sku` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `initial_quantity` int(11) DEFAULT NULL,
  `tax_class_id` int(11) DEFAULT NULL,
  `minimum_quantity` int(11) DEFAULT NULL,
  `subtract_stock` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock_status` smallint(1) DEFAULT NULL,
  `requires_shipping` smallint(1) DEFAULT NULL,
  `available_date` date DEFAULT NULL,
  `manufacturer` int(11) DEFAULT NULL,
  `is_featured` smallint(1) DEFAULT NULL,
  `location` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `length_class` int(11) DEFAULT NULL,
  `weight_class` int(11) DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `upc` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ean` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jan` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isbn` varchar(17) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mpn` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_model` (`model`),
  KEY `idx_price` (`price`),
  KEY `idx_status` (`status`),
  KEY `idx_quantity` (`quantity`),
  KEY `idx_sku` (`sku`),
  KEY `idx_stock_status` (`stock_status`),
  KEY `idx_available_date` (`available_date`),
  KEY `idx_manufacturer` (`manufacturer`),
  KEY `idx_tax_class_id` (`tax_class_id`),
  KEY `idx_location` (`location`),
  KEY `idx_length` (`length`),
  KEY `idx_width` (`width`),
  KEY `idx_height` (`height`),
  KEY `idx_length_class` (`length_class`),
  KEY `idx_weight_class` (`weight_class`),
  KEY `idx_buy_price` (`buy_price`),
  KEY `idx_initial_quantity` (`initial_quantity`),
  KEY `idx_type` (`type`),
  KEY `idx_hits` (`hits`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product`
--

LOCK TABLES `tbl_product` WRITE;
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` VALUES (1,1,'Apple Cinema 20\" Model',10.00,10.00,'YzJjZmU1ODapple_cinema_display1.jpg',1,'Apple Cinema 20\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(2,1,'Apple Cinema 21\" Model',20.00,20.00,'NzBmMTZiYzapple_cinema_display10.jpg',1,'Apple Cinema 21\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(3,1,'Apple Cinema 22\" Model',30.00,30.00,'OTI5OWY3MGapple_cinema_display2.jpg',1,'Apple Cinema 22\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(4,1,'Apple Cinema 23\" Model',40.00,40.00,'OTFjYjQ5Mzapple_cinema_display3.jpg',1,'Apple Cinema 23\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(5,1,'Apple Cinema 24\" Model',50.00,50.00,'YWI0M2VlZDapple_cinema_display4.png',1,'Apple Cinema 24\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(6,1,'Apple Cinema 25\" Model',60.00,60.00,'NzY1YzE3NDapple_cinema_display5.jpg',1,'Apple Cinema 25\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(7,1,'Apple Cinema 26\" Model',70.00,70.00,'ZTgwNTc2NDapple_cinema_display6.png',1,'Apple Cinema 26\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(8,1,'Apple Cinema 27\" Model',80.00,80.00,'M2I5MGMxZGapple_cinema_display7.png',1,'Apple Cinema 27\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(9,1,'Apple Cinema 28\" Model',90.00,90.00,'M2U2YzJlNzapple_cinema_display8.jpg',1,'Apple Cinema 28\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(10,1,'Apple Cinema 29\" Model',100.00,100.00,'NDZhZGRkZDapple_cinema_display9.jpg',1,'Apple Cinema 29\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(11,1,'Apple Cinema 30\" Model',110.00,110.00,'MmYwYzcyOGog-image.jpg',1,'Apple Cinema 30\"',10,10,1,1,'1',1,1,NULL,1,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(12,1,'Canon EOS 5D Model',10.00,10.00,'YzY4ODljMDCanon-EOS-5DS3.jpg',1,'Canon EOS 5D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(13,1,'Canon EOS 5 S Model',20.00,20.00,'NTI1ZTUzZjCanon-EOS-5LX1.jpeg',1,'Canon EOS 5 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(14,1,'Canon EOS 5 LX Model',30.00,30.00,'YmIzOTgzNTCanon-EOS-6D4.jpg',1,'Canon EOS 5 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(15,1,'Canon EOS 6D Model',40.00,40.00,'NDc1NDI4MzCanon-EOS-6LX1.jpeg',1,'Canon EOS 6D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(16,1,'Canon EOS 6 S Model',50.00,50.00,'OWMxNjZiY2Canon_EOS_5D1.jpg',1,'Canon EOS 6 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(17,1,'Canon EOS 6 LX Model',60.00,60.00,'ZDNjMTc4NDCanon_EOS_5D2.jpg',1,'Canon EOS 6 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(18,1,'Canon EOS 7D Model',70.00,70.00,'YzY4ODljMDCanon-EOS-5DS3.jpg',1,'Canon EOS 7D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(19,1,'Canon EOS 7 S Model',80.00,80.00,'NTI1ZTUzZjCanon-EOS-5LX1.jpeg',1,'Canon EOS 7 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(20,1,'Canon EOS 7 LX Model',90.00,90.00,'YmIzOTgzNTCanon-EOS-6D4.jpg',1,'Canon EOS 7 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(21,1,'Canon EOS 8D Model',100.00,100.00,'NDc1NDI4MzCanon-EOS-6LX1.jpeg',1,'Canon EOS 8D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(22,1,'Canon EOS 8 S Model',110.00,110.00,'OWMxNjZiY2Canon_EOS_5D1.jpg',1,'Canon EOS 8 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(23,1,'Canon EOS 8 LX Model',120.00,120.00,'ZDNjMTc4NDCanon_EOS_5D2.jpg',1,'Canon EOS 8 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(24,1,'Canon EOS 9D Model',130.00,130.00,'YzY4ODljMDCanon-EOS-5DS3.jpg',1,'Canon EOS 9D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(25,1,'Canon EOS 9 S Model',140.00,140.00,'NTI1ZTUzZjCanon-EOS-5LX1.jpeg',1,'Canon EOS 9 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(26,1,'Canon EOS 9 LX Model',150.00,150.00,'YmIzOTgzNTCanon-EOS-6D4.jpg',1,'Canon EOS 9 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(27,1,'Canon EOS 10D Model',160.00,160.00,'NDc1NDI4MzCanon-EOS-6LX1.jpeg',1,'Canon EOS 10D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(28,1,'Canon EOS 10 S Model',170.00,170.00,'OWMxNjZiY2Canon_EOS_5D1.jpg',1,'Canon EOS 10 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(29,1,'Canon EOS 10 LX Model',180.00,180.00,'ZDNjMTc4NDCanon_EOS_5D2.jpg',1,'Canon EOS 10 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(30,1,'Canon EOS 11D Model',190.00,190.00,'YzY4ODljMDCanon-EOS-5DS3.jpg',1,'Canon EOS 11D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(31,1,'Canon EOS 11 S Model',200.00,200.00,'NTI1ZTUzZjCanon-EOS-5LX1.jpeg',1,'Canon EOS 11 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(32,1,'Canon EOS 11 LX Model',210.00,210.00,'YmIzOTgzNTCanon-EOS-6D4.jpg',1,'Canon EOS 11 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(33,1,'Canon EOS 12D Model',220.00,220.00,'NDc1NDI4MzCanon-EOS-6LX1.jpeg',1,'Canon EOS 12D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(34,1,'Canon EOS 12 S Model',230.00,230.00,'OWMxNjZiY2Canon_EOS_5D1.jpg',1,'Canon EOS 12 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(35,1,'Canon EOS 12 LX Model',240.00,240.00,'ZDNjMTc4NDCanon_EOS_5D2.jpg',1,'Canon EOS 12 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(36,1,'Canon EOS 13D Model',250.00,250.00,'YzY4ODljMDCanon-EOS-5DS3.jpg',1,'Canon EOS 13D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(37,1,'Canon EOS 13 S Model',260.00,260.00,'NTI1ZTUzZjCanon-EOS-5LX1.jpeg',1,'Canon EOS 13 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(38,1,'Canon EOS 13 LX Model',270.00,270.00,'YmIzOTgzNTCanon-EOS-6D4.jpg',1,'Canon EOS 13 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(39,1,'Canon EOS 14D Model',280.00,280.00,'NDc1NDI4MzCanon-EOS-6LX1.jpeg',1,'Canon EOS 14D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(40,1,'Canon EOS 14 S Model',290.00,290.00,'OWMxNjZiY2Canon_EOS_5D1.jpg',1,'Canon EOS 14 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(41,1,'Canon EOS 14 LX Model',300.00,300.00,'ZDNjMTc4NDCanon_EOS_5D2.jpg',1,'Canon EOS 14 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(42,1,'Canon EOS 15D Model',310.00,310.00,'YzY4ODljMDCanon-EOS-5DS3.jpg',1,'Canon EOS 15D',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(43,1,'Canon EOS 15 S Model',320.00,320.00,'NTI1ZTUzZjCanon-EOS-5LX1.jpeg',1,'Canon EOS 15 S',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(44,1,'Canon EOS 15 LX Model',330.00,330.00,'YmIzOTgzNTCanon-EOS-6D4.jpg',1,'Canon EOS 15 LX',10,10,1,1,'1',1,1,NULL,2,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(45,1,'Sony Vaio 20\" Model',10.00,10.00,'N2MyODlhMjsony-vaio-eb-2011q1-black-hero-lg.jpg',1,'Sony Vaio 20\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(46,1,'Sony Vaio 21\" Model',20.00,20.00,'YzRhOGE1Zmsony-vaio-laptop-s13126-black-with-laptop-bag.jpg',1,'Sony Vaio 21\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(47,1,'Sony Vaio 22\" Model',30.00,30.00,'N2UzMmJiMjsony-vaio-laptop-shop-in-jaipur.jpg',1,'Sony Vaio 22\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(48,1,'Sony Vaio 23\" Model',40.00,40.00,'OTNhZmUzNzsony-vaio-new-210114.jpg',1,'Sony Vaio 23\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(49,1,'Sony Vaio 24\" Model',50.00,50.00,'N2MyODlhMjsony-vaio-eb-2011q1-black-hero-lg.jpg',1,'Sony Vaio 24\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(50,1,'Sony Vaio 25\" Model',60.00,60.00,'YzRhOGE1Zmsony-vaio-laptop-s13126-black-with-laptop-bag.jpg',1,'Sony Vaio 25\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(51,1,'Sony Vaio 26\" Model',70.00,70.00,'N2UzMmJiMjsony-vaio-laptop-shop-in-jaipur.jpg',1,'Sony Vaio 26\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(52,1,'Sony Vaio 27\" Model',80.00,80.00,'OTNhZmUzNzsony-vaio-new-210114.jpg',1,'Sony Vaio 27\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(53,1,'Sony Vaio 28\" Model',90.00,90.00,'N2MyODlhMjsony-vaio-eb-2011q1-black-hero-lg.jpg',1,'Sony Vaio 28\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(54,1,'Sony Vaio 29\" Model',100.00,100.00,'YzRhOGE1Zmsony-vaio-laptop-s13126-black-with-laptop-bag.jpg',1,'Sony Vaio 29\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(55,1,'Sony Vaio 30\" Model',110.00,110.00,'N2UzMmJiMjsony-vaio-laptop-shop-in-jaipur.jpg',1,'Sony Vaio 30\"',10,10,1,1,'1',1,1,NULL,4,1,NULL,1,2,3,'2017-06-21',10.00,2,2,0,NULL,NULL,NULL,NULL,NULL,1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09');
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_attribute`
--

DROP TABLE IF EXISTS `tbl_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) DEFAULT NULL,
  `attribute_group` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_attribute_group` (`attribute_group`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute`
--

LOCK TABLES `tbl_product_attribute` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute` VALUES (1,1,1,1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,1,1,1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_attribute_group`
--

DROP TABLE IF EXISTS `tbl_product_attribute_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_attribute_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_group`
--

LOCK TABLES `tbl_product_attribute_group` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_group` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_group` VALUES (1,1,1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,2,1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_attribute_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_attribute_group_translated`
--

DROP TABLE IF EXISTS `tbl_product_attribute_group_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_attribute_group_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_attribute_group_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_attribute_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_group_translated`
--

LOCK TABLES `tbl_product_attribute_group_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_group_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_group_translated` VALUES (1,1,'en-US','Memory',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,2,'en-US','Motherboard',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_attribute_group_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_attribute_mapping`
--

DROP TABLE IF EXISTS `tbl_product_attribute_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_attribute_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  `attribute_value` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_attribute_id` (`attribute_id`),
  KEY `idx_attribute_value` (`attribute_value`),
  CONSTRAINT `fk_tbl_product_attribute_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_mapping`
--

LOCK TABLES `tbl_product_attribute_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_mapping` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_mapping` VALUES (1,1,2,'300 RPM',1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10');
/*!40000 ALTER TABLE `tbl_product_attribute_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_attribute_translated`
--

DROP TABLE IF EXISTS `tbl_product_attribute_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_attribute_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_attribute_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_translated`
--

LOCK TABLES `tbl_product_attribute_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_translated` VALUES (1,1,'en-US','Clockspeed',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,2,'en-US','Fan Speed',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_attribute_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_category`
--

DROP TABLE IF EXISTS `tbl_product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(2) DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `displayintopmenu` smallint(1) DEFAULT NULL,
  `data_category_id` int(11) NOT NULL,
  `code` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_parent_id` (`parent_id`),
  KEY `idx_status` (`status`),
  KEY `idx_data_category_id` (`data_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_category`
--

LOCK TABLES `tbl_product_category` WRITE;
/*!40000 ALTER TABLE `tbl_product_category` DISABLE KEYS */;
INSERT INTO `tbl_product_category` VALUES (1,'NzgxYTQzZTdesktop_category.jpg',0,0,1,1,1,'DT','1',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,'YWI5NDVjYTlaptop_category.jpg',0,0,1,1,1,'LTNB','2',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(3,'NWZlZjc5Mmcamera_category.jpg',0,0,1,1,1,'CM','3',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_category_mapping`
--

DROP TABLE IF EXISTS `tbl_product_category_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_category_mapping` (
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `data_category_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_data_category_id` (`data_category_id`),
  CONSTRAINT `fk_tbl_product_category_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_category_mapping`
--

LOCK TABLES `tbl_product_category_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_category_mapping` DISABLE KEYS */;
INSERT INTO `tbl_product_category_mapping` VALUES (1,1,1,0,0,NULL,NULL),(2,1,1,0,0,NULL,NULL),(3,1,1,0,0,NULL,NULL),(4,1,1,0,0,NULL,NULL),(5,1,1,0,0,NULL,NULL),(6,1,1,0,0,NULL,NULL),(7,1,1,0,0,NULL,NULL),(8,1,1,0,0,NULL,NULL),(9,1,1,0,0,NULL,NULL),(10,1,1,0,0,NULL,NULL),(11,1,1,0,0,NULL,NULL),(12,3,1,0,0,NULL,NULL),(13,3,1,0,0,NULL,NULL),(14,3,1,0,0,NULL,NULL),(15,3,1,0,0,NULL,NULL),(16,3,1,0,0,NULL,NULL),(17,3,1,0,0,NULL,NULL),(18,3,1,0,0,NULL,NULL),(19,3,1,0,0,NULL,NULL),(20,3,1,0,0,NULL,NULL),(21,3,1,0,0,NULL,NULL),(22,3,1,0,0,NULL,NULL),(23,3,1,0,0,NULL,NULL),(24,3,1,0,0,NULL,NULL),(25,3,1,0,0,NULL,NULL),(26,3,1,0,0,NULL,NULL),(27,3,1,0,0,NULL,NULL),(28,3,1,0,0,NULL,NULL),(29,3,1,0,0,NULL,NULL),(30,3,1,0,0,NULL,NULL),(31,3,1,0,0,NULL,NULL),(32,3,1,0,0,NULL,NULL),(33,3,1,0,0,NULL,NULL),(34,3,1,0,0,NULL,NULL),(35,3,1,0,0,NULL,NULL),(36,3,1,0,0,NULL,NULL),(37,3,1,0,0,NULL,NULL),(38,3,1,0,0,NULL,NULL),(39,3,1,0,0,NULL,NULL),(40,3,1,0,0,NULL,NULL),(41,3,1,0,0,NULL,NULL),(42,3,1,0,0,NULL,NULL),(43,3,1,0,0,NULL,NULL),(44,3,1,0,0,NULL,NULL),(45,2,1,0,0,NULL,NULL),(46,2,1,0,0,NULL,NULL),(47,2,1,0,0,NULL,NULL),(48,2,1,0,0,NULL,NULL),(49,2,1,0,0,NULL,NULL),(50,2,1,0,0,NULL,NULL),(51,2,1,0,0,NULL,NULL),(52,2,1,0,0,NULL,NULL),(53,2,1,0,0,NULL,NULL),(54,2,1,0,0,NULL,NULL),(55,2,1,0,0,NULL,NULL);
/*!40000 ALTER TABLE `tbl_product_category_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_category_translated`
--

DROP TABLE IF EXISTS `tbl_product_category_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_category_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `metakeywords` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `metadescription` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  KEY `idx_alias` (`alias`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_category_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_category_translated`
--

LOCK TABLES `tbl_product_category_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_category_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_category_translated` VALUES (1,1,'en-US','Desktops','desktops',NULL,NULL,'Shop Desktop feature only the best desktop deals on the market',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,2,'en-US','Laptops & Notebooks','laptops-notebooks',NULL,NULL,'Shop Laptop feature only the best laptop deals on the market',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(3,3,'en-US','Camera','camera',NULL,NULL,'Shop Camera feature only the best laptop deals on the market',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_category_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_discount`
--

DROP TABLE IF EXISTS `tbl_product_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `priority` int(2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_group_id` (`group_id`),
  KEY `idx_quantity` (`quantity`),
  KEY `idx_priority` (`priority`),
  KEY `idx_price` (`price`),
  KEY `idx_start_datetime` (`start_datetime`),
  KEY `idx_end_datetime` (`end_datetime`),
  CONSTRAINT `fk_tbl_product_discount_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_discount`
--

LOCK TABLES `tbl_product_discount` WRITE;
/*!40000 ALTER TABLE `tbl_product_discount` DISABLE KEYS */;
INSERT INTO `tbl_product_discount` VALUES (1,3,2,1,1.00,'2017-06-24 15:23:10','2017-06-28 15:23:10',1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(2,4,5,2,2.00,'2017-06-24 15:23:10','2017-06-28 15:23:10',1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10');
/*!40000 ALTER TABLE `tbl_product_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_download`
--

DROP TABLE IF EXISTS `tbl_product_download`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_download` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `allowed_downloads` int(10) DEFAULT '0',
  `number_of_days` int(10) DEFAULT '0',
  `size` double DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_download`
--

LOCK TABLES `tbl_product_download` WRITE;
/*!40000 ALTER TABLE `tbl_product_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_download_mapping`
--

DROP TABLE IF EXISTS `tbl_product_download_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_download_mapping` (
  `product_id` int(11) DEFAULT NULL,
  `download_id` int(11) DEFAULT NULL,
  `download_option` varchar(28) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_download_id` (`download_id`),
  KEY `idx_download_option` (`download_option`),
  CONSTRAINT `fk_tbl_product_download_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_download_mapping`
--

LOCK TABLES `tbl_product_download_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_download_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_download_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_download_translated`
--

DROP TABLE IF EXISTS `tbl_product_download_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_download_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_download_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_download` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_download_translated`
--

LOCK TABLES `tbl_product_download_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_download_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_download_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_image`
--

DROP TABLE IF EXISTS `tbl_product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `fk_tbl_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_image`
--

LOCK TABLES `tbl_product_image` WRITE;
/*!40000 ALTER TABLE `tbl_product_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_image_translated`
--

DROP TABLE IF EXISTS `tbl_product_image_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_image_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_caption` (`caption`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_product_image_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_image_translated`
--

LOCK TABLES `tbl_product_image_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_image_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_image_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_option`
--

DROP TABLE IF EXISTS `tbl_product_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option`
--

LOCK TABLES `tbl_product_option` WRITE;
/*!40000 ALTER TABLE `tbl_product_option` DISABLE KEYS */;
INSERT INTO `tbl_product_option` VALUES (1,'checkbox',NULL,1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,'radio',NULL,1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(3,'select',NULL,1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_option_mapping`
--

DROP TABLE IF EXISTS `tbl_product_option_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_option_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `required` smallint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_option_id` (`option_id`),
  KEY `idx_required` (`required`),
  CONSTRAINT `fk_tbl_product_option_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_mapping`
--

LOCK TABLES `tbl_product_option_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_mapping` DISABLE KEYS */;
INSERT INTO `tbl_product_option_mapping` VALUES (1,1,1,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(2,45,2,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(3,12,3,1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10');
/*!40000 ALTER TABLE `tbl_product_option_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_option_mapping_details`
--

DROP TABLE IF EXISTS `tbl_product_option_mapping_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_option_mapping_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mapping_id` int(11) NOT NULL,
  `option_value_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(10) NOT NULL,
  `subtract_stock` smallint(1) NOT NULL,
  `price_prefix` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `weight_prefix` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_mapping_id` (`mapping_id`),
  KEY `idx_option_value_id` (`option_value_id`),
  KEY `idx_quantity` (`quantity`),
  KEY `idx_price_prefix` (`price_prefix`),
  KEY `idx_price` (`price`),
  KEY `idx_weight_prefix` (`weight_prefix`),
  KEY `idx_weight` (`weight`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_mapping_details`
--

LOCK TABLES `tbl_product_option_mapping_details` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_mapping_details` DISABLE KEYS */;
INSERT INTO `tbl_product_option_mapping_details` VALUES (1,1,'1',1,1,'+',5.00,'+',0.00,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(2,1,'2',1,1,'+',10.00,'+',0.00,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(3,2,'4',1,1,'+',10.00,'+',0.00,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(4,2,'5',1,1,'+',15.00,'+',0.00,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(5,3,'8',1,1,'+',20.00,'+',0.00,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(6,3,'9',1,1,'+',25.00,'+',0.00,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10');
/*!40000 ALTER TABLE `tbl_product_option_mapping_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_option_translated`
--

DROP TABLE IF EXISTS `tbl_product_option_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_option_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_display_name` (`display_name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_option_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_translated`
--

LOCK TABLES `tbl_product_option_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_option_translated` VALUES (1,1,'en-US','Color','color',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(2,2,'en-US','Size','size',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05'),(3,3,'en-US','Resolution','resolution',1,1,'2017-06-21 15:23:05','2017-06-21 15:23:05');
/*!40000 ALTER TABLE `tbl_product_option_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_option_value`
--

DROP TABLE IF EXISTS `tbl_product_option_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_option_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_option_id` (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_value`
--

LOCK TABLES `tbl_product_option_value` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_value` DISABLE KEYS */;
INSERT INTO `tbl_product_option_value` VALUES (1,1,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(2,1,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(3,1,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(4,2,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(5,2,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(6,2,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(7,2,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(8,3,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(9,3,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(10,3,1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06');
/*!40000 ALTER TABLE `tbl_product_option_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_option_value_translated`
--

DROP TABLE IF EXISTS `tbl_product_option_value_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_option_value_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_value` (`value`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_product_option_value_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_option_value` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_value_translated`
--

LOCK TABLES `tbl_product_option_value_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_value_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_option_value_translated` VALUES (1,1,'en-US','Grey',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(2,2,'en-US','Silver',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(3,3,'en-US','Black',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(4,4,'en-US','L',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(5,5,'en-US','M',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(6,6,'en-US','XL',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(7,7,'en-US','S',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(8,8,'en-US','4MP',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(9,9,'en-US','8MP',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06'),(10,10,'en-US','10MP',1,1,'2017-06-21 15:23:06','2017-06-21 15:23:06');
/*!40000 ALTER TABLE `tbl_product_option_value_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_rating`
--

DROP TABLE IF EXISTS `tbl_product_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` decimal(10,2) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_rating` (`rating`),
  CONSTRAINT `fk_tbl_product_rating_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_rating`
--

LOCK TABLES `tbl_product_rating` WRITE;
/*!40000 ALTER TABLE `tbl_product_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_related_product_mapping`
--

DROP TABLE IF EXISTS `tbl_product_related_product_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_related_product_mapping` (
  `product_id` int(11) DEFAULT NULL,
  `related_product_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_related_product_id` (`related_product_id`),
  CONSTRAINT `fk_tbl_product_related_product_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_related_product_mapping`
--

LOCK TABLES `tbl_product_related_product_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_related_product_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_related_product_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_review`
--

DROP TABLE IF EXISTS `tbl_product_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(1) NOT NULL,
  `product_id` int(11) NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_tbl_product_review_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_review`
--

LOCK TABLES `tbl_product_review` WRITE;
/*!40000 ALTER TABLE `tbl_product_review` DISABLE KEYS */;
INSERT INTO `tbl_product_review` VALUES (1,'Wholesalecustomer wholesalecustomerlast',2,1,'wholesalecustomer@whatacart.com',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(2,'Wholesalecustomer wholesalecustomerlast',2,1,'wholesalecustomer@whatacart.com',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(3,'Wholesalecustomer wholesalecustomerlast',2,1,'wholesalecustomer@whatacart.com',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(4,'Wholesalecustomer wholesalecustomerlast',2,1,'wholesalecustomer@whatacart.com',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09');
/*!40000 ALTER TABLE `tbl_product_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_review_translated`
--

DROP TABLE IF EXISTS `tbl_product_review_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_review_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `review` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  CONSTRAINT `fk_tbl_product_review_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_review` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_review_translated`
--

LOCK TABLES `tbl_product_review_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_review_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_review_translated` VALUES (1,1,'en-US','This is my first review',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(2,2,'en-US','This is my second review',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(3,3,'en-US','This is my third review',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(4,4,'en-US','This is my fourth review',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09');
/*!40000 ALTER TABLE `tbl_product_review_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_special`
--

DROP TABLE IF EXISTS `tbl_product_special`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_special` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `priority` int(2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_group_id` (`group_id`),
  KEY `idx_priority` (`priority`),
  KEY `idx_price` (`price`),
  KEY `idx_start_datetime` (`start_datetime`),
  KEY `idx_end_datetime` (`end_datetime`),
  CONSTRAINT `fk_tbl_product_special_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_special`
--

LOCK TABLES `tbl_product_special` WRITE;
/*!40000 ALTER TABLE `tbl_product_special` DISABLE KEYS */;
INSERT INTO `tbl_product_special` VALUES (1,3,1,1.00,'2017-06-16 15:23:10','2017-06-23 15:23:10',1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10'),(2,4,2,2.00,'2017-06-16 15:23:10','2017-06-23 15:23:10',1,1,1,'2017-06-21 15:23:10','2017-06-21 15:23:10');
/*!40000 ALTER TABLE `tbl_product_special` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_tag_mapping`
--

DROP TABLE IF EXISTS `tbl_product_tag_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_tag_mapping` (
  `product_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_tag_id` (`tag_id`),
  CONSTRAINT `fk_tbl_product_tag_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_tag_mapping`
--

LOCK TABLES `tbl_product_tag_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_tag_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_tag_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_tax_class`
--

DROP TABLE IF EXISTS `tbl_product_tax_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_tax_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_tax_class`
--

LOCK TABLES `tbl_product_tax_class` WRITE;
/*!40000 ALTER TABLE `tbl_product_tax_class` DISABLE KEYS */;
INSERT INTO `tbl_product_tax_class` VALUES (1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_product_tax_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_tax_class_translated`
--

DROP TABLE IF EXISTS `tbl_product_tax_class_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_tax_class_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_tax_class_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_tax_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_tax_class_translated`
--

LOCK TABLES `tbl_product_tax_class_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_tax_class_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_tax_class_translated` VALUES (1,1,'en-US','taxable goods','Applied to goods on which tax has to be applied',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_product_tax_class_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_translated`
--

DROP TABLE IF EXISTS `tbl_product_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `metakeywords` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `metadescription` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_alias` (`alias`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_translated`
--

LOCK TABLES `tbl_product_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_translated` VALUES (1,1,'en-US','Apple Cinema 20\"','apple-cinema-20\"',NULL,NULL,'This is description for product Apple Cinema 20\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(2,2,'en-US','Apple Cinema 21\"','apple-cinema-21\"',NULL,NULL,'This is description for product Apple Cinema 21\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(3,3,'en-US','Apple Cinema 22\"','apple-cinema-22\"',NULL,NULL,'This is description for product Apple Cinema 22\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(4,4,'en-US','Apple Cinema 23\"','apple-cinema-23\"',NULL,NULL,'This is description for product Apple Cinema 23\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(5,5,'en-US','Apple Cinema 24\"','apple-cinema-24\"',NULL,NULL,'This is description for product Apple Cinema 24\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(6,6,'en-US','Apple Cinema 25\"','apple-cinema-25\"',NULL,NULL,'This is description for product Apple Cinema 25\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(7,7,'en-US','Apple Cinema 26\"','apple-cinema-26\"',NULL,NULL,'This is description for product Apple Cinema 26\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(8,8,'en-US','Apple Cinema 27\"','apple-cinema-27\"',NULL,NULL,'This is description for product Apple Cinema 27\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(9,9,'en-US','Apple Cinema 28\"','apple-cinema-28\"',NULL,NULL,'This is description for product Apple Cinema 28\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(10,10,'en-US','Apple Cinema 29\"','apple-cinema-29\"',NULL,NULL,'This is description for product Apple Cinema 29\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(11,11,'en-US','Apple Cinema 30\"','apple-cinema-30\"',NULL,NULL,'This is description for product Apple Cinema 30\"',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(12,12,'en-US','Canon EOS 5D','canon-eos-5d',NULL,NULL,'This is description for product Canon EOS 5D',1,1,'2017-06-21 15:23:08','2017-06-21 15:23:08'),(13,13,'en-US','Canon EOS 5 S','canon-eos-5-s',NULL,NULL,'This is description for product Canon EOS 5 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(14,14,'en-US','Canon EOS 5 LX','canon-eos-5-lx',NULL,NULL,'This is description for product Canon EOS 5 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(15,15,'en-US','Canon EOS 6D','canon-eos-6d',NULL,NULL,'This is description for product Canon EOS 6D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(16,16,'en-US','Canon EOS 6 S','canon-eos-6-s',NULL,NULL,'This is description for product Canon EOS 6 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(17,17,'en-US','Canon EOS 6 LX','canon-eos-6-lx',NULL,NULL,'This is description for product Canon EOS 6 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(18,18,'en-US','Canon EOS 7D','canon-eos-7d',NULL,NULL,'This is description for product Canon EOS 7D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(19,19,'en-US','Canon EOS 7 S','canon-eos-7-s',NULL,NULL,'This is description for product Canon EOS 7 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(20,20,'en-US','Canon EOS 7 LX','canon-eos-7-lx',NULL,NULL,'This is description for product Canon EOS 7 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(21,21,'en-US','Canon EOS 8D','canon-eos-8d',NULL,NULL,'This is description for product Canon EOS 8D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(22,22,'en-US','Canon EOS 8 S','canon-eos-8-s',NULL,NULL,'This is description for product Canon EOS 8 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(23,23,'en-US','Canon EOS 8 LX','canon-eos-8-lx',NULL,NULL,'This is description for product Canon EOS 8 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(24,24,'en-US','Canon EOS 9D','canon-eos-9d',NULL,NULL,'This is description for product Canon EOS 9D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(25,25,'en-US','Canon EOS 9 S','canon-eos-9-s',NULL,NULL,'This is description for product Canon EOS 9 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(26,26,'en-US','Canon EOS 9 LX','canon-eos-9-lx',NULL,NULL,'This is description for product Canon EOS 9 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(27,27,'en-US','Canon EOS 10D','canon-eos-10d',NULL,NULL,'This is description for product Canon EOS 10D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(28,28,'en-US','Canon EOS 10 S','canon-eos-10-s',NULL,NULL,'This is description for product Canon EOS 10 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(29,29,'en-US','Canon EOS 10 LX','canon-eos-10-lx',NULL,NULL,'This is description for product Canon EOS 10 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(30,30,'en-US','Canon EOS 11D','canon-eos-11d',NULL,NULL,'This is description for product Canon EOS 11D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(31,31,'en-US','Canon EOS 11 S','canon-eos-11-s',NULL,NULL,'This is description for product Canon EOS 11 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(32,32,'en-US','Canon EOS 11 LX','canon-eos-11-lx',NULL,NULL,'This is description for product Canon EOS 11 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(33,33,'en-US','Canon EOS 12D','canon-eos-12d',NULL,NULL,'This is description for product Canon EOS 12D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(34,34,'en-US','Canon EOS 12 S','canon-eos-12-s',NULL,NULL,'This is description for product Canon EOS 12 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(35,35,'en-US','Canon EOS 12 LX','canon-eos-12-lx',NULL,NULL,'This is description for product Canon EOS 12 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(36,36,'en-US','Canon EOS 13D','canon-eos-13d',NULL,NULL,'This is description for product Canon EOS 13D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(37,37,'en-US','Canon EOS 13 S','canon-eos-13-s',NULL,NULL,'This is description for product Canon EOS 13 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(38,38,'en-US','Canon EOS 13 LX','canon-eos-13-lx',NULL,NULL,'This is description for product Canon EOS 13 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(39,39,'en-US','Canon EOS 14D','canon-eos-14d',NULL,NULL,'This is description for product Canon EOS 14D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(40,40,'en-US','Canon EOS 14 S','canon-eos-14-s',NULL,NULL,'This is description for product Canon EOS 14 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(41,41,'en-US','Canon EOS 14 LX','canon-eos-14-lx',NULL,NULL,'This is description for product Canon EOS 14 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(42,42,'en-US','Canon EOS 15D','canon-eos-15d',NULL,NULL,'This is description for product Canon EOS 15D',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(43,43,'en-US','Canon EOS 15 S','canon-eos-15-s',NULL,NULL,'This is description for product Canon EOS 15 S',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(44,44,'en-US','Canon EOS 15 LX','canon-eos-15-lx',NULL,NULL,'This is description for product Canon EOS 15 LX',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(45,45,'en-US','Sony Vaio 20\"','sony-vaio-20\"',NULL,NULL,'This is description for product Sony Vaio 20\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(46,46,'en-US','Sony Vaio 21\"','sony-vaio-21\"',NULL,NULL,'This is description for product Sony Vaio 21\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(47,47,'en-US','Sony Vaio 22\"','sony-vaio-22\"',NULL,NULL,'This is description for product Sony Vaio 22\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(48,48,'en-US','Sony Vaio 23\"','sony-vaio-23\"',NULL,NULL,'This is description for product Sony Vaio 23\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(49,49,'en-US','Sony Vaio 24\"','sony-vaio-24\"',NULL,NULL,'This is description for product Sony Vaio 24\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(50,50,'en-US','Sony Vaio 25\"','sony-vaio-25\"',NULL,NULL,'This is description for product Sony Vaio 25\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(51,51,'en-US','Sony Vaio 26\"','sony-vaio-26\"',NULL,NULL,'This is description for product Sony Vaio 26\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(52,52,'en-US','Sony Vaio 27\"','sony-vaio-27\"',NULL,NULL,'This is description for product Sony Vaio 27\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(53,53,'en-US','Sony Vaio 28\"','sony-vaio-28\"',NULL,NULL,'This is description for product Sony Vaio 28\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(54,54,'en-US','Sony Vaio 29\"','sony-vaio-29\"',NULL,NULL,'This is description for product Sony Vaio 29\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09'),(55,55,'en-US','Sony Vaio 30\"','sony-vaio-30\"',NULL,NULL,'This is description for product Sony Vaio 30\"',1,1,'2017-06-21 15:23:09','2017-06-21 15:23:09');
/*!40000 ALTER TABLE `tbl_product_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sequence`
--

DROP TABLE IF EXISTS `tbl_sequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sequence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_sequence_no` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `customer_sequence_no` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `order_sequence_no` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_invoice_sequence_no` (`invoice_sequence_no`),
  KEY `idx_customer_sequence_no` (`customer_sequence_no`),
  KEY `idx_order_sequence_no` (`order_sequence_no`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sequence`
--

LOCK TABLES `tbl_sequence` WRITE;
/*!40000 ALTER TABLE `tbl_sequence` DISABLE KEYS */;
INSERT INTO `tbl_sequence` VALUES (1,'0','10002','0',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04');
/*!40000 ALTER TABLE `tbl_sequence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_session`
--

DROP TABLE IF EXISTS `tbl_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_session` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_expire` (`expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_session`
--

LOCK TABLES `tbl_session` WRITE;
/*!40000 ALTER TABLE `tbl_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_state`
--

DROP TABLE IF EXISTS `tbl_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `status` smallint(1) DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_country` (`country_id`),
  KEY `idx_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_state`
--

LOCK TABLES `tbl_state` WRITE;
/*!40000 ALTER TABLE `tbl_state` DISABLE KEYS */;
INSERT INTO `tbl_state` VALUES (1,1,1,'DE',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,1,1,'AS',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,1,1,'GO',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,1,1,'MN',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_state_translated`
--

DROP TABLE IF EXISTS `tbl_state_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_state_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_state_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_state` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_state_translated`
--

LOCK TABLES `tbl_state_translated` WRITE;
/*!40000 ALTER TABLE `tbl_state_translated` DISABLE KEYS */;
INSERT INTO `tbl_state_translated` VALUES (1,1,'en-US','Delhi',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,2,'en-US','Assam',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,3,'en-US','Goa',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,4,'en-US','Manipur',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_state_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_stock_status`
--

DROP TABLE IF EXISTS `tbl_stock_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_stock_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_stock_status`
--

LOCK TABLES `tbl_stock_status` WRITE;
/*!40000 ALTER TABLE `tbl_stock_status` DISABLE KEYS */;
INSERT INTO `tbl_stock_status` VALUES (1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_stock_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_stock_status_translated`
--

DROP TABLE IF EXISTS `tbl_stock_status_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_stock_status_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_stock_status_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_stock_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_stock_status_translated`
--

LOCK TABLES `tbl_stock_status_translated` WRITE;
/*!40000 ALTER TABLE `tbl_stock_status_translated` DISABLE KEYS */;
INSERT INTO `tbl_stock_status_translated` VALUES (1,1,'en-US','In Stock',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,2,'en-US','Out Of Stock',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_stock_status_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_store`
--

DROP TABLE IF EXISTS `tbl_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `data_category_id` int(11) NOT NULL,
  `is_default` smallint(1) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `theme` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_data_category_id` (`data_category_id`),
  KEY `idx_theme` (`theme`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store`
--

LOCK TABLES `tbl_store` WRITE;
/*!40000 ALTER TABLE `tbl_store` DISABLE KEYS */;
INSERT INTO `tbl_store` VALUES (1,'http://teststore.org',1,1,0,2,NULL,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04');
/*!40000 ALTER TABLE `tbl_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_store_configuration`
--

DROP TABLE IF EXISTS `tbl_store_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_store_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `category` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_store_code_key` (`store_id`,`code`,`key`),
  KEY `idx_store_id` (`store_id`),
  KEY `idx_category` (`category`),
  KEY `idx_code` (`code`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_configuration`
--

LOCK TABLES `tbl_store_configuration` WRITE;
/*!40000 ALTER TABLE `tbl_store_configuration` DISABLE KEYS */;
INSERT INTO `tbl_store_configuration` VALUES (1,1,'storeconfig','storesettings','invoice_prefix','#',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(2,1,'storeconfig','storesettings','catalog_items_per_page','8',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(3,1,'storeconfig','storesettings','list_description_limit','100',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(4,1,'storeconfig','storesettings','display_price_with_tax','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(5,1,'storeconfig','storesettings','tax_calculation_based_on','billing',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(6,1,'storeconfig','storesettings','guest_checkout','0',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(7,1,'storeconfig','storesettings','order_status','8',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(8,1,'storeconfig','storesettings','display_stock','0',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(9,1,'storeconfig','storesettings','customer_online','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(10,1,'storeconfig','storesettings','default_customer_group','2',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(11,1,'storeconfig','storesettings','allow_reviews','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(12,1,'storeconfig','storesettings','allow_guest_reviews','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(13,1,'storeconfig','storesettings','show_out_of_stock_warning','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(14,1,'storeconfig','storesettings','allow_out_of_stock_checkout','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(15,1,'storeconfig','storesettings','allow_wishlist','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(16,1,'storeconfig','storesettings','allow_compare_products','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(17,1,'storeconfig','storesettings','customer_prefix','#',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(18,1,'storeconfig','storesettings','order_prefix','#',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(19,1,'storeconfig','storesettings','display_weight','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(20,1,'storeconfig','storesettings','display_dimensions','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(21,1,'storeconfig','storelocal','country','IN',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(22,1,'storeconfig','storelocal','timezone','Asia/Kolkata',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(23,1,'storeconfig','storelocal','state','Haryana',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(24,1,'storeconfig','storelocal','currency','USD',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(25,1,'storeconfig','storelocal','length_class','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(26,1,'storeconfig','storelocal','weight_class','1',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(27,1,'storeconfig','storelocal','language','en-US',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(28,1,'storeconfig','storeimage','store_logo','',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(29,1,'storeconfig','storeimage','icon','',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(30,1,'storeconfig','storeimage','category_image_width','90',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(31,1,'storeconfig','storeimage','category_image_height','90',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(32,1,'storeconfig','storeimage','product_list_image_width','150',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(33,1,'storeconfig','storeimage','product_list_image_height','150',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(34,1,'storeconfig','storeimage','related_product_image_width','80',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(35,1,'storeconfig','storeimage','related_product_image_height','80',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(36,1,'storeconfig','storeimage','compare_image_width','90',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(37,1,'storeconfig','storeimage','compare_image_height','90',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(38,1,'storeconfig','storeimage','wishlist_image_width','47',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(39,1,'storeconfig','storeimage','wishlist_image_height','47',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(40,1,'storeconfig','storeimage','cart_image_width','47',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(41,1,'storeconfig','storeimage','cart_image_height','47',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(42,1,'storeconfig','storeimage','store_image_width','47',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04'),(43,1,'storeconfig','storeimage','store_image_height','47',1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04');
/*!40000 ALTER TABLE `tbl_store_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_store_translated`
--

DROP TABLE IF EXISTS `tbl_store_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_store_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `metakeywords` text COLLATE utf8_unicode_ci,
  `metadescription` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_store_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_translated`
--

LOCK TABLES `tbl_store_translated` WRITE;
/*!40000 ALTER TABLE `tbl_store_translated` DISABLE KEYS */;
INSERT INTO `tbl_store_translated` VALUES (1,1,'en-US','Default','This is test store set up with the application',NULL,NULL,1,1,'2017-06-21 15:23:04','2017-06-21 15:23:04');
/*!40000 ALTER TABLE `tbl_store_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tag`
--

DROP TABLE IF EXISTS `tbl_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frequency` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_frequency` (`frequency`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tag`
--

LOCK TABLES `tbl_tag` WRITE;
/*!40000 ALTER TABLE `tbl_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tag_translated`
--

DROP TABLE IF EXISTS `tbl_tag_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tag_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_tag_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tag_translated`
--

LOCK TABLES `tbl_tag_translated` WRITE;
/*!40000 ALTER TABLE `tbl_tag_translated` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_tag_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tax_rule`
--

DROP TABLE IF EXISTS `tbl_tax_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tax_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `based_on` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_based_on` (`based_on`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tax_rule`
--

LOCK TABLES `tbl_tax_rule` WRITE;
/*!40000 ALTER TABLE `tbl_tax_rule` DISABLE KEYS */;
INSERT INTO `tbl_tax_rule` VALUES (1,'shipping','percent','4',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,'billing','percent','5',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_tax_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tax_rule_details`
--

DROP TABLE IF EXISTS `tbl_tax_rule_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tax_rule_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_rule_id` int(11) NOT NULL,
  `product_tax_class_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `tax_zone_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_tax_class_id` (`product_tax_class_id`),
  KEY `idx_customer_group_id` (`customer_group_id`),
  KEY `idx_tax_rule_id` (`tax_rule_id`),
  KEY `idx_tax_zone_id` (`tax_zone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tax_rule_details`
--

LOCK TABLES `tbl_tax_rule_details` WRITE;
/*!40000 ALTER TABLE `tbl_tax_rule_details` DISABLE KEYS */;
INSERT INTO `tbl_tax_rule_details` VALUES (1,1,1,2,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,1,1,4,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(3,1,1,3,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(4,2,1,2,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(5,2,1,4,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(6,2,1,3,1,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_tax_rule_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tax_rule_translated`
--

DROP TABLE IF EXISTS `tbl_tax_rule_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tax_rule_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_tax_rule_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_tax_rule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tax_rule_translated`
--

LOCK TABLES `tbl_tax_rule_translated` WRITE;
/*!40000 ALTER TABLE `tbl_tax_rule_translated` DISABLE KEYS */;
INSERT INTO `tbl_tax_rule_translated` VALUES (1,1,'en-US','Sales Tax',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,2,'en-US','Service Tax',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_tax_rule_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `login_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `timezone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`),
  UNIQUE KEY `idx_person_id` (`person_id`),
  KEY `idx_status` (`status`),
  KEY `idx_timezone` (`timezone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'super',NULL,'$2y$13$Bme2Xkvh25pTTG/25pIjP.4ik/mV/J3BQwVqxVpDhUUa4qJgcIX0G','-zeF_12Gwl-t2RdiG5YVLatK_RvD5Q6G',1,1,NULL,NULL,'Asia/Kolkata','system',1,1,'2017-06-21 15:22:47','2017-06-21 15:22:47'),(2,'storeowner',NULL,'$2y$13$pclyuWXVmlG52k.5JXxKWOEsybEQ/AXFpdlIdQpS8wXyq4ti1u7aG','BjSAg8TN8cr1xpTctDR3L0A4-eOZgTY2',1,2,NULL,NULL,'Asia/Kolkata','system',1,1,'2017-06-21 15:22:52','2017-06-21 15:22:52');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_weight_class`
--

DROP TABLE IF EXISTS `tbl_weight_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_weight_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unit` (`unit`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_weight_class`
--

LOCK TABLES `tbl_weight_class` WRITE;
/*!40000 ALTER TABLE `tbl_weight_class` DISABLE KEYS */;
INSERT INTO `tbl_weight_class` VALUES (1,'kg',1.00,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,'g',1000.00,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,'oz',35.27,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,'lb',2.20,1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_weight_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_weight_class_translated`
--

DROP TABLE IF EXISTS `tbl_weight_class_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_weight_class_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_weight_class_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_weight_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_weight_class_translated`
--

LOCK TABLES `tbl_weight_class_translated` WRITE;
/*!40000 ALTER TABLE `tbl_weight_class_translated` DISABLE KEYS */;
INSERT INTO `tbl_weight_class_translated` VALUES (1,1,'en-US','Kilogram',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(2,2,'en-US','Gram',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(3,3,'en-US','Ounce',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48'),(4,4,'en-US','Pound',1,1,'2017-06-21 15:22:48','2017-06-21 15:22:48');
/*!40000 ALTER TABLE `tbl_weight_class_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_zone`
--

DROP TABLE IF EXISTS `tbl_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `zip` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_zip_range` smallint(1) DEFAULT NULL,
  `from_zip` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_zip` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_country_id` (`country_id`),
  KEY `idx_state_id` (`state_id`),
  KEY `idx_zip` (`zip`),
  KEY `idx_is_zip_range` (`is_zip_range`),
  KEY `idx_from_zip` (`from_zip`),
  KEY `idx_to_zip` (`to_zip`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_zone`
--

LOCK TABLES `tbl_zone` WRITE;
/*!40000 ALTER TABLE `tbl_zone` DISABLE KEYS */;
INSERT INTO `tbl_zone` VALUES (1,1,1,'110005',0,NULL,NULL,1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,1,4,'*',1,'781000','781010',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_zone_translated`
--

DROP TABLE IF EXISTS `tbl_zone_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_zone_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_zone_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_zone_translated`
--

LOCK TABLES `tbl_zone_translated` WRITE;
/*!40000 ALTER TABLE `tbl_zone_translated` DISABLE KEYS */;
INSERT INTO `tbl_zone_translated` VALUES (1,1,'en-US','North Zone','North Zone for India',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49'),(2,2,'en-US','East Zone','East Zone for India',1,1,'2017-06-21 15:22:49','2017-06-21 15:22:49');
/*!40000 ALTER TABLE `tbl_zone_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'whatacartv2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-21 18:53:44
