-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: usnicartyii2
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
  `relatedmodel` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `relatedmodel_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_country` (`country`),
  KEY `idx_postal_code` (`postal_code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_address`
--

LOCK TABLES `tbl_address` WRITE;
/*!40000 ALTER TABLE `tbl_address` DISABLE KEYS */;
INSERT INTO `tbl_address` VALUES (1,'302','9A/1, W.E.A, Karol Bagh','New Delhi','Delhi','IN','110005','Person',1,1,1,1,1,'2016-10-22 07:52:06','2016-10-22 07:52:06'),(2,'302','9A/1, W.E.A, Karol Bagh','New Delhi','Delhi','IN','110005','Person',2,1,1,1,1,'2016-10-22 07:52:14','2016-10-22 07:52:14'),(3,'302','9A/1, W.E.A, Karol Bagh','New Delhi','Delhi','IN','110005','Person',3,1,1,1,1,'2016-10-22 07:52:20','2016-10-22 07:52:20'),(4,'Billing address','billing address2','Delhi','','IN','110005','Store',1,3,1,1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(5,'Shipping address','shipping address2','Delhi','','IN','110005','Store',1,2,1,1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(6,'address','address2','Delhi','','IN','110005','Person',4,1,1,1,1,'2016-10-22 07:53:21','2016-10-22 07:53:21'),(7,'address','address2','Delhi','','IN','110005','Person',5,1,1,1,1,'2016-10-22 07:53:25','2016-10-22 07:53:25'),(8,'address','address2','Delhi','','IN','110005','Person',6,1,1,1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29'),(9,'Billing address','billing address2','Delhi','','IN','110005','Store',2,3,1,1,1,'2016-10-22 07:53:45','2016-10-22 07:53:45'),(10,'Shipping address','shipping address2','Delhi','','IN','110005','Store',2,2,1,1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_auth_assignment` VALUES ('demo','user','user.update','User','users',1,0,'2016-10-22 07:52:14','0000-00-00 00:00:00'),('demo','user','user.view','User','users',1,0,'2016-10-22 07:52:14','0000-00-00 00:00:00'),('demo','user','user.change-password','User','users',1,0,'2016-10-22 07:52:14','0000-00-00 00:00:00');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_permission` (`name`,`module`,`resource`,`alias`),
  KEY `idx_name` (`name`),
  KEY `idx_alias` (`alias`),
  KEY `idx_resource` (`resource`),
  KEY `idx_module` (`module`)
) ENGINE=InnoDB AUTO_INCREMENT=365 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_auth_permission`
--

LOCK TABLES `tbl_auth_permission` WRITE;
/*!40000 ALTER TABLE `tbl_auth_permission` DISABLE KEYS */;
INSERT INTO `tbl_auth_permission` VALUES (1,'access.auth','Access Tab','AuthModule','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(2,'auth.managepermissions','Manage Permissions','AuthModule','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(3,'group.create','Create Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(4,'group.view','View Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(5,'group.viewother','View Others Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(6,'group.update','Update Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(7,'group.updateother','Update Others Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(8,'group.delete','Delete Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(9,'group.deleteother','Delete Others Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(10,'group.manage','Manage Groups','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(11,'group.bulk-edit','Bulk Edit Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(12,'group.bulk-delete','Bulk Delete Group','Group','auth',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(13,'access.notification','Access Tab','NotificationModule','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(14,'notification.manage','Manage Notifications','Notification','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(15,'notification.bulk-edit','Bulk Edit Notification','Notification','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(16,'notification.bulk-delete','Bulk Delete Notification','Notification','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(17,'notificationtemplate.create','Create Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(18,'notificationtemplate.view','View Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(19,'notificationtemplate.viewother','View Others Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(20,'notificationtemplate.update','Update Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(21,'notificationtemplate.updateother','Update Others Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(22,'notificationtemplate.delete','Delete Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(23,'notificationtemplate.deleteother','Delete Others Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(24,'notificationtemplate.manage','Manage Templates','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(25,'notificationtemplate.bulk-edit','Bulk Edit Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(26,'notificationtemplate.bulk-delete','Bulk Delete Template','NotificationTemplate','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(27,'notificationlayout.create','Create Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(28,'notificationlayout.view','View Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(29,'notificationlayout.viewother','View Others Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(30,'notificationlayout.update','Update Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(31,'notificationlayout.updateother','Update Others Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(32,'notificationlayout.delete','Delete Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(33,'notificationlayout.deleteother','Delete Others Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(34,'notificationlayout.manage','Manage Layouts','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(35,'notificationlayout.bulk-edit','Bulk Edit Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(36,'notificationlayout.bulk-delete','Bulk Delete Layout','NotificationLayout','notification',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(37,'access.service','Access Tab','ServiceModule','service',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(38,'service.migrate','Run Migration','ServiceModule','service',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(39,'service.checksystem','System Configuration','ServiceModule','service',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(40,'service.loadmodulespermissions','Rebuild Permissions','ServiceModule','service',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(41,'service.resetuserpermissions','Reset user permissions','ServiceModule','service',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(42,'service.rebuildmodulemetadata','Rebuild module metadata','ServiceModule','service',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(43,'access.settings','Access Tab','SettingsModule','settings',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(44,'settings.email','Email Settings','SettingsModule','settings',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(45,'settings.site','Site Settings','SettingsModule','settings',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(46,'settings.database','Database Settings','SettingsModule','settings',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(47,'settings.menu','Menu Settings','SettingsModule','settings',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(48,'settings.admin-menu','Admin Menu Settings','SettingsModule','settings',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(49,'settings.module-settings','Module Settings','SettingsModule','settings',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(50,'access.users','Access Tab','UsersModule','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(51,'user.create','Create User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(52,'user.view','View User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(53,'user.viewother','View Others User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(54,'user.update','Update User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(55,'user.updateother','Update Others User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(56,'user.delete','Delete User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(57,'user.deleteother','Delete Others User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(58,'user.manage','Manage Users','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(59,'user.bulk-edit','Bulk Edit User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(60,'user.bulk-delete','Bulk Delete User','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(61,'user.change-password','Change Password','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(62,'user.change-status','Change Status','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(63,'user.settings','Settings','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(64,'user.changepasswordother','Change Others Password','User','users',1,0,'2016-10-22 07:52:06','0000-00-00 00:00:00'),(65,'access.catalog','Access Tab','CatalogModule','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(66,'productcategory.create','Create Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(67,'productcategory.view','View Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(68,'productcategory.viewother','View Others Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(69,'productcategory.update','Update Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(70,'productcategory.updateother','Update Others Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(71,'productcategory.delete','Delete Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(72,'productcategory.deleteother','Delete Others Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(73,'productcategory.manage','Manage Product Categories','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(74,'productcategory.bulk-edit','Bulk Edit Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(75,'productcategory.bulk-delete','Bulk Delete Product Category','ProductCategory','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(76,'product.create','Create Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(77,'product.view','View Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(78,'product.viewother','View Others Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(79,'product.update','Update Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(80,'product.updateother','Update Others Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(81,'product.delete','Delete Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(82,'product.deleteother','Delete Others Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(83,'product.manage','Manage Products','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(84,'product.bulk-edit','Bulk Edit Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(85,'product.bulk-delete','Bulk Delete Product','Product','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(86,'productattributegroup.create','Create Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(87,'productattributegroup.view','View Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(88,'productattributegroup.viewother','View Others Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(89,'productattributegroup.update','Update Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(90,'productattributegroup.updateother','Update Others Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(91,'productattributegroup.delete','Delete Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(92,'productattributegroup.deleteother','Delete Others Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(93,'productattributegroup.manage','Manage Attribute Groups','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(94,'productattributegroup.bulk-edit','Bulk Edit Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(95,'productattributegroup.bulk-delete','Bulk Delete Attribute Group','ProductAttributeGroup','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(96,'productattribute.create','Create Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(97,'productattribute.view','View Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(98,'productattribute.viewother','View Others Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(99,'productattribute.update','Update Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(100,'productattribute.updateother','Update Others Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(101,'productattribute.delete','Delete Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(102,'productattribute.deleteother','Delete Others Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(103,'productattribute.manage','Manage Attributes','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(104,'productattribute.bulk-edit','Bulk Edit Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(105,'productattribute.bulk-delete','Bulk Delete Attribute','ProductAttribute','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(106,'productoption.create','Create Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(107,'productoption.view','View Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(108,'productoption.viewother','View Others Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(109,'productoption.update','Update Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(110,'productoption.updateother','Update Others Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(111,'productoption.delete','Delete Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(112,'productoption.deleteother','Delete Others Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(113,'productoption.manage','Manage Options','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(114,'productoption.bulk-edit','Bulk Edit Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(115,'productoption.bulk-delete','Bulk Delete Option','ProductOption','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(116,'productreview.delete','Delete Review','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(117,'productreview.deleteother','Delete Others Review','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(118,'productreview.manage','Manage Reviews','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(119,'productreview.bulk-delete','Bulk Delete Review','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(120,'productreview.bulk-approve','Bulk Approve','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(121,'productreview.approve','Approve','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(122,'productreview.approveother','Approve other reviews','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(123,'productreview.spam','Spam','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(124,'productreview.spamother','Spam other reviews','ProductReview','catalog',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(125,'access.cms','Access Tab','CmsModule','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(126,'page.create','Create Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(127,'page.view','View Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(128,'page.viewother','View Others Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(129,'page.update','Update Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(130,'page.updateother','Update Others Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(131,'page.delete','Delete Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(132,'page.deleteother','Delete Others Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(133,'page.manage','Manage Pages','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(134,'page.bulk-edit','Bulk Edit Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(135,'page.bulk-delete','Bulk Delete Page','Page','cms',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(136,'access.customer','Access Tab','CustomerModule','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(137,'customer.create','Create Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(138,'customer.view','View Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(139,'customer.viewother','View Others Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(140,'customer.update','Update Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(141,'customer.delete','Delete Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(142,'customer.deleteother','Delete Others Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(143,'customer.manage','Manage Customers','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(144,'customer.bulk-edit','Bulk Edit Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(145,'customer.bulk-delete','Bulk Delete Customer','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(146,'customer.change-password','Change Password','Customer','customer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(147,'access.dataCategories','Access Tab','DataCategoriesModule','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(148,'datacategory.create','Create Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(149,'datacategory.view','View Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(150,'datacategory.viewother','View Others Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(151,'datacategory.update','Update Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(152,'datacategory.updateother','Update Others Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(153,'datacategory.delete','Delete Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(154,'datacategory.deleteother','Delete Others Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(155,'datacategory.manage','Manage Data Categories','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(156,'datacategory.bulk-edit','Bulk Edit Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(157,'datacategory.bulk-delete','Bulk Delete Data Category','DataCategory','dataCategories',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(158,'access.extension','Access Tab','ExtensionModule','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(159,'extension.create','Create Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(160,'extension.view','View Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(161,'extension.viewother','View Others Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(162,'extension.update','Update Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(163,'extension.updateother','Update Others Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(164,'extension.delete','Delete Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(165,'extension.deleteother','Delete Others Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(166,'extension.manage','Manage Extensions','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(167,'extension.bulk-edit','Bulk Edit Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(168,'extension.bulk-delete','Bulk Delete Extension','Extension','extension',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(169,'access.localization','Access Tab','LocalizationModule','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(170,'language.create','Create Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(171,'language.view','View Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(172,'language.viewother','View Others Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(173,'language.update','Update Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(174,'language.updateother','Update Others Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(175,'language.delete','Delete Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(176,'language.deleteother','Delete Others Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(177,'language.manage','Manage Languages','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(178,'language.bulk-edit','Bulk Edit Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(179,'language.bulk-delete','Bulk Delete Language','Language','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(180,'city.create','Create City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(181,'city.view','View City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(182,'city.viewother','View Others City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(183,'city.update','Update City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(184,'city.updateother','Update Others City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(185,'city.delete','Delete City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(186,'city.deleteother','Delete Others City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(187,'city.manage','Manage Cities','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(188,'city.bulk-edit','Bulk Edit City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(189,'city.bulk-delete','Bulk Delete City','City','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(190,'country.create','Create Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(191,'country.view','View Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(192,'country.viewother','View Others Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(193,'country.update','Update Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(194,'country.updateother','Update Others Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(195,'country.delete','Delete Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(196,'country.deleteother','Delete Others Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(197,'country.manage','Manage Countries','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(198,'country.bulk-edit','Bulk Edit Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(199,'country.bulk-delete','Bulk Delete Country','Country','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(200,'currency.create','Create Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(201,'currency.view','View Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(202,'currency.viewother','View Others Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(203,'currency.update','Update Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(204,'currency.updateother','Update Others Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(205,'currency.delete','Delete Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(206,'currency.deleteother','Delete Others Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(207,'currency.manage','Manage Currencies','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(208,'currency.bulk-edit','Bulk Edit Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(209,'currency.bulk-delete','Bulk Delete Currency','Currency','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(210,'state.create','Create State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(211,'state.view','View State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(212,'state.viewother','View Others State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(213,'state.update','Update State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(214,'state.updateother','Update Others State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(215,'state.delete','Delete State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(216,'state.deleteother','Delete Others State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(217,'state.manage','Manage States','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(218,'state.bulk-edit','Bulk Edit State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(219,'state.bulk-delete','Bulk Delete State','State','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(220,'lengthclass.create','Create Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(221,'lengthclass.view','View Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(222,'lengthclass.viewother','View Others Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(223,'lengthclass.update','Update Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(224,'lengthclass.updateother','Update Others Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(225,'lengthclass.delete','Delete Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(226,'lengthclass.deleteother','Delete Others Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(227,'lengthclass.manage','Manage Length Classes','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(228,'lengthclass.bulk-edit','Bulk Edit Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(229,'lengthclass.bulk-delete','Bulk Delete Length Class','LengthClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(230,'weightclass.create','Create Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(231,'weightclass.view','View Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(232,'weightclass.viewother','View Others Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(233,'weightclass.update','Update Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(234,'weightclass.updateother','Update Others Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(235,'weightclass.delete','Delete Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(236,'weightclass.deleteother','Delete Others Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(237,'weightclass.manage','Manage Weight Classes','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(238,'weightclass.bulk-edit','Bulk Edit Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(239,'weightclass.bulk-delete','Bulk Delete Weight Class','WeightClass','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(240,'stockstatus.create','Create Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(241,'stockstatus.view','View Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(242,'stockstatus.viewother','View Others Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(243,'stockstatus.update','Update Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(244,'stockstatus.updateother','Update Others Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(245,'stockstatus.delete','Delete Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(246,'stockstatus.deleteother','Delete Others Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(247,'stockstatus.manage','Manage Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(248,'stockstatus.bulk-edit','Bulk Edit Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(249,'stockstatus.bulk-delete','Bulk Delete Stock Status','StockStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(250,'orderstatus.create','Create Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(251,'orderstatus.view','View Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(252,'orderstatus.viewother','View Others Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(253,'orderstatus.update','Update Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(254,'orderstatus.updateother','Update Others Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(255,'orderstatus.delete','Delete Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(256,'orderstatus.deleteother','Delete Others Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(257,'orderstatus.manage','Manage Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(258,'orderstatus.bulk-edit','Bulk Edit Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(259,'orderstatus.bulk-delete','Bulk Delete Order Status','OrderStatus','localization',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(260,'access.tax','Access Tab','TaxModule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(261,'producttaxclass.create','Create Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(262,'producttaxclass.view','View Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(263,'producttaxclass.viewother','View Others Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(264,'producttaxclass.update','Update Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(265,'producttaxclass.updateother','Update Others Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(266,'producttaxclass.delete','Delete Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(267,'producttaxclass.deleteother','Delete Others Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(268,'producttaxclass.manage','Manage Product Tax Classes','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(269,'producttaxclass.bulk-edit','Bulk Edit Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(270,'producttaxclass.bulk-delete','Bulk Delete Product Tax Class','ProductTaxClass','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(271,'taxrate.create','Create Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(272,'taxrate.view','View Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(273,'taxrate.viewother','View Others Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(274,'taxrate.update','Update Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(275,'taxrate.updateother','Update Others Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(276,'taxrate.delete','Delete Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(277,'taxrate.deleteother','Delete Others Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(278,'taxrate.manage','Manage Tax Rates','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(279,'taxrate.bulk-edit','Bulk Edit Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(280,'taxrate.bulk-delete','Bulk Delete Tax Rate','TaxRate','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(281,'taxrule.create','Create Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(282,'taxrule.view','View Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(283,'taxrule.viewother','View Others Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(284,'taxrule.update','Update Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(285,'taxrule.updateother','Update Others Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(286,'taxrule.delete','Delete Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(287,'taxrule.deleteother','Delete Others Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(288,'taxrule.manage','Manage Tax Rules','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(289,'taxrule.bulk-edit','Bulk Edit Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(290,'taxrule.bulk-delete','Bulk Delete Tax Rule','TaxRule','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(291,'zone.create','Create Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(292,'zone.view','View Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(293,'zone.viewother','View Others Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(294,'zone.update','Update Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(295,'zone.updateother','Update Others Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(296,'zone.delete','Delete Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(297,'zone.deleteother','Delete Others Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(298,'zone.manage','Manage Zones','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(299,'zone.bulk-edit','Bulk Edit Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(300,'zone.bulk-delete','Bulk Delete Zone','Zone','tax',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(301,'access.auth','Access Tab','AuthModule','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(302,'auth.managepermissions','Manage Permissions','AuthModule','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(303,'group.create','Create Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(304,'group.view','View Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(305,'group.viewother','View Others Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(306,'group.update','Update Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(307,'group.updateother','Update Others Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(308,'group.delete','Delete Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(309,'group.deleteother','Delete Others Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(310,'group.manage','Manage Groups','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(311,'group.bulk-edit','Bulk Edit Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(312,'group.bulk-delete','Bulk Delete Group','Group','orderstatus',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(313,'access.manufacturer','Access Tab','ManufacturerModule','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(314,'manufacturer.create','Create Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(315,'manufacturer.view','View Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(316,'manufacturer.viewother','View Others Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(317,'manufacturer.update','Update Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(318,'manufacturer.updateother','Update Others Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(319,'manufacturer.delete','Delete Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(320,'manufacturer.deleteother','Delete Others Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(321,'manufacturer.manage','Manage Manufacturers','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(322,'manufacturer.bulk-edit','Bulk Edit Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(323,'manufacturer.bulk-delete','Bulk Delete Manufacturer','Manufacturer','manufacturer',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(324,'access.marketing','Access Tab','MarketingModule','marketing',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(325,'marketing.mail','Marketing Mails','MarketingModule','marketing',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(326,'access.newsletter','Access Tab','NewsletterModule','newsletter',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(327,'newsletter.create','Create Newsletter','Newsletter','newsletter',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(328,'newsletter.view','View Newsletter','Newsletter','newsletter',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(329,'newsletter.viewother','View Others Newsletter','Newsletter','newsletter',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(330,'newsletter.delete','Delete Newsletter','Newsletter','newsletter',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(331,'newsletter.deleteother','Delete Others Newsletter','Newsletter','newsletter',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(332,'newsletter.manage','Manage Newsletters','Newsletter','newsletter',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(333,'access.order','Access Tab','OrderModule','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(334,'order.create','Create Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(335,'order.view','View Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(336,'order.viewother','View Others Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(337,'order.update','Update Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(338,'order.updateother','Update Others Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(339,'order.delete','Delete Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(340,'order.deleteother','Delete Others Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(341,'order.manage','Manage Orders','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(342,'order.bulk-edit','Bulk Edit Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(343,'order.bulk-delete','Bulk Delete Order','Order','order',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(344,'access.sequence','Access Tab','SequenceModule','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(345,'sequence.create','Create Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(346,'sequence.view','View Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(347,'sequence.viewother','View Others Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(348,'sequence.update','Update Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(349,'sequence.updateother','Update Others Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(350,'sequence.delete','Delete Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(351,'sequence.deleteother','Delete Others Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(352,'sequence.manage','Manage Sequences','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(353,'sequence.bulk-edit','Bulk Edit Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(354,'sequence.bulk-delete','Bulk Delete Sequence','Sequence','sequence',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(355,'access.stores','Access Tab','StoresModule','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(356,'store.create','Create Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(357,'store.view','View Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(358,'store.viewother','View Others Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(359,'store.update','Update Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(360,'store.updateother','Update Others Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(361,'store.delete','Delete Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(362,'store.deleteother','Delete Others Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(363,'store.manage','Manage Stores','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00'),(364,'store.bulk-edit','Bulk Edit Store','Store','stores',1,0,'2016-10-22 07:52:07','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tbl_auth_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cash_on_delivery_transaction`
--

DROP TABLE IF EXISTS `tbl_cash_on_delivery_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cash_on_delivery_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `payment_status` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `received_date` date NOT NULL,
  `transaction_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_transaction_id` (`transaction_id`),
  KEY `idx_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cash_on_delivery_transaction`
--

LOCK TABLES `tbl_cash_on_delivery_transaction` WRITE;
/*!40000 ALTER TABLE `tbl_cash_on_delivery_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cash_on_delivery_transaction` ENABLE KEYS */;
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_country_id` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_city`
--

LOCK TABLES `tbl_city` WRITE;
/*!40000 ALTER TABLE `tbl_city` DISABLE KEYS */;
INSERT INTO `tbl_city` VALUES (1,1,1,1,'2016-10-22 07:53:30','2016-10-22 07:53:30'),(2,1,1,1,'2016-10-22 07:53:30','2016-10-22 07:53:30'),(3,1,1,1,'2016-10-22 07:53:30','2016-10-22 07:53:30'),(4,1,1,1,'2016-10-22 07:53:31','2016-10-22 07:53:31');
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
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_city_translated`
--

LOCK TABLES `tbl_city_translated` WRITE;
/*!40000 ALTER TABLE `tbl_city_translated` DISABLE KEYS */;
INSERT INTO `tbl_city_translated` VALUES (1,1,'en-US','New Delhi',1,1,'2016-10-22 07:53:30','2016-10-22 07:53:30'),(2,2,'en-US','Panaji',1,1,'2016-10-22 07:53:30','2016-10-22 07:53:30'),(3,3,'en-US','Dispur',1,1,'2016-10-22 07:53:30','2016-10-22 07:53:30'),(4,4,'en-US','Imphal',1,1,'2016-10-22 07:53:31','2016-10-22 07:53:31');
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
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_module` (`module`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_configuration`
--

LOCK TABLES `tbl_configuration` WRITE;
/*!40000 ALTER TABLE `tbl_configuration` DISABLE KEYS */;
INSERT INTO `tbl_configuration` VALUES (1,'application','dbAdminUsername','',1,1,'2016-10-22 07:52:01','2016-10-22 07:52:01'),(2,'application','dbAdminPassword','',1,1,'2016-10-22 07:52:01','2016-10-22 07:52:01'),(3,'application','siteName','Demo site',1,1,'2016-10-22 07:52:01','2016-10-22 07:52:01'),(4,'application','siteDescription','This i s demo site',1,1,'2016-10-22 07:52:01','2016-10-22 07:52:01'),(5,'application','superUsername','super',1,1,'2016-10-22 07:52:01','2016-10-22 07:52:01'),(6,'application','superEmail','rajusinghai80@gmail.com',1,1,'2016-10-22 07:52:01','2016-10-22 07:52:01'),(7,'application','superPassword','admin',1,1,'2016-10-22 07:52:01','2016-10-22 07:52:01'),(8,'application','dbHost','localhost',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(9,'application','dbPort','3306',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(10,'application','dbName','usnicartyii2',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(11,'application','dbUsername','usnicart',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(12,'application','dbPassword','abc123',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(13,'application','environment','dev',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(14,'application','frontTheme','classic',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(15,'application','demoData','1',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(16,'application','timezone','Asia/Kolkata',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(17,'application','logo','',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(18,'application','enableSchemaCache','1',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(19,'application','schemaCachingDuration','3600',1,1,'2016-10-22 07:52:02','2016-10-22 07:52:02'),(20,'application','sortOrder','a:4:{i:0;s:4:\"auth\";i:1;s:5:\"users\";i:2;s:12:\"notification\";i:3;s:7:\"service\";}',1,1,'2016-10-22 07:52:07','2016-10-22 07:52:07'),(21,'application','appRebuild','',1,1,'2016-10-22 07:52:07','2016-10-22 07:52:07'),(22,'application','metaKeywords','Demo site Keywords',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(23,'application','metaDescription','Demo site Description',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(24,'application','isRegistrationAllowed','1',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(25,'users','passwordTokenExpiry','3600',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(26,'site','containerClass','nav navbar-nav',1,1,'2016-10-22 07:53:47','2016-10-22 07:53:47');
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
  `postcode_required` smallint(1) NOT NULL,
  `status` smallint(1) NOT NULL,
  `iso_code_2` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_code_3` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_country`
--

LOCK TABLES `tbl_country` WRITE;
/*!40000 ALTER TABLE `tbl_country` DISABLE KEYS */;
INSERT INTO `tbl_country` VALUES (1,0,1,'IN','IND',1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29');
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
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_format` text COLLATE utf8_unicode_ci,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_country_translated`
--

LOCK TABLES `tbl_country_translated` WRITE;
/*!40000 ALTER TABLE `tbl_country_translated` DISABLE KEYS */;
INSERT INTO `tbl_country_translated` VALUES (1,1,'en-US','India','',1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29');
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
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol_left` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol_right` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decimal_place` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_currency` VALUES (1,1,1.00,'USD','$','','2',1,1,'2016-10-22 07:52:20','2016-10-22 07:52:20'),(2,1,0.58,'GBP','£','','2',1,1,'2016-10-22 07:52:20','2016-10-22 07:52:20');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_currency_translated`
--

LOCK TABLES `tbl_currency_translated` WRITE;
/*!40000 ALTER TABLE `tbl_currency_translated` DISABLE KEYS */;
INSERT INTO `tbl_currency_translated` VALUES (1,1,'en-US','US Dollars',1,1,'2016-10-22 07:52:20','2016-10-22 07:52:20'),(2,2,'en-US','Pound Sterling',1,1,'2016-10-22 07:52:20','2016-10-22 07:52:20');
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
  `password_reset_token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `person_id` int(11) NOT NULL,
  `login_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `timezone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_customer` VALUES (1,'Wholesalecustomer',10000,'','$2y$13$Kv51kZx9ilAJDyzBn2zPzOgHeuAK0d9DqffxBVMK4NRQFyTSPFtVe','4UWGDAls2vX5WnGUJsZdM3fQGPJ95BHB',1,4,'','0000-00-00 00:00:00','Asia/Kolkata',1,1,'2016-10-22 07:53:20','2016-10-22 07:53:20'),(2,'Retailercustomer',10001,'','$2y$13$/3v7ssy/Q76IjflL.8hbHOSyz8nJv3fxxRYVtGc6uSuHhD0UgrGCm','0_bVmVRJGxX7FjaRiFwZ5eEG0t0nFhY3',1,5,'','0000-00-00 00:00:00','Asia/Kolkata',1,1,'2016-10-22 07:53:24','2016-10-22 07:53:24'),(3,'Defaultcustomer',10002,'','$2y$13$UcEwLMWUjrk.5lada5X0VeYZOKG1PW039MSRPrE7wJHaMrrH0nEYa','-TOgMsFywpxKp20N223teJhRHBo4k_6Y',1,6,'','0000-00-00 00:00:00','Asia/Kolkata',1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29');
/*!40000 ALTER TABLE `tbl_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_metadata`
--

DROP TABLE IF EXISTS `tbl_customer_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `cart` text COLLATE utf8_unicode_ci,
  `wishlist` text COLLATE utf8_unicode_ci,
  `compareproducts` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_customer_metadata` VALUES (1,1,'a:0:{}','a:0:{}','a:0:{}','USD','en-US',1,1,'2016-10-22 07:53:21','2016-10-22 07:53:21'),(2,2,'a:0:{}','a:0:{}','a:0:{}','USD','en-US',1,1,'2016-10-22 07:53:25','2016-10-22 07:53:25'),(3,3,'a:0:{}','a:0:{}','a:0:{}','USD','en-US',1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29');
/*!40000 ALTER TABLE `tbl_customer_metadata` ENABLE KEYS */;
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_data_category`
--

LOCK TABLES `tbl_data_category` WRITE;
/*!40000 ALTER TABLE `tbl_data_category` DISABLE KEYS */;
INSERT INTO `tbl_data_category` VALUES (1,1,1,1,'2016-10-22 07:52:14','2016-10-22 07:52:14'),(2,1,1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_data_category_translated`
--

LOCK TABLES `tbl_data_category_translated` WRITE;
/*!40000 ALTER TABLE `tbl_data_category_translated` DISABLE KEYS */;
INSERT INTO `tbl_data_category_translated` VALUES (1,1,'en-US','Root Category','This is root data category for the application under which all the data would reside',1,1,'2016-10-22 07:52:15','2016-10-22 07:52:15'),(2,2,'en-US','Demo Category','This is demo data category for the application',1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_extension` VALUES (1,'payment','WhatACart','1.0','1.0.0',1,'cashondelivery',NULL,1,1,'2016-10-22 07:53:40','2016-10-22 07:53:40'),(2,'payment','WhatACart','1.0','1.0.0',1,'paypal_standard',NULL,1,1,'2016-10-22 07:53:41','2016-10-22 07:53:41'),(3,'shipping','WhatACart','1.0','s:5:\"1.0.0\";',1,'flat',NULL,1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(4,'shipping','WhatACart','1.0','s:5:\"1.0.0\";',1,'free',NULL,1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_extension_translated`
--

LOCK TABLES `tbl_extension_translated` WRITE;
/*!40000 ALTER TABLE `tbl_extension_translated` DISABLE KEYS */;
INSERT INTO `tbl_extension_translated` VALUES (1,1,'en-US','Cash On Delivery',1,1,'2016-10-22 07:53:41','2016-10-22 07:53:41'),(2,2,'en-US','Paypal Standard',1,1,'2016-10-22 07:53:41','2016-10-22 07:53:41'),(3,3,'en-US','Flat Rate',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(4,4,'en-US','Free Shipping',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44');
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
  `parent_id` int(11) NOT NULL,
  `level` int(1) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_level` (`level`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group`
--

LOCK TABLES `tbl_group` WRITE;
/*!40000 ALTER TABLE `tbl_group` DISABLE KEYS */;
INSERT INTO `tbl_group` VALUES (1,0,0,1,1,1,'2016-10-22 07:52:07','2016-10-22 07:52:07'),(2,0,0,1,1,1,'2016-10-22 07:52:07','2016-10-22 07:52:07'),(3,2,1,1,1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(4,2,1,1,1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(5,2,1,1,1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  UNIQUE KEY `idx_group_member` (`group_id`,`member_id`,`member_type`),
  KEY `idx_member_type` (`member_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group_member`
--

LOCK TABLES `tbl_group_member` WRITE;
/*!40000 ALTER TABLE `tbl_group_member` DISABLE KEYS */;
INSERT INTO `tbl_group_member` VALUES (1,3,'user',1,1,'2016-10-22 07:52:20','2016-10-22 07:52:20'),(3,3,'customer',1,1,'2016-10-22 07:53:29','2016-10-22 07:53:29'),(4,1,'customer',1,1,'2016-10-22 07:53:21','2016-10-22 07:53:21'),(5,2,'customer',1,1,'2016-10-22 07:53:25','2016-10-22 07:53:25');
/*!40000 ALTER TABLE `tbl_group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_group_translated`
--

DROP TABLE IF EXISTS `tbl_group_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_group_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group_translated`
--

LOCK TABLES `tbl_group_translated` WRITE;
/*!40000 ALTER TABLE `tbl_group_translated` DISABLE KEYS */;
INSERT INTO `tbl_group_translated` VALUES (1,1,'en-US','Administrators',1,1,'2016-10-22 07:52:07','2016-10-22 07:52:07'),(2,2,'en-US','Customer',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(3,3,'en-US','Default',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(4,4,'en-US','Wholesale',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08'),(5,5,'en-US','Retailer',1,1,'2016-10-22 07:52:08','2016-10-22 07:52:08');
/*!40000 ALTER TABLE `tbl_group_translated` ENABLE KEYS */;
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_unique_id` (`unique_id`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
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
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` smallint(3) DEFAULT NULL,
  `status` smallint(1) DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_language` VALUES (1,'English','en-US','',1,1,'en-US',1,1,'2016-10-22 07:52:07','2016-10-22 07:52:07');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unit` (`unit`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_length_class`
--

LOCK TABLES `tbl_length_class` WRITE;
/*!40000 ALTER TABLE `tbl_length_class` DISABLE KEYS */;
INSERT INTO `tbl_length_class` VALUES (1,'m',1.00,1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(2,'cm',100.00,1,1,'2016-10-22 07:52:22','2016-10-22 07:52:22'),(3,'in',39.37,1,1,'2016-10-22 07:52:22','2016-10-22 07:52:22'),(4,'mm',1000.00,1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23');
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
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_length_class_translated`
--

LOCK TABLES `tbl_length_class_translated` WRITE;
/*!40000 ALTER TABLE `tbl_length_class_translated` DISABLE KEYS */;
INSERT INTO `tbl_length_class_translated` VALUES (1,1,'en-US','Meter',1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(2,2,'en-US','Centimeter',1,1,'2016-10-22 07:52:22','2016-10-22 07:52:22'),(3,3,'en-US','Inch',1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23'),(4,4,'en-US','Millimeter',1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_manufacturer`
--

LOCK TABLES `tbl_manufacturer` WRITE;
/*!40000 ALTER TABLE `tbl_manufacturer` DISABLE KEYS */;
INSERT INTO `tbl_manufacturer` VALUES (1,'Apple',NULL,1,1,1,'2016-10-22 07:52:16','2016-10-22 07:52:16'),(2,'Canon',NULL,1,1,1,'2016-10-22 07:52:16','2016-10-22 07:52:16'),(3,'HTC',NULL,1,1,1,'2016-10-22 07:52:16','2016-10-22 07:52:16'),(4,'Sony',NULL,1,1,1,'2016-10-22 07:52:16','2016-10-22 07:52:16');
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
  `store_id` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `subject` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
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
  `status` smallint(6) NOT NULL DEFAULT '1',
  `priority` smallint(6) NOT NULL DEFAULT '1',
  `senddatetime` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_modulename` (`modulename`),
  KEY `idx_type` (`type`),
  KEY `idx_status` (`status`),
  KEY `idx_priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification`
--

LOCK TABLES `tbl_notification` WRITE;
/*!40000 ALTER TABLE `tbl_notification` DISABLE KEYS */;
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
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
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
-- Table structure for table `tbl_notification_logs`
--

DROP TABLE IF EXISTS `tbl_notification_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_notification_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `notification_id` int(11) NOT NULL,
  `senddatetime` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_notification_id` (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification_logs`
--

LOCK TABLES `tbl_notification_logs` WRITE;
/*!40000 ALTER TABLE `tbl_notification_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_notification_logs` ENABLE KEYS */;
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
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_notification_template` VALUES (1,'email','createUser',NULL,1,1,1,'2016-10-22 07:52:09','2016-10-22 07:52:09'),(2,'email','changepassword',NULL,1,1,1,'2016-10-22 07:52:09','2016-10-22 07:52:09'),(3,'email','forgotpassword',NULL,1,1,1,'2016-10-22 07:52:10','2016-10-22 07:52:10'),(4,'email','productReview',NULL,1,1,1,'2016-10-22 07:53:13','2016-10-22 07:53:13'),(5,'email','createCustomer',NULL,1,1,1,'2016-10-22 07:53:15','2016-10-22 07:53:15'),(6,'email','sendMail',NULL,1,1,1,'2016-10-22 07:53:38','2016-10-22 07:53:38'),(7,'email','sendNewsletter',NULL,1,1,1,'2016-10-22 07:53:39','2016-10-22 07:53:39'),(8,'email','orderCompletion',NULL,1,1,1,'2016-10-22 07:53:40','2016-10-22 07:53:40'),(9,'email','orderReceived',NULL,1,1,1,'2016-10-22 07:53:40','2016-10-22 07:53:40'),(10,'email','orderUpdate',NULL,1,1,1,'2016-10-22 07:53:40','2016-10-22 07:53:40');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_subject` (`subject`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_notification_template_translated`
--

LOCK TABLES `tbl_notification_template_translated` WRITE;
/*!40000 ALTER TABLE `tbl_notification_template_translated` DISABLE KEYS */;
INSERT INTO `tbl_notification_template_translated` VALUES (1,1,'en-US','New User Registration','<p>Welcome {{fullName}}. Your account has been created successully at {{appname}}</p>\r\n\r\n<p>Your login details are as below<br /><br/>\r\n    <strong>Username:</strong> {{username}}<br />\r\n    <strong>Password</strong>: {{password}}</p>\r\n\r\n{{confirmemailLabel}}\r\n{{confirmemail}}\r\n\r\nThanks,<br />\r\nSystem Admin\r\n\r\n',1,1,'2016-10-22 07:52:09','2016-10-22 07:52:09'),(2,2,'en-US','You have changed your password.','<p>Dear {{fullName}}, your password has been changed to {{password}}</p><br/>\r\nThanks<br />\r\nSystem Admin\r\n\r\n',1,1,'2016-10-22 07:52:10','2016-10-22 07:52:10'),(3,3,'en-US','Forgot Password Request','<p>Dear {{fullName}},<br/> \r\n<br/>\r\n    Your login details are as below<br />\r\n    <strong>Username:</strong> {{username}}<br />\r\n    <strong>Password</strong>: {{password}}\r\n</p><br/>\r\nThanks<br />\r\nSystem Admin\r\n\r\n',1,1,'2016-10-22 07:52:10','2016-10-22 07:52:10'),(4,4,'en-US','Product Review | {{productName}}','<p>\r\n    Hello,<br/>\r\n    {{customername}} has posted a new review on {{productname}}.\r\n</p>\r\n<p>\r\n    The review is:<br/>\r\n    {{review}}<br/><br/>\r\n    Thanks,<br />\r\n    System Admin\r\n</p>',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14'),(5,5,'en-US','New Customer Registration','<p>Welcome {{fullName}}. Your account has been created successully at {{appname}}</p>\r\n\r\n<p>Your login details are as below<br /><br/>\r\n    <strong>Username:</strong> {{username}}<br />\r\n    <strong>Password</strong>: {{password}}</p>\r\n\r\n{{confirmemailLabel}}\r\n{{confirmemail}}\r\n\r\nThanks,<br />\r\nSystem Admin\r\n\r\n',1,1,'2016-10-22 07:53:15','2016-10-22 07:53:15'),(6,6,'en-US','Send Mail','<h1>{{appname}}</h1>\r\n<p>\r\n    <strong>From:</strong> {{storename}}<br />\r\n    <strong>Subject:</strong>: {{subject}}<br />\r\n    <strong>Message:</strong>: {{message}}\r\n</p>',1,1,'2016-10-22 07:53:39','2016-10-22 07:53:39'),(7,7,'en-US','Newsletter','<h1>{{appname}}</h1>\r\n<p>\r\n    <strong>From:</strong> {{storename}}<br />\r\n    <strong>Subject:</strong>: {{subject}}<br />\r\n    <strong>Message:</strong>: {{message}}\r\n</p>\r\n{{unsubscribe}}',1,1,'2016-10-22 07:53:39','2016-10-22 07:53:39'),(8,8,'en-US','Order Completion','<p>Dear, {{customername}}</p>\r\n<p>\r\n    Your order #{{ordernumber}} processing is completed on {{orderdate}}.\r\n</p>\r\n{{orderLink}}\r\n<p>\r\n    Thank You, <br/> \r\n    System Admin\r\n</p>',1,1,'2016-10-22 07:53:40','2016-10-22 07:53:40'),(9,9,'en-US','Received Order','<div style=\"width: 680px;\">\r\n  <p style=\"margin-top: 0px; margin-bottom: 20px;\">Thank you for your interest in {{storeName}} products. Your order has been received and will be processed once payment has been confirmed.</p>\r\n  {{orderLink}}\r\n  <table style=\"border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;\">\r\n    <thead>\r\n      <tr>\r\n        <td style=\"font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;\" colspan=\"2\">\r\n            Order Details\r\n        </td>\r\n      </tr>\r\n    </thead>\r\n    <tbody>\r\n      <tr>\r\n        <td style=\"font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;\">\r\n          <b>Order ID:</b> {{orderId}}<br />\r\n          <b>Date of Order:</b> {{dateAdded}}<br />\r\n          <b>Payment Method:</b> {{paymentMethod}}<br />\r\n          {{shippingMethod}}\r\n          </td>\r\n        <td style=\"font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;\">\r\n          <b>Email:</b> {{email}}<br />\r\n          <b>Telephone:</b> {{telephone}}<br />\r\n          <b>Status:</b> {{orderStatus}}<br />\r\n        </td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n  <table style=\"border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;\">\r\n    <thead>\r\n      <tr>\r\n        <td style=\"font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;\">\r\n            Billing Address\r\n        </td>\r\n        {{shippingAddressTitle}}\r\n      </tr>\r\n    </thead>\r\n    <tbody>\r\n      <tr>\r\n        <td style=\"font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;\">\r\n            {{paymentAddress}}\r\n        </td>\r\n        {{shippingAddress}}\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n  {{orderProducts}}\r\n  <p style=\"margin-top: 0px; margin-bottom: 20px;\">Please reply to this e-mail if you have any questions.</p>\r\n  <p>\r\n      Thanks,<br/>\r\n      System Admin\r\n  </p>\r\n</div>',1,1,'2016-10-22 07:53:40','2016-10-22 07:53:40'),(10,10,'en-US','Update Order | {{ordernumber}}','<p>Dear {{customername}},</p>\r\n<p>\r\n    Your order #{{ordernumber}} status ordered on {{orderdate}} has been updated to {{orderstatus}}.\r\n</p>\r\n{{orderLink}}\r\n<p>\r\n    The comments for the order are:<br/>\r\n    {{ordercomments}}\r\n</p>\r\n<p>\r\n    Thank You, <br/> \r\n    System Admin\r\n</p>',1,1,'2016-10-22 07:53:40','2016-10-22 07:53:40');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_firstname` (`firstname`),
  KEY `idx_lastname` (`lastname`),
  KEY `idx_city` (`city`),
  KEY `idx_country` (`country`),
  KEY `idx_postal_code` (`postal_code`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_status` (`status`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_payment_method` (`payment_method`),
  KEY `idx_payment_type` (`payment_type`),
  KEY `idx_total_including_tax` (`total_including_tax`),
  KEY `idx_tax` (`tax`),
  KEY `idx_shipping_fee` (`shipping_fee`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_amount` (`amount`),
  KEY `idx_payment_method` (`payment_method`),
  KEY `idx_transaction_record_id` (`transaction_record_id`)
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
  `item_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `options_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `reward` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_status`
--

LOCK TABLES `tbl_order_status` WRITE;
/*!40000 ALTER TABLE `tbl_order_status` DISABLE KEYS */;
INSERT INTO `tbl_order_status` VALUES (1,1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23'),(2,1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23'),(3,1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23'),(4,1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(5,1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(6,1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(7,1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(8,1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(9,1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(10,1,1,'2016-10-22 07:52:25','2016-10-22 07:52:25'),(11,1,1,'2016-10-22 07:52:25','2016-10-22 07:52:25'),(12,1,1,'2016-10-22 07:52:25','2016-10-22 07:52:25'),(13,1,1,'2016-10-22 07:52:26','2016-10-22 07:52:26'),(14,1,1,'2016-10-22 07:52:26','2016-10-22 07:52:26');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_status_translated`
--

LOCK TABLES `tbl_order_status_translated` WRITE;
/*!40000 ALTER TABLE `tbl_order_status_translated` DISABLE KEYS */;
INSERT INTO `tbl_order_status_translated` VALUES (1,1,'en-US','Cancelled',1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23'),(2,2,'en-US','Cancelled Reversal',1,1,'2016-10-22 07:52:23','2016-10-22 07:52:23'),(3,3,'en-US','Chargeback',1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(4,4,'en-US','Completed',1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(5,5,'en-US','Denied',1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(6,6,'en-US','Expired',1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(7,7,'en-US','Failed',1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(8,8,'en-US','Pending',1,1,'2016-10-22 07:52:24','2016-10-22 07:52:24'),(9,9,'en-US','Processed',1,1,'2016-10-22 07:52:25','2016-10-22 07:52:25'),(10,10,'en-US','Processing',1,1,'2016-10-22 07:52:25','2016-10-22 07:52:25'),(11,11,'en-US','Refunded',1,1,'2016-10-22 07:52:25','2016-10-22 07:52:25'),(12,12,'en-US','Reversed',1,1,'2016-10-22 07:52:25','2016-10-22 07:52:25'),(13,13,'en-US','Shipped',1,1,'2016-10-22 07:52:26','2016-10-22 07:52:26'),(14,14,'en-US','Voided',1,1,'2016-10-22 07:52:26','2016-10-22 07:52:26');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
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
  `parent_id` int(11) NOT NULL,
  `custom_url` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `theme` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_theme` (`theme`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_page`
--

LOCK TABLES `tbl_page` WRITE;
/*!40000 ALTER TABLE `tbl_page` DISABLE KEYS */;
INSERT INTO `tbl_page` VALUES (1,1,0,NULL,'classic',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14'),(2,1,0,NULL,'classic',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14'),(3,1,0,NULL,'classic',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14'),(4,1,0,NULL,'classic',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_alias` (`alias`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_page_translated`
--

LOCK TABLES `tbl_page_translated` WRITE;
/*!40000 ALTER TABLE `tbl_page_translated` DISABLE KEYS */;
INSERT INTO `tbl_page_translated` VALUES (1,1,'en-US','About Us','about-us','About Us','<p>\r\n    <strong class=\"first-paragraph\">A</strong>t Usha Informatique, Web Development Company in India, we are driven by SPEED and EFFICIENCY to achieve superior quality and cost-competitiveness so as to enable our customer&rsquo;s stay at the forefront of their industry.</p><p>At Usha Informatique, you can find a right combination of Technical excellence, outstanding design, effective strategy and the results are pretty impressive, to serve clients acroos the globe. We utilizes both continued technical and intellectual education to enhance each project that is brought to Usha Informatique that stands our clients into the world of technology with class.</p><p>Our knowledge and experience in Software and Web solutions have greatly boosted our clients in business augmentation. We specialize in delivering cost-effective software/web solutions by implementing an offshore development model. We have a dedicated team of software professionals to bring quality products to the clients.\r\n</p>\r\n\r\n','About us summary','about us','about us description',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14'),(2,2,'en-US','Delivery Information','delivery-info','Delivery Information','<p>This is delivery information</p>','Delivery information summary','delivery information','deliverr information description',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14'),(3,3,'en-US','Privacy Policy','privacy-policy','Privacy Policy','<p>This is privacy policy</p>','Privacy policy summary','privacy policy','privacy policy description',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14'),(4,4,'en-US','Terms & Conditions','terms','Terms & Conditions','<p>These are terms and conditions</p>','Terms & condition summary','terms & condition','terms & condition description',1,1,'2016-10-22 07:53:14','2016-10-22 07:53:14');
/*!40000 ALTER TABLE `tbl_page_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_paypal_standard_transaction`
--

DROP TABLE IF EXISTS `tbl_paypal_standard_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paypal_standard_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `payment_status` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `received_date` date NOT NULL,
  `transaction_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_transaction_id` (`transaction_id`),
  KEY `idx_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_paypal_standard_transaction`
--

LOCK TABLES `tbl_paypal_standard_transaction` WRITE;
/*!40000 ALTER TABLE `tbl_paypal_standard_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_paypal_standard_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_person`
--

DROP TABLE IF EXISTS `tbl_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mobilephone` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `officephone` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `officefax` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_person`
--

LOCK TABLES `tbl_person` WRITE;
/*!40000 ALTER TABLE `tbl_person` DISABLE KEYS */;
INSERT INTO `tbl_person` VALUES (1,'Super','Admin','',NULL,NULL,'rajusinghai80@gmail.com',NULL,NULL,1,1,'2016-10-22 07:52:04','2016-10-22 07:52:04'),(2,'demo','user',NULL,NULL,NULL,'demo@usnicart.com',NULL,NULL,1,1,'2016-10-22 07:52:12','2016-10-22 07:52:12'),(3,'Store','Owner',NULL,NULL,NULL,'mayank@mayankstore.com',NULL,NULL,1,1,'2016-10-22 07:52:18','2016-10-22 07:52:18'),(4,'Wholesalecustomer','Wholesalecustomerlast',NULL,NULL,NULL,'Wholesalecustomer@whatacart.com',NULL,NULL,1,1,'2016-10-22 07:53:19','2016-10-22 07:53:19'),(5,'Retailercustomer','Retailercustomerlast',NULL,NULL,NULL,'Retailercustomer@whatacart.com',NULL,NULL,1,1,'2016-10-22 07:53:23','2016-10-22 07:53:23'),(6,'Defaultcustomer','Defaultcustomerlast',NULL,NULL,NULL,'Defaultcustomer@whatacart.com',NULL,NULL,1,1,'2016-10-22 07:53:27','2016-10-22 07:53:27');
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
  `model` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `sku` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `initial_quantity` int(11) NOT NULL,
  `tax_class_id` int(11) NOT NULL,
  `minimum_quantity` int(11) DEFAULT NULL,
  `subtract_stock` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock_status` smallint(1) NOT NULL,
  `requires_shipping` smallint(1) NOT NULL,
  `available_date` date DEFAULT NULL,
  `manufacturer` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_featured` smallint(1) DEFAULT NULL,
  `location` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `length` int(16) DEFAULT NULL,
  `width` int(16) DEFAULT NULL,
  `height` int(16) DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `length_class` int(16) DEFAULT NULL,
  `weight_class` int(16) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
  KEY `idx_initial_quantity` (`initial_quantity`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product`
--

LOCK TABLES `tbl_product` WRITE;
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` VALUES (1,'Apple Cinema 20\" Model',10.00,10.00,'YWY2MmIyNTapple_cinema_display1.jpg',1,'Apple Cinema 20\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:43','2016-10-22 07:52:43'),(2,'Apple Cinema 21\" Model',20.00,20.00,'N2EzNWZmMGapple_cinema_display10.jpg',1,'Apple Cinema 21\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:45','2016-10-22 07:52:45'),(3,'Apple Cinema 22\" Model',30.00,30.00,'NmQ0MmExZDapple_cinema_display2.jpg',1,'Apple Cinema 22\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:46','2016-10-22 07:52:46'),(4,'Apple Cinema 23\" Model',40.00,40.00,'MzM3MmNmOTapple_cinema_display3.jpg',1,'Apple Cinema 23\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:46','2016-10-22 07:52:46'),(5,'Apple Cinema 24\" Model',50.00,50.00,'MzhmOWY1Mjapple_cinema_display4.png',1,'Apple Cinema 24\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:47','2016-10-22 07:52:47'),(6,'Apple Cinema 25\" Model',60.00,60.00,'MmNiNWQ4NTapple_cinema_display5.jpg',1,'Apple Cinema 25\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:48','2016-10-22 07:52:48'),(7,'Apple Cinema 26\" Model',70.00,70.00,'ZGNhY2VhOWapple_cinema_display6.png',1,'Apple Cinema 26\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:48','2016-10-22 07:52:48'),(8,'Apple Cinema 27\" Model',80.00,80.00,'MWJiYzU0Ymapple_cinema_display7.png',1,'Apple Cinema 27\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:49','2016-10-22 07:52:49'),(9,'Apple Cinema 28\" Model',90.00,90.00,'MmU0YTk1NTapple_cinema_display8.jpg',1,'Apple Cinema 28\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:50','2016-10-22 07:52:50'),(10,'Apple Cinema 29\" Model',100.00,100.00,'NjdlMjIxYzapple_cinema_display9.jpg',1,'Apple Cinema 29\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(11,'Apple Cinema 30\" Model',110.00,110.00,'NGU1ZTE5Nzog-image.jpg',1,'Apple Cinema 30\"',10,10,1,1,'1',1,1,NULL,'1',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(12,'Canon EOS 5D Model',10.00,10.00,'YTdmNDgzMWCanon-EOS-5DS3.jpg',1,'Canon EOS 5D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(13,'Canon EOS 5 S Model',20.00,20.00,'N2QxODc4NWCanon-EOS-5LX1.jpeg',1,'Canon EOS 5 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(14,'Canon EOS 5 LX Model',30.00,30.00,'ZTY4ZTVhNzCanon-EOS-6D4.jpg',1,'Canon EOS 5 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:52','2016-10-22 07:52:52'),(15,'Canon EOS 6D Model',40.00,40.00,'MTRmY2U5ZGCanon-EOS-6LX1.jpeg',1,'Canon EOS 6D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:52','2016-10-22 07:52:52'),(16,'Canon EOS 6 S Model',50.00,50.00,'MmQ2NmJlYjCanon_EOS_5D1.jpg',1,'Canon EOS 6 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(17,'Canon EOS 6 LX Model',60.00,60.00,'MTY3OTA0NTCanon_EOS_5D2.jpg',1,'Canon EOS 6 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(18,'Canon EOS 7D Model',70.00,70.00,'YTdmNDgzMWCanon-EOS-5DS3.jpg',1,'Canon EOS 7D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(19,'Canon EOS 7 S Model',80.00,80.00,'N2QxODc4NWCanon-EOS-5LX1.jpeg',1,'Canon EOS 7 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(20,'Canon EOS 7 LX Model',90.00,90.00,'ZTY4ZTVhNzCanon-EOS-6D4.jpg',1,'Canon EOS 7 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(21,'Canon EOS 8D Model',100.00,100.00,'MTRmY2U5ZGCanon-EOS-6LX1.jpeg',1,'Canon EOS 8D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(22,'Canon EOS 8 S Model',110.00,110.00,'MmQ2NmJlYjCanon_EOS_5D1.jpg',1,'Canon EOS 8 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:55','2016-10-22 07:52:55'),(23,'Canon EOS 8 LX Model',120.00,120.00,'MTY3OTA0NTCanon_EOS_5D2.jpg',1,'Canon EOS 8 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:55','2016-10-22 07:52:55'),(24,'Canon EOS 9D Model',130.00,130.00,'YTdmNDgzMWCanon-EOS-5DS3.jpg',1,'Canon EOS 9D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(25,'Canon EOS 9 S Model',140.00,140.00,'N2QxODc4NWCanon-EOS-5LX1.jpeg',1,'Canon EOS 9 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(26,'Canon EOS 9 LX Model',150.00,150.00,'ZTY4ZTVhNzCanon-EOS-6D4.jpg',1,'Canon EOS 9 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(27,'Canon EOS 10D Model',160.00,160.00,'MTRmY2U5ZGCanon-EOS-6LX1.jpeg',1,'Canon EOS 10D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(28,'Canon EOS 10 S Model',170.00,170.00,'MmQ2NmJlYjCanon_EOS_5D1.jpg',1,'Canon EOS 10 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(29,'Canon EOS 10 LX Model',180.00,180.00,'MTY3OTA0NTCanon_EOS_5D2.jpg',1,'Canon EOS 10 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(30,'Canon EOS 11D Model',190.00,190.00,'YTdmNDgzMWCanon-EOS-5DS3.jpg',1,'Canon EOS 11D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:58','2016-10-22 07:52:58'),(31,'Canon EOS 11 S Model',200.00,200.00,'N2QxODc4NWCanon-EOS-5LX1.jpeg',1,'Canon EOS 11 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:58','2016-10-22 07:52:58'),(32,'Canon EOS 11 LX Model',210.00,210.00,'ZTY4ZTVhNzCanon-EOS-6D4.jpg',1,'Canon EOS 11 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(33,'Canon EOS 12D Model',220.00,220.00,'MTRmY2U5ZGCanon-EOS-6LX1.jpeg',1,'Canon EOS 12D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(34,'Canon EOS 12 S Model',230.00,230.00,'MmQ2NmJlYjCanon_EOS_5D1.jpg',1,'Canon EOS 12 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(35,'Canon EOS 12 LX Model',240.00,240.00,'MTY3OTA0NTCanon_EOS_5D2.jpg',1,'Canon EOS 12 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:00','2016-10-22 07:53:00'),(36,'Canon EOS 13D Model',250.00,250.00,'YTdmNDgzMWCanon-EOS-5DS3.jpg',1,'Canon EOS 13D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:01','2016-10-22 07:53:01'),(37,'Canon EOS 13 S Model',260.00,260.00,'N2QxODc4NWCanon-EOS-5LX1.jpeg',1,'Canon EOS 13 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:01','2016-10-22 07:53:01'),(38,'Canon EOS 13 LX Model',270.00,270.00,'ZTY4ZTVhNzCanon-EOS-6D4.jpg',1,'Canon EOS 13 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:02','2016-10-22 07:53:02'),(39,'Canon EOS 14D Model',280.00,280.00,'MTRmY2U5ZGCanon-EOS-6LX1.jpeg',1,'Canon EOS 14D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:02','2016-10-22 07:53:02'),(40,'Canon EOS 14 S Model',290.00,290.00,'MmQ2NmJlYjCanon_EOS_5D1.jpg',1,'Canon EOS 14 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(41,'Canon EOS 14 LX Model',300.00,300.00,'MTY3OTA0NTCanon_EOS_5D2.jpg',1,'Canon EOS 14 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(42,'Canon EOS 15D Model',310.00,310.00,'YTdmNDgzMWCanon-EOS-5DS3.jpg',1,'Canon EOS 15D',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(43,'Canon EOS 15 S Model',320.00,320.00,'N2QxODc4NWCanon-EOS-5LX1.jpeg',1,'Canon EOS 15 S',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(44,'Canon EOS 15 LX Model',330.00,330.00,'ZTY4ZTVhNzCanon-EOS-6D4.jpg',1,'Canon EOS 15 LX',10,10,1,1,'1',1,1,NULL,'2',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(45,'Sony Vaio 20\" Model',10.00,10.00,'ZmFmZWI5ZWsony-vaio-eb-2011q1-black-hero-lg.jpg',1,'Sony Vaio 20\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(46,'Sony Vaio 21\" Model',20.00,20.00,'ZDAzNTc1NTsony-vaio-laptop-s13126-black-with-laptop-bag.jpg',1,'Sony Vaio 21\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:05','2016-10-22 07:53:05'),(47,'Sony Vaio 22\" Model',30.00,30.00,'Mjg1MmFiOGsony-vaio-laptop-shop-in-jaipur.jpg',1,'Sony Vaio 22\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:05','2016-10-22 07:53:05'),(48,'Sony Vaio 23\" Model',40.00,40.00,'YWFiZGQwNjsony-vaio-new-210114.jpg',1,'Sony Vaio 23\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(49,'Sony Vaio 24\" Model',50.00,50.00,'ZmFmZWI5ZWsony-vaio-eb-2011q1-black-hero-lg.jpg',1,'Sony Vaio 24\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(50,'Sony Vaio 25\" Model',60.00,60.00,'ZDAzNTc1NTsony-vaio-laptop-s13126-black-with-laptop-bag.jpg',1,'Sony Vaio 25\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(51,'Sony Vaio 26\" Model',70.00,70.00,'Mjg1MmFiOGsony-vaio-laptop-shop-in-jaipur.jpg',1,'Sony Vaio 26\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(52,'Sony Vaio 27\" Model',80.00,80.00,'YWFiZGQwNjsony-vaio-new-210114.jpg',1,'Sony Vaio 27\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(53,'Sony Vaio 28\" Model',90.00,90.00,'ZmFmZWI5ZWsony-vaio-eb-2011q1-black-hero-lg.jpg',1,'Sony Vaio 28\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(54,'Sony Vaio 29\" Model',100.00,100.00,'ZDAzNTc1NTsony-vaio-laptop-s13126-black-with-laptop-bag.jpg',1,'Sony Vaio 29\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:08','2016-10-22 07:53:08'),(55,'Sony Vaio 30\" Model',110.00,110.00,'Mjg1MmFiOGsony-vaio-laptop-shop-in-jaipur.jpg',1,'Sony Vaio 30\"',10,10,1,1,'1',1,1,NULL,'4',1,NULL,1,2,3,'2016-10-22',10.00,2,2,1,1,'2016-10-22 07:53:08','2016-10-22 07:53:08');
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
  `attribute_group` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_product_attribute` VALUES (1,1,1,1,1,'2016-10-22 07:52:28','2016-10-22 07:52:28'),(2,1,1,1,1,'2016-10-22 07:52:28','2016-10-22 07:52:28');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_group`
--

LOCK TABLES `tbl_product_attribute_group` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_group` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_group` VALUES (1,1,1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(2,2,1,1,'2016-10-22 07:52:28','2016-10-22 07:52:28');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_group_translated`
--

LOCK TABLES `tbl_product_attribute_group_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_group_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_group_translated` VALUES (1,1,'en-US','Memory',1,1,'2016-10-22 07:52:28','2016-10-22 07:52:28'),(2,2,'en-US','Motherboard',1,1,'2016-10-22 07:52:28','2016-10-22 07:52:28');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_attribute_id` (`attribute_id`),
  KEY `idx_attribute_value` (`attribute_value`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_mapping`
--

LOCK TABLES `tbl_product_attribute_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_mapping` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_mapping` VALUES (1,1,2,'300 RPM',1,1,'2016-10-22 07:53:12','2016-10-22 07:53:12');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_attribute_translated`
--

LOCK TABLES `tbl_product_attribute_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_attribute_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_attribute_translated` VALUES (1,1,'en-US','Clockspeed',1,1,'2016-10-22 07:52:28','2016-10-22 07:52:28'),(2,2,'en-US','Fan Speed',1,1,'2016-10-22 07:52:29','2016-10-22 07:52:29');
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
  `parent_id` int(11) NOT NULL,
  `level` int(2) DEFAULT NULL,
  `status` smallint(1) NOT NULL,
  `displayintopmenu` smallint(1) DEFAULT NULL,
  `data_category_id` int(11) NOT NULL,
  `code` varchar(164) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_product_category` VALUES (1,'NTcyODRlZmdesktop_category.jpg',0,0,1,1,1,'DT',1,1,'2016-10-22 07:52:15','2016-10-22 07:52:15'),(2,'NTRhMGY1ODlaptop_category.jpg',0,0,1,1,1,'LTNB',1,1,'2016-10-22 07:52:15','2016-10-22 07:52:15'),(3,'NTc4MmI1Ymcamera_category.jpg',0,0,1,1,1,'CM',1,1,'2016-10-22 07:52:15','2016-10-22 07:52:15');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_data_category_id` (`data_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_category_mapping`
--

LOCK TABLES `tbl_product_category_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_category_mapping` DISABLE KEYS */;
INSERT INTO `tbl_product_category_mapping` VALUES (1,1,1,1,1,'2016-10-22 07:52:45','2016-10-22 07:52:45'),(2,1,1,1,1,'2016-10-22 07:52:46','2016-10-22 07:52:46'),(3,1,1,1,1,'2016-10-22 07:52:46','2016-10-22 07:52:46'),(4,1,1,1,1,'2016-10-22 07:52:47','2016-10-22 07:52:47'),(5,1,1,1,1,'2016-10-22 07:52:48','2016-10-22 07:52:48'),(6,1,1,1,1,'2016-10-22 07:52:48','2016-10-22 07:52:48'),(7,1,1,1,1,'2016-10-22 07:52:48','2016-10-22 07:52:48'),(8,1,1,1,1,'2016-10-22 07:52:50','2016-10-22 07:52:50'),(9,1,1,1,1,'2016-10-22 07:52:50','2016-10-22 07:52:50'),(10,1,1,1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(11,1,1,1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(12,3,1,1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(13,3,1,1,1,'2016-10-22 07:52:52','2016-10-22 07:52:52'),(14,3,1,1,1,'2016-10-22 07:52:52','2016-10-22 07:52:52'),(15,3,1,1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(16,3,1,1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(17,3,1,1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(18,3,1,1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(19,3,1,1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(20,3,1,1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(21,3,1,1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(22,3,1,1,1,'2016-10-22 07:52:55','2016-10-22 07:52:55'),(23,3,1,1,1,'2016-10-22 07:52:55','2016-10-22 07:52:55'),(24,3,1,1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(25,3,1,1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(26,3,1,1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(27,3,1,1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(28,3,1,1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(29,3,1,1,1,'2016-10-22 07:52:58','2016-10-22 07:52:58'),(30,3,1,1,1,'2016-10-22 07:52:58','2016-10-22 07:52:58'),(31,3,1,1,1,'2016-10-22 07:52:58','2016-10-22 07:52:58'),(32,3,1,1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(33,3,1,1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(34,3,1,1,1,'2016-10-22 07:53:00','2016-10-22 07:53:00'),(35,3,1,1,1,'2016-10-22 07:53:00','2016-10-22 07:53:00'),(36,3,1,1,1,'2016-10-22 07:53:01','2016-10-22 07:53:01'),(37,3,1,1,1,'2016-10-22 07:53:02','2016-10-22 07:53:02'),(38,3,1,1,1,'2016-10-22 07:53:02','2016-10-22 07:53:02'),(39,3,1,1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(40,3,1,1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(41,3,1,1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(42,3,1,1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(43,3,1,1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(44,3,1,1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(45,2,1,1,1,'2016-10-22 07:53:05','2016-10-22 07:53:05'),(46,2,1,1,1,'2016-10-22 07:53:05','2016-10-22 07:53:05'),(47,2,1,1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(48,2,1,1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(49,2,1,1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(50,2,1,1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(51,2,1,1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(52,2,1,1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(53,2,1,1,1,'2016-10-22 07:53:08','2016-10-22 07:53:08'),(54,2,1,1,1,'2016-10-22 07:53:08','2016-10-22 07:53:08'),(55,2,1,1,1,'2016-10-22 07:53:08','2016-10-22 07:53:08');
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
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `metakeywords` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `metadescription` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  KEY `idx_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_category_translated`
--

LOCK TABLES `tbl_product_category_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_category_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_category_translated` VALUES (1,1,'en-US','Desktops','desktops',NULL,NULL,'Shop Desktop feature only the best desktop deals on the market',1,1,'2016-10-22 07:52:15','2016-10-22 07:52:15'),(2,2,'en-US','Laptops & Notebooks','laptops-notebook',NULL,NULL,'Shop Laptop feature only the best laptop deals on the market',1,1,'2016-10-22 07:52:15','2016-10-22 07:52:15'),(3,3,'en-US','Camera','camera',NULL,NULL,'Shop Camera feature only the best laptop deals on the market',1,1,'2016-10-22 07:52:15','2016-10-22 07:52:15');
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
  `quantity` int(10) DEFAULT NULL,
  `priority` int(2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_group_id` (`group_id`),
  KEY `idx_quantity` (`quantity`),
  KEY `idx_priority` (`priority`),
  KEY `idx_price` (`price`),
  KEY `idx_start_datetime` (`start_datetime`),
  KEY `idx_end_datetime` (`end_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_discount`
--

LOCK TABLES `tbl_product_discount` WRITE;
/*!40000 ALTER TABLE `tbl_product_discount` DISABLE KEYS */;
INSERT INTO `tbl_product_discount` VALUES (1,4,2,1,1.00,'2016-10-25 07:53:09','2016-10-29 07:53:09',1,1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09'),(2,5,5,2,2.00,'2016-10-25 07:53:09','2016-10-29 07:53:09',1,1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09');
/*!40000 ALTER TABLE `tbl_product_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_image`
--

DROP TABLE IF EXISTS `tbl_product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`)
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
  `caption` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_caption` (`caption`)
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
  `sort_order` int(11) DEFAULT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option`
--

LOCK TABLES `tbl_product_option` WRITE;
/*!40000 ALTER TABLE `tbl_product_option` DISABLE KEYS */;
INSERT INTO `tbl_product_option` VALUES (1,1,'checkbox','http://xyz.com',1,1,'2016-10-22 07:52:29','2016-10-22 07:52:29'),(2,2,'radio','http://xyz.com',1,1,'2016-10-22 07:52:29','2016-10-22 07:52:29'),(3,3,'select','http://xyz.com',1,1,'2016-10-22 07:52:30','2016-10-22 07:52:30');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_option_id` (`option_id`),
  KEY `idx_required` (`required`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_mapping`
--

LOCK TABLES `tbl_product_option_mapping` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_mapping` DISABLE KEYS */;
INSERT INTO `tbl_product_option_mapping` VALUES (1,1,1,1,1,1,'2016-10-22 07:53:11','2016-10-22 07:53:11'),(2,45,2,1,1,1,'2016-10-22 07:53:11','2016-10-22 07:53:11'),(3,12,3,1,1,1,'2016-10-22 07:53:12','2016-10-22 07:53:12');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_product_option_mapping_details` VALUES (1,1,'1',1,1,'+',5.00,'+',0.00,1,1,'2016-10-22 07:53:11','2016-10-22 07:53:11'),(2,1,'2',1,1,'+',10.00,'+',0.00,1,1,'2016-10-22 07:53:11','2016-10-22 07:53:11'),(3,2,'4',1,1,'+',10.00,'+',0.00,1,1,'2016-10-22 07:53:11','2016-10-22 07:53:11'),(4,2,'5',1,1,'+',15.00,'+',0.00,1,1,'2016-10-22 07:53:12','2016-10-22 07:53:12'),(5,3,'8',1,1,'+',20.00,'+',0.00,1,1,'2016-10-22 07:53:12','2016-10-22 07:53:12'),(6,3,'9',1,1,'+',25.00,'+',0.00,1,1,'2016-10-22 07:53:12','2016-10-22 07:53:12');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  KEY `idx_display_name` (`display_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_translated`
--

LOCK TABLES `tbl_product_option_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_option_translated` VALUES (1,1,'en-US','Color','color',1,1,'2016-10-22 07:52:29','2016-10-22 07:52:29'),(2,2,'en-US','Size','size',1,1,'2016-10-22 07:52:30','2016-10-22 07:52:30'),(3,3,'en-US','Resolution','resolution',1,1,'2016-10-22 07:52:30','2016-10-22 07:52:30');
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
  `option_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_option_id` (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_value`
--

LOCK TABLES `tbl_product_option_value` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_value` DISABLE KEYS */;
INSERT INTO `tbl_product_option_value` VALUES (1,1,1,1,'2016-10-22 07:52:30','2016-10-22 07:52:30'),(2,1,1,1,'2016-10-22 07:52:31','2016-10-22 07:52:31'),(3,1,1,1,'2016-10-22 07:52:32','2016-10-22 07:52:32'),(4,2,1,1,'2016-10-22 07:52:33','2016-10-22 07:52:33'),(5,2,1,1,'2016-10-22 07:52:34','2016-10-22 07:52:34'),(6,2,1,1,'2016-10-22 07:52:35','2016-10-22 07:52:35'),(7,2,1,1,'2016-10-22 07:52:35','2016-10-22 07:52:35'),(8,3,1,1,'2016-10-22 07:52:35','2016-10-22 07:52:35'),(9,3,1,1,'2016-10-22 07:52:36','2016-10-22 07:52:36'),(10,3,1,1,'2016-10-22 07:52:36','2016-10-22 07:52:36');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_value` (`value`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_option_value_translated`
--

LOCK TABLES `tbl_product_option_value_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_option_value_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_option_value_translated` VALUES (1,1,'en-US','Grey',1,1,'2016-10-22 07:52:30','2016-10-22 07:52:30'),(2,2,'en-US','Silver',1,1,'2016-10-22 07:52:31','2016-10-22 07:52:31'),(3,3,'en-US','Black',1,1,'2016-10-22 07:52:33','2016-10-22 07:52:33'),(4,4,'en-US','L',1,1,'2016-10-22 07:52:34','2016-10-22 07:52:34'),(5,5,'en-US','M',1,1,'2016-10-22 07:52:34','2016-10-22 07:52:34'),(6,6,'en-US','XL',1,1,'2016-10-22 07:52:35','2016-10-22 07:52:35'),(7,7,'en-US','S',1,1,'2016-10-22 07:52:35','2016-10-22 07:52:35'),(8,8,'en-US','4MP',1,1,'2016-10-22 07:52:35','2016-10-22 07:52:35'),(9,9,'en-US','8MP',1,1,'2016-10-22 07:52:36','2016-10-22 07:52:36'),(10,10,'en-US','10MP',1,1,'2016-10-22 07:52:36','2016-10-22 07:52:36');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_rating` (`rating`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_related_product_id` (`related_product_id`)
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
  `status` smallint(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_review`
--

LOCK TABLES `tbl_product_review` WRITE;
/*!40000 ALTER TABLE `tbl_product_review` DISABLE KEYS */;
INSERT INTO `tbl_product_review` VALUES (1,'Test Customer',2,1,1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09'),(2,'Test Customer',2,1,1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09'),(3,'Test Customer',2,1,1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09'),(4,'Test Customer',2,1,1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_review_translated`
--

LOCK TABLES `tbl_product_review_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_review_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_review_translated` VALUES (1,1,'en-US','This is my first review',1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09'),(2,2,'en-US','This is my second review',1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09'),(3,3,'en-US','This is my third review',1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09'),(4,4,'en-US','This is my fourth review',1,1,'2016-10-22 07:53:09','2016-10-22 07:53:09');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_group_id` (`group_id`),
  KEY `idx_priority` (`priority`),
  KEY `idx_price` (`price`),
  KEY `idx_start_datetime` (`start_datetime`),
  KEY `idx_end_datetime` (`end_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_special`
--

LOCK TABLES `tbl_product_special` WRITE;
/*!40000 ALTER TABLE `tbl_product_special` DISABLE KEYS */;
INSERT INTO `tbl_product_special` VALUES (1,4,1,1.00,'2016-10-17 07:53:10','2016-10-24 07:53:10',1,1,1,'2016-10-22 07:53:10','2016-10-22 07:53:10'),(2,5,2,2.00,'2016-10-17 07:53:10','2016-10-24 07:53:10',1,1,1,'2016-10-22 07:53:10','2016-10-22 07:53:10');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_tag_id` (`tag_id`)
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_tax_class`
--

LOCK TABLES `tbl_product_tax_class` WRITE;
/*!40000 ALTER TABLE `tbl_product_tax_class` DISABLE KEYS */;
INSERT INTO `tbl_product_tax_class` VALUES (1,1,1,'2016-10-22 07:52:37','2016-10-22 07:52:37');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_tax_class_translated`
--

LOCK TABLES `tbl_product_tax_class_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_tax_class_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_tax_class_translated` VALUES (1,1,'en-US','taxable goods','Applied to goods on which tax has to be applied',1,1,'2016-10-22 07:52:37','2016-10-22 07:52:37');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  KEY `idx_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_translated`
--

LOCK TABLES `tbl_product_translated` WRITE;
/*!40000 ALTER TABLE `tbl_product_translated` DISABLE KEYS */;
INSERT INTO `tbl_product_translated` VALUES (1,1,'en-US','Apple Cinema 20\"','apple-cinema-20\"',NULL,NULL,'This is description for product Apple Cinema 20\"',1,1,'2016-10-22 07:52:44','2016-10-22 07:52:44'),(2,2,'en-US','Apple Cinema 21\"','apple-cinema-21\"',NULL,NULL,'This is description for product Apple Cinema 21\"',1,1,'2016-10-22 07:52:45','2016-10-22 07:52:45'),(3,3,'en-US','Apple Cinema 22\"','apple-cinema-22\"',NULL,NULL,'This is description for product Apple Cinema 22\"',1,1,'2016-10-22 07:52:46','2016-10-22 07:52:46'),(4,4,'en-US','Apple Cinema 23\"','apple-cinema-23\"',NULL,NULL,'This is description for product Apple Cinema 23\"',1,1,'2016-10-22 07:52:47','2016-10-22 07:52:47'),(5,5,'en-US','Apple Cinema 24\"','apple-cinema-24\"',NULL,NULL,'This is description for product Apple Cinema 24\"',1,1,'2016-10-22 07:52:47','2016-10-22 07:52:47'),(6,6,'en-US','Apple Cinema 25\"','apple-cinema-25\"',NULL,NULL,'This is description for product Apple Cinema 25\"',1,1,'2016-10-22 07:52:48','2016-10-22 07:52:48'),(7,7,'en-US','Apple Cinema 26\"','apple-cinema-26\"',NULL,NULL,'This is description for product Apple Cinema 26\"',1,1,'2016-10-22 07:52:48','2016-10-22 07:52:48'),(8,8,'en-US','Apple Cinema 27\"','apple-cinema-27\"',NULL,NULL,'This is description for product Apple Cinema 27\"',1,1,'2016-10-22 07:52:49','2016-10-22 07:52:49'),(9,9,'en-US','Apple Cinema 28\"','apple-cinema-28\"',NULL,NULL,'This is description for product Apple Cinema 28\"',1,1,'2016-10-22 07:52:50','2016-10-22 07:52:50'),(10,10,'en-US','Apple Cinema 29\"','apple-cinema-29\"',NULL,NULL,'This is description for product Apple Cinema 29\"',1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(11,11,'en-US','Apple Cinema 30\"','apple-cinema-30\"',NULL,NULL,'This is description for product Apple Cinema 30\"',1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(12,12,'en-US','Canon EOS 5D','canon-eos-5d',NULL,NULL,'This is description for product Canon EOS 5D',1,1,'2016-10-22 07:52:51','2016-10-22 07:52:51'),(13,13,'en-US','Canon EOS 5 S','canon-eos-5-s',NULL,NULL,'This is description for product Canon EOS 5 S',1,1,'2016-10-22 07:52:52','2016-10-22 07:52:52'),(14,14,'en-US','Canon EOS 5 LX','canon-eos-5-lx',NULL,NULL,'This is description for product Canon EOS 5 LX',1,1,'2016-10-22 07:52:52','2016-10-22 07:52:52'),(15,15,'en-US','Canon EOS 6D','canon-eos-6d',NULL,NULL,'This is description for product Canon EOS 6D',1,1,'2016-10-22 07:52:52','2016-10-22 07:52:52'),(16,16,'en-US','Canon EOS 6 S','canon-eos-6-s',NULL,NULL,'This is description for product Canon EOS 6 S',1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(17,17,'en-US','Canon EOS 6 LX','canon-eos-6-lx',NULL,NULL,'This is description for product Canon EOS 6 LX',1,1,'2016-10-22 07:52:53','2016-10-22 07:52:53'),(18,18,'en-US','Canon EOS 7D','canon-eos-7d',NULL,NULL,'This is description for product Canon EOS 7D',1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(19,19,'en-US','Canon EOS 7 S','canon-eos-7-s',NULL,NULL,'This is description for product Canon EOS 7 S',1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(20,20,'en-US','Canon EOS 7 LX','canon-eos-7-lx',NULL,NULL,'This is description for product Canon EOS 7 LX',1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(21,21,'en-US','Canon EOS 8D','canon-eos-8d',NULL,NULL,'This is description for product Canon EOS 8D',1,1,'2016-10-22 07:52:54','2016-10-22 07:52:54'),(22,22,'en-US','Canon EOS 8 S','canon-eos-8-s',NULL,NULL,'This is description for product Canon EOS 8 S',1,1,'2016-10-22 07:52:55','2016-10-22 07:52:55'),(23,23,'en-US','Canon EOS 8 LX','canon-eos-8-lx',NULL,NULL,'This is description for product Canon EOS 8 LX',1,1,'2016-10-22 07:52:55','2016-10-22 07:52:55'),(24,24,'en-US','Canon EOS 9D','canon-eos-9d',NULL,NULL,'This is description for product Canon EOS 9D',1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(25,25,'en-US','Canon EOS 9 S','canon-eos-9-s',NULL,NULL,'This is description for product Canon EOS 9 S',1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(26,26,'en-US','Canon EOS 9 LX','canon-eos-9-lx',NULL,NULL,'This is description for product Canon EOS 9 LX',1,1,'2016-10-22 07:52:56','2016-10-22 07:52:56'),(27,27,'en-US','Canon EOS 10D','canon-eos-10d',NULL,NULL,'This is description for product Canon EOS 10D',1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(28,28,'en-US','Canon EOS 10 S','canon-eos-10-s',NULL,NULL,'This is description for product Canon EOS 10 S',1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(29,29,'en-US','Canon EOS 10 LX','canon-eos-10-lx',NULL,NULL,'This is description for product Canon EOS 10 LX',1,1,'2016-10-22 07:52:57','2016-10-22 07:52:57'),(30,30,'en-US','Canon EOS 11D','canon-eos-11d',NULL,NULL,'This is description for product Canon EOS 11D',1,1,'2016-10-22 07:52:58','2016-10-22 07:52:58'),(31,31,'en-US','Canon EOS 11 S','canon-eos-11-s',NULL,NULL,'This is description for product Canon EOS 11 S',1,1,'2016-10-22 07:52:58','2016-10-22 07:52:58'),(32,32,'en-US','Canon EOS 11 LX','canon-eos-11-lx',NULL,NULL,'This is description for product Canon EOS 11 LX',1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(33,33,'en-US','Canon EOS 12D','canon-eos-12d',NULL,NULL,'This is description for product Canon EOS 12D',1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(34,34,'en-US','Canon EOS 12 S','canon-eos-12-s',NULL,NULL,'This is description for product Canon EOS 12 S',1,1,'2016-10-22 07:52:59','2016-10-22 07:52:59'),(35,35,'en-US','Canon EOS 12 LX','canon-eos-12-lx',NULL,NULL,'This is description for product Canon EOS 12 LX',1,1,'2016-10-22 07:53:00','2016-10-22 07:53:00'),(36,36,'en-US','Canon EOS 13D','canon-eos-13d',NULL,NULL,'This is description for product Canon EOS 13D',1,1,'2016-10-22 07:53:01','2016-10-22 07:53:01'),(37,37,'en-US','Canon EOS 13 S','canon-eos-13-s',NULL,NULL,'This is description for product Canon EOS 13 S',1,1,'2016-10-22 07:53:01','2016-10-22 07:53:01'),(38,38,'en-US','Canon EOS 13 LX','canon-eos-13-lx',NULL,NULL,'This is description for product Canon EOS 13 LX',1,1,'2016-10-22 07:53:02','2016-10-22 07:53:02'),(39,39,'en-US','Canon EOS 14D','canon-eos-14d',NULL,NULL,'This is description for product Canon EOS 14D',1,1,'2016-10-22 07:53:02','2016-10-22 07:53:02'),(40,40,'en-US','Canon EOS 14 S','canon-eos-14-s',NULL,NULL,'This is description for product Canon EOS 14 S',1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(41,41,'en-US','Canon EOS 14 LX','canon-eos-14-lx',NULL,NULL,'This is description for product Canon EOS 14 LX',1,1,'2016-10-22 07:53:03','2016-10-22 07:53:03'),(42,42,'en-US','Canon EOS 15D','canon-eos-15d',NULL,NULL,'This is description for product Canon EOS 15D',1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(43,43,'en-US','Canon EOS 15 S','canon-eos-15-s',NULL,NULL,'This is description for product Canon EOS 15 S',1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(44,44,'en-US','Canon EOS 15 LX','canon-eos-15-lx',NULL,NULL,'This is description for product Canon EOS 15 LX',1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(45,45,'en-US','Sony Vaio 20\"','sony-vaio-20\"',NULL,NULL,'This is description for product Sony Vaio 20\"',1,1,'2016-10-22 07:53:04','2016-10-22 07:53:04'),(46,46,'en-US','Sony Vaio 21\"','sony-vaio-21\"',NULL,NULL,'This is description for product Sony Vaio 21\"',1,1,'2016-10-22 07:53:05','2016-10-22 07:53:05'),(47,47,'en-US','Sony Vaio 22\"','sony-vaio-22\"',NULL,NULL,'This is description for product Sony Vaio 22\"',1,1,'2016-10-22 07:53:05','2016-10-22 07:53:05'),(48,48,'en-US','Sony Vaio 23\"','sony-vaio-23\"',NULL,NULL,'This is description for product Sony Vaio 23\"',1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(49,49,'en-US','Sony Vaio 24\"','sony-vaio-24\"',NULL,NULL,'This is description for product Sony Vaio 24\"',1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(50,50,'en-US','Sony Vaio 25\"','sony-vaio-25\"',NULL,NULL,'This is description for product Sony Vaio 25\"',1,1,'2016-10-22 07:53:06','2016-10-22 07:53:06'),(51,51,'en-US','Sony Vaio 26\"','sony-vaio-26\"',NULL,NULL,'This is description for product Sony Vaio 26\"',1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(52,52,'en-US','Sony Vaio 27\"','sony-vaio-27\"',NULL,NULL,'This is description for product Sony Vaio 27\"',1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(53,53,'en-US','Sony Vaio 28\"','sony-vaio-28\"',NULL,NULL,'This is description for product Sony Vaio 28\"',1,1,'2016-10-22 07:53:07','2016-10-22 07:53:07'),(54,54,'en-US','Sony Vaio 29\"','sony-vaio-29\"',NULL,NULL,'This is description for product Sony Vaio 29\"',1,1,'2016-10-22 07:53:08','2016-10-22 07:53:08'),(55,55,'en-US','Sony Vaio 30\"','sony-vaio-30\"',NULL,NULL,'This is description for product Sony Vaio 30\"',1,1,'2016-10-22 07:53:08','2016-10-22 07:53:08');
/*!40000 ALTER TABLE `tbl_product_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_role`
--

DROP TABLE IF EXISTS `tbl_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` int(1) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_level` (`level`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_role`
--

LOCK TABLES `tbl_role` WRITE;
/*!40000 ALTER TABLE `tbl_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_role` ENABLE KEYS */;
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_sequence` VALUES (1,'0','10002','0',1,1,'2016-10-22 07:53:15','2016-10-22 07:53:15');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
  `status` smallint(1) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_state` VALUES (1,1,1,'DE',1,1,'2016-10-22 07:53:31','2016-10-22 07:53:31'),(2,1,1,'AS',1,1,'2016-10-22 07:53:31','2016-10-22 07:53:31'),(3,1,1,'GO',1,1,'2016-10-22 07:53:32','2016-10-22 07:53:32'),(4,1,1,'MN',1,1,'2016-10-22 07:53:33','2016-10-22 07:53:33');
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
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_state_translated`
--

LOCK TABLES `tbl_state_translated` WRITE;
/*!40000 ALTER TABLE `tbl_state_translated` DISABLE KEYS */;
INSERT INTO `tbl_state_translated` VALUES (1,1,'en-US','Delhi',1,1,'2016-10-22 07:53:31','2016-10-22 07:53:31'),(2,2,'en-US','Assam',1,1,'2016-10-22 07:53:32','2016-10-22 07:53:32'),(3,3,'en-US','Goa',1,1,'2016-10-22 07:53:32','2016-10-22 07:53:32'),(4,4,'en-US','Manipur',1,1,'2016-10-22 07:53:33','2016-10-22 07:53:33');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_stock_status`
--

LOCK TABLES `tbl_stock_status` WRITE;
/*!40000 ALTER TABLE `tbl_stock_status` DISABLE KEYS */;
INSERT INTO `tbl_stock_status` VALUES (1,1,1,'2016-10-22 07:53:33','2016-10-22 07:53:33'),(2,1,1,'2016-10-22 07:53:33','2016-10-22 07:53:33');
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
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_stock_status_translated`
--

LOCK TABLES `tbl_stock_status_translated` WRITE;
/*!40000 ALTER TABLE `tbl_stock_status_translated` DISABLE KEYS */;
INSERT INTO `tbl_stock_status_translated` VALUES (1,1,'en-US','In Stock',1,1,'2016-10-22 07:53:33','2016-10-22 07:53:33'),(2,2,'en-US','Out Of Stock',1,1,'2016-10-22 07:53:34','2016-10-22 07:53:34');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_data_category_id` (`data_category_id`),
  KEY `idx_theme` (`theme`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store`
--

LOCK TABLES `tbl_store` WRITE;
/*!40000 ALTER TABLE `tbl_store` DISABLE KEYS */;
INSERT INTO `tbl_store` VALUES (1,'http://teststore.org',1,1,1,3,'classic',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(2,'http://demostore.org',1,2,0,3,'classic',1,1,'2016-10-22 07:53:45','2016-10-22 07:53:45');
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
  `category` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_store_code_key` (`store_id`,`code`,`key`),
  KEY `idx_store_id` (`store_id`),
  KEY `idx_category` (`category`),
  KEY `idx_code` (`code`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_configuration`
--

LOCK TABLES `tbl_store_configuration` WRITE;
/*!40000 ALTER TABLE `tbl_store_configuration` DISABLE KEYS */;
INSERT INTO `tbl_store_configuration` VALUES (1,1,'storeconfig','storesettings','invoice_prefix','#',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(2,1,'storeconfig','storesettings','catalog_items_per_page','8',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(3,1,'storeconfig','storesettings','list_description_limit','100',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(4,1,'storeconfig','storesettings','display_price_with_tax','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(5,1,'storeconfig','storesettings','tax_calculation_based_on','billing',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(6,1,'storeconfig','storesettings','guest_checkout','0',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(7,1,'storeconfig','storesettings','order_status','8',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(8,1,'storeconfig','storesettings','display_stock','0',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(9,1,'storeconfig','storesettings','customer_online','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(10,1,'storeconfig','storesettings','default_customer_group','3',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(11,1,'storeconfig','storesettings','allow_reviews','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(12,1,'storeconfig','storesettings','allow_guest_reviews','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(13,1,'storeconfig','storesettings','show_out_of_stock_warning','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(14,1,'storeconfig','storesettings','allow_out_of_stock_checkout','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(15,1,'storeconfig','storesettings','allow_wishlist','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(16,1,'storeconfig','storesettings','allow_compare_products','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(17,1,'storeconfig','storesettings','customer_prefix','#',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(18,1,'storeconfig','storesettings','order_prefix','#',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(19,1,'storeconfig','storesettings','display_weight','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(20,1,'storeconfig','storesettings','display_dimensions','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(21,1,'storeconfig','storelocal','country','IN',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(22,1,'storeconfig','storelocal','timezone','Asia/Kolkata',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(23,1,'storeconfig','storelocal','state','Haryana',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(24,1,'storeconfig','storelocal','currency','USD',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(25,1,'storeconfig','storelocal','length_class','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(26,1,'storeconfig','storelocal','weight_class','1',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(27,1,'storeconfig','storelocal','language','en-US',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(28,1,'storeconfig','storeimage','store_logo','',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(29,1,'storeconfig','storeimage','icon','',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(30,1,'storeconfig','storeimage','category_image_width','90',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(31,1,'storeconfig','storeimage','category_image_height','90',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(32,1,'storeconfig','storeimage','product_list_image_width','150',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(33,1,'storeconfig','storeimage','product_list_image_height','150',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(34,1,'storeconfig','storeimage','related_product_image_width','80',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(35,1,'storeconfig','storeimage','related_product_image_height','80',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(36,1,'storeconfig','storeimage','compare_image_width','90',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(37,1,'storeconfig','storeimage','compare_image_height','90',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(38,1,'storeconfig','storeimage','wishlist_image_width','47',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(39,1,'storeconfig','storeimage','wishlist_image_height','47',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(40,1,'storeconfig','storeimage','cart_image_width','47',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(41,1,'storeconfig','storeimage','cart_image_height','47',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(42,1,'storeconfig','storeimage','store_image_width','47',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(43,1,'storeconfig','storeimage','store_image_height','47',1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(44,1,'payment','paypal_standard_orderstatus_map','canceled_reversal_status','2',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(45,1,'payment','paypal_standard_orderstatus_map','completed_status','4',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(46,1,'payment','paypal_standard_orderstatus_map','denied_status','5',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(47,1,'payment','paypal_standard_orderstatus_map','expired_status','6',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(48,1,'payment','paypal_standard_orderstatus_map','failed_status','7',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(49,1,'payment','paypal_standard_orderstatus_map','pending_status','8',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(50,1,'payment','paypal_standard_orderstatus_map','processed_status','9',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(51,1,'payment','paypal_standard_orderstatus_map','refunded_status','11',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(52,1,'payment','paypal_standard_orderstatus_map','reversed_status','12',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(53,1,'payment','paypal_standard_orderstatus_map','voided_status','14',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(54,1,'payment','cashondelivery','order_status','8',1,1,'2016-10-22 07:53:43','2016-10-22 07:53:43'),(55,1,'shipping','flat','method_name','fixed',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(56,1,'shipping','flat','calculateHandlingFee','fixed',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(57,1,'shipping','flat','handlingFee','0',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(58,1,'shipping','flat','type','perItem',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(59,1,'shipping','flat','applicableZones','1',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(60,1,'shipping','flat','specificZones','a:0:{}',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(61,1,'shipping','flat','price','5',1,1,'2016-10-22 07:53:44','2016-10-22 07:53:44'),(62,2,'storeconfig','storesettings','invoice_prefix','#',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(63,2,'storeconfig','storesettings','catalog_items_per_page','8',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(64,2,'storeconfig','storesettings','list_description_limit','100',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(65,2,'storeconfig','storesettings','display_price_with_tax','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(66,2,'storeconfig','storesettings','tax_calculation_based_on','billing',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(67,2,'storeconfig','storesettings','guest_checkout','0',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(68,2,'storeconfig','storesettings','order_status','8',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(69,2,'storeconfig','storesettings','display_stock','0',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(70,2,'storeconfig','storesettings','customer_online','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(71,2,'storeconfig','storesettings','default_customer_group','3',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(72,2,'storeconfig','storesettings','allow_reviews','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(73,2,'storeconfig','storesettings','allow_guest_reviews','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(74,2,'storeconfig','storesettings','show_out_of_stock_warning','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(75,2,'storeconfig','storesettings','allow_out_of_stock_checkout','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(76,2,'storeconfig','storesettings','allow_wishlist','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(77,2,'storeconfig','storesettings','allow_compare_products','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(78,2,'storeconfig','storesettings','customer_prefix','#',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(79,2,'storeconfig','storesettings','order_prefix','#',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(80,2,'storeconfig','storesettings','display_weight','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(81,2,'storeconfig','storesettings','display_dimensions','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(82,2,'storeconfig','storelocal','country','IN',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(83,2,'storeconfig','storelocal','timezone','Asia/Kolkata',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(84,2,'storeconfig','storelocal','state','Haryana',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(85,2,'storeconfig','storelocal','currency','USD',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(86,2,'storeconfig','storelocal','length_class','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(87,2,'storeconfig','storelocal','weight_class','1',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(88,2,'storeconfig','storelocal','language','en-US',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(89,2,'storeconfig','storeimage','store_logo','',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(90,2,'storeconfig','storeimage','icon','',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(91,2,'storeconfig','storeimage','category_image_width','90',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(92,2,'storeconfig','storeimage','category_image_height','90',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(93,2,'storeconfig','storeimage','product_list_image_width','150',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(94,2,'storeconfig','storeimage','product_list_image_height','150',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(95,2,'storeconfig','storeimage','related_product_image_width','80',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(96,2,'storeconfig','storeimage','related_product_image_height','80',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(97,2,'storeconfig','storeimage','compare_image_width','90',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(98,2,'storeconfig','storeimage','compare_image_height','90',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(99,2,'storeconfig','storeimage','wishlist_image_width','47',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(100,2,'storeconfig','storeimage','wishlist_image_height','47',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(101,2,'storeconfig','storeimage','cart_image_width','47',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(102,2,'storeconfig','storeimage','cart_image_height','47',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(103,2,'storeconfig','storeimage','store_image_width','47',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46'),(104,2,'storeconfig','storeimage','store_image_height','47',1,1,'2016-10-22 07:53:46','2016-10-22 07:53:46');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_translated`
--

LOCK TABLES `tbl_store_translated` WRITE;
/*!40000 ALTER TABLE `tbl_store_translated` DISABLE KEYS */;
INSERT INTO `tbl_store_translated` VALUES (1,1,'en-US','Default','This is test store set up with the application',NULL,NULL,1,1,'2016-10-22 07:52:27','2016-10-22 07:52:27'),(2,2,'en-US','Demo','This is demo store set up with the application',NULL,NULL,1,1,'2016-10-22 07:53:45','2016-10-22 07:53:45');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
  `name` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`)
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
-- Table structure for table `tbl_tax_rate`
--

DROP TABLE IF EXISTS `tbl_tax_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tax_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `tax_zone_id` int(11) NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_value` (`value`),
  KEY `idx_tax_zone_id` (`tax_zone_id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tax_rate`
--

LOCK TABLES `tbl_tax_rate` WRITE;
/*!40000 ALTER TABLE `tbl_tax_rate` DISABLE KEYS */;
INSERT INTO `tbl_tax_rate` VALUES (1,'4',1,'percent',1,1,'2016-10-22 07:53:35','2016-10-22 07:53:35'),(2,'5',1,'percent',1,1,'2016-10-22 07:53:35','2016-10-22 07:53:35');
/*!40000 ALTER TABLE `tbl_tax_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tax_rate_translated`
--

DROP TABLE IF EXISTS `tbl_tax_rate_translated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tax_rate_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tax_rate_translated`
--

LOCK TABLES `tbl_tax_rate_translated` WRITE;
/*!40000 ALTER TABLE `tbl_tax_rate_translated` DISABLE KEYS */;
INSERT INTO `tbl_tax_rate_translated` VALUES (1,1,'en-US','Sales Tax',1,1,'2016-10-22 07:53:35','2016-10-22 07:53:35'),(2,2,'en-US','Service Tax',1,1,'2016-10-22 07:53:36','2016-10-22 07:53:36');
/*!40000 ALTER TABLE `tbl_tax_rate_translated` ENABLE KEYS */;
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_based_on` (`based_on`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tax_rule`
--

LOCK TABLES `tbl_tax_rule` WRITE;
/*!40000 ALTER TABLE `tbl_tax_rule` DISABLE KEYS */;
INSERT INTO `tbl_tax_rule` VALUES (1,'shipping',1,1,'2016-10-22 07:53:36','2016-10-22 07:53:36'),(2,'billing',1,1,'2016-10-22 07:53:37','2016-10-22 07:53:37');
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
  `tax_rate_id` int(11) NOT NULL,
  `tax_zone_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tax_rate_id` (`tax_rate_id`),
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
INSERT INTO `tbl_tax_rule_details` VALUES (1,1,1,3,1,1,1,1,'2016-10-22 07:53:36','2016-10-22 07:53:36'),(2,1,1,5,1,1,1,1,'2016-10-22 07:53:36','2016-10-22 07:53:36'),(3,1,1,4,1,1,1,1,'2016-10-22 07:53:36','2016-10-22 07:53:36'),(4,2,1,3,2,1,1,1,'2016-10-22 07:53:38','2016-10-22 07:53:38'),(5,2,1,5,2,1,1,1,'2016-10-22 07:53:38','2016-10-22 07:53:38'),(6,2,1,4,2,1,1,1,'2016-10-22 07:53:38','2016-10-22 07:53:38');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tax_rule_translated`
--

LOCK TABLES `tbl_tax_rule_translated` WRITE;
/*!40000 ALTER TABLE `tbl_tax_rule_translated` DISABLE KEYS */;
INSERT INTO `tbl_tax_rule_translated` VALUES (1,1,'en-US','Sales Tax',1,1,'2016-10-22 07:53:36','2016-10-22 07:53:36'),(2,2,'en-US','Service Tax',1,1,'2016-10-22 07:53:38','2016-10-22 07:53:38');
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
  `password_reset_token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `person_id` int(11) NOT NULL,
  `login_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `timezone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`),
  UNIQUE KEY `idx_person_id` (`person_id`),
  KEY `idx_status` (`status`),
  KEY `idx_timezone` (`timezone`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'super','','$2y$13$.evBnNqMazDTXTfYzg/8Sehce/Znfqt.OaS8FBSUvIjZcke8df5Ui','6hxPvcqMHEyCNN-KvKvUm7qZEQqVYRsH',1,1,'','0000-00-00 00:00:00','Asia/Kolkata','system',1,1,'2016-10-22 07:52:06','2016-10-22 07:52:06'),(2,'demo','','$2y$13$ydj8w.R5IqPdsU91oAl84O3Kpw6cSCql/J5xlWvNoUDhIjSr1pVX2','SHJPaEnIfUu5dnr4s84eL2I5eFf3GdoZ',1,2,'','0000-00-00 00:00:00','Asia/Kolkata','system',1,1,'2016-10-22 07:52:14','2016-10-22 07:52:14'),(3,'storeowner','','$2y$13$7hT8BY9yhmQN.JOl9NtQjO8hiH527okZ5UYk6vfYPj2kH1iT/aNw6','P63GRxPbfBfoYIYT_MHosZ59j4akpOGs',1,3,'','0000-00-00 00:00:00','Asia/Kolkata','system',1,1,'2016-10-22 07:52:19','2016-10-22 07:52:19');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_metadata`
--

DROP TABLE IF EXISTS `tbl_user_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `serializeddata` blob NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_classname` (`classname`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_metadata`
--

LOCK TABLES `tbl_user_metadata` WRITE;
/*!40000 ALTER TABLE `tbl_user_metadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_roles`
--

DROP TABLE IF EXISTS `tbl_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_roles` (
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_roles`
--

LOCK TABLES `tbl_user_roles` WRITE;
/*!40000 ALTER TABLE `tbl_user_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user_roles` ENABLE KEYS */;
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unit` (`unit`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_weight_class`
--

LOCK TABLES `tbl_weight_class` WRITE;
/*!40000 ALTER TABLE `tbl_weight_class` DISABLE KEYS */;
INSERT INTO `tbl_weight_class` VALUES (1,'kg',1.00,1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(2,'g',1000.00,1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(3,'oz',35.27,1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(4,'lb',2.20,1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21');
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
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_weight_class_translated`
--

LOCK TABLES `tbl_weight_class_translated` WRITE;
/*!40000 ALTER TABLE `tbl_weight_class_translated` DISABLE KEYS */;
INSERT INTO `tbl_weight_class_translated` VALUES (1,1,'en-US','Kilogram',1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(2,2,'en-US','Gram',1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(3,3,'en-US','Ounce',1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21'),(4,4,'en-US','Pound',1,1,'2016-10-22 07:52:21','2016-10-22 07:52:21');
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
  `is_zip_range` smallint(1) NOT NULL,
  `from_zip` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_zip` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
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
INSERT INTO `tbl_zone` VALUES (1,1,1,'110005',0,NULL,NULL,1,1,'2016-10-22 07:53:34','2016-10-22 07:53:34'),(2,1,4,'*',1,'781000','781010',1,1,'2016-10-22 07:53:35','2016-10-22 07:53:35');
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
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_zone_translated`
--

LOCK TABLES `tbl_zone_translated` WRITE;
/*!40000 ALTER TABLE `tbl_zone_translated` DISABLE KEYS */;
INSERT INTO `tbl_zone_translated` VALUES (1,1,'en-US','North Zone','North Zone for India',1,1,'2016-10-22 07:53:35','2016-10-22 07:53:35'),(2,2,'en-US','East Zone','East Zone for India',1,1,'2016-10-22 07:53:35','2016-10-22 07:53:35');
/*!40000 ALTER TABLE `tbl_zone_translated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'usnicartyii2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-22 11:23:53
