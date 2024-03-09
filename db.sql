/*
SQLyog Community v12.4.3 (32 bit)
MySQL - 10.4.32-MariaDB : Database - hokala
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hokala` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `hokala`;

/*Table structure for table `tbl_cart` */

DROP TABLE IF EXISTS `tbl_cart`;

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_cart` */

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_category` */

insert  into `tbl_category`(`category_id`,`category`,`deleted`) values 
(1,'OE',0),
(2,'LB',0),
(4,'MC',0),
(5,'MV',0),
(6,'FF',0),
(9,'LN',0),
(10,'',0),
(11,'Category',0),
(12,'COSMETICS',0);

/*Table structure for table `tbl_menus` */

DROP TABLE IF EXISTS `tbl_menus`;

CREATE TABLE `tbl_menus` (
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent` int(1) NOT NULL DEFAULT 0,
  `parent_title` varchar(100) DEFAULT NULL,
  `parent_icon` varchar(100) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_menus` */

insert  into `tbl_menus`(`menu_id`,`parent_id`,`sort_order`,`title`,`url`,`icon`,`parent`,`parent_title`,`parent_icon`,`order_by`,`role`) values 
(7,2,1,'Sales Report','Report/sales_report','arrow_right',0,'Reports','receipt_long',5,'0'),
(11,2,2,'Inventoy Report','Report/inventory_report','arrow_right',0,'Reports','receipt_long',5,'0'),
(12,3,2,'Product List','Product','arrow_right',0,'Product Management','web_asset',3,'0'),
(13,0,2,'Point Of Sale','Product/pos','arrow_right',1,'Point Sale','web_asset',2,'0,1'),
(16,3,1,'Categories','Category','arrow_right',0,'Product Management','settings',4,'0'),
(18,5,1,'Suppliers','Supplier','group',0,'User Management','group',3,'0'),
(19,5,2,'Users','User','group',0,'User Management','group',3,'0'),
(20,6,0,'Dashboard','Dashboard','home',1,'Dashboard','home',1,'0'),
(21,2,3,'Expiring','Report/expiring','arrow_right',0,'Reports','receipt_long',5,'0'),
(22,4,4,'Settings','User/config','arrow_right',1,'Settings','settings',4,'0'),
(23,2,4,'Expired','Report/expired','arrow_right',0,'Reports','receipt_long',5,'0'),
(24,2,5,'Depleted','Report/depleted','arrow_right',0,'Reports','receipt_long',5,'0'),
(25,2,6,'Running Low','Report/running_low','arrow_right',0,'Reports','receipt_long',5,'0');

/*Table structure for table `tbl_months` */

DROP TABLE IF EXISTS `tbl_months`;

CREATE TABLE `tbl_months` (
  `month` varchar(100) NOT NULL,
  `month_id` int(11) NOT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_months` */

insert  into `tbl_months`(`month`,`month_id`) values 
('January',1),
('February',2),
('March',3),
('April',4),
('May',5),
('June',6),
('July',7),
('August',8),
('September',9),
('October',10),
('November',11),
('December',12);

/*Table structure for table `tbl_products` */

DROP TABLE IF EXISTS `tbl_products`;

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(230) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barcode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `desc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` int(5) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `expiry_date` datetime DEFAULT NULL,
  `selling_price` double DEFAULT NULL,
  `reorder_level` int(11) NOT NULL DEFAULT 0,
  `cost_price` double DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `index_assetID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9532 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_products` */

insert  into `tbl_products`(`product_id`,`name`,`barcode`,`category_id`,`desc`,`date_added`,`added_by`,`deleted`,`expiry_date`,`selling_price`,`reorder_level`,`cost_price`,`supplier_id`,`qty`,`modified_date`,`modified_by`) values 
(1,'Biscuits','11',1,'We have no hidden fees or registration fees','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',300,5,50000,54,7,'2024-03-09 00:00:00',1),
(2,'Brufen','22',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',350,3,NULL,NULL,26,NULL,NULL),
(3,'Soap','33',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',500,3,NULL,NULL,100,NULL,NULL),
(4,'Itel Phone','44',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',310,3,NULL,NULL,10,NULL,NULL),
(5,'Saver Rack','55',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',55,3,NULL,NULL,19,NULL,NULL),
(6,'Switch','66',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',600,3,NULL,NULL,42,NULL,NULL),
(7,'Switch','77',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',600,3,NULL,NULL,6,NULL,NULL),
(8,'Patch Panel','88',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',4400,3,NULL,NULL,67,NULL,NULL),
(9,'Swictch Rack','99',1,'N/a','2021-10-28 15:25:18',0,0,'2024-03-31 00:00:00',4500,6,NULL,NULL,6,NULL,NULL),
(10,'Switch','1010',1,'N/a','2021-10-28 15:25:19',0,0,'2024-03-31 00:00:00',6900,3,NULL,NULL,50,NULL,NULL),
(9521,'Asprin','1111',4,'PANADO EXTRA','2024-02-25 10:26:34',0,0,'2024-03-31 00:00:00',8000,6,7900,54,11,NULL,NULL),
(9522,'PANADO','1212',4,'We have no hidden fees or registration fees','2024-02-25 10:27:05',0,0,'2024-03-31 00:00:00',5000,5,7900,54,11,'2024-03-09 00:00:00',1),
(9531,'PROTEX','20',12,'BLACK','2024-02-25 16:01:01',0,0,'2024-03-31 00:00:00',700,10,500,NULL,100,NULL,NULL);

/*Table structure for table `tbl_quantities` */

DROP TABLE IF EXISTS `tbl_quantities`;

CREATE TABLE `tbl_quantities` (
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`qty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_quantities` */

/*Table structure for table `tbl_sale_details` */

DROP TABLE IF EXISTS `tbl_sale_details`;

CREATE TABLE `tbl_sale_details` (
  `sale_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sale_detail_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_sale_details` */

insert  into `tbl_sale_details`(`sale_detail_id`,`product_id`,`price`,`qty`,`vat`,`total`,`sale_id`,`sale_date`) values 
(1,3,500,2,165,1165,1,NULL),
(2,1,300,4,198,1398,1,NULL),
(3,3,500,2,165,1165,2,NULL),
(4,1,300,4,198,1398,2,NULL),
(5,3,500,2,165,1165,3,NULL),
(6,1,300,4,198,1398,3,NULL),
(7,3,500,2,165,1165,4,NULL),
(8,1,300,4,198,1398,4,NULL),
(9,10,6900,5,5692.5,40192.5,5,NULL),
(10,2,350,1,57.75,407.75,6,NULL),
(11,1,300,1,49.5,349.5,7,NULL),
(12,9522,5000,2,1650,11650,8,NULL),
(13,1,300,4,198,1398,9,NULL),
(14,2,350,1,57.75,407.75,10,NULL),
(15,1,300,2,99,699,10,NULL),
(16,3,500,3,247.5,1747.5,11,NULL),
(17,2,350,1,57.75,407.75,11,NULL),
(18,1,300,3,148.5,1048.5,11,NULL),
(19,1,300,5,247.5,1747.5,12,'0000-00-00 00:00:00'),
(20,2,350,4,231,1631,12,'0000-00-00 00:00:00'),
(21,1,300,1,49.5,349.5,13,'2024-02-25 17:44:38'),
(22,2,350,2,115.5,815.5,13,'2024-02-25 17:44:38'),
(23,6,600,2,198,1398,13,'2024-02-25 17:44:38'),
(24,5,55,3,27.225,192.225,13,'2024-02-25 17:44:38'),
(25,4,310,2,102.3,722.3,13,'2024-02-25 17:44:38'),
(26,5,55,3,27.225,192.225,14,'2024-03-09 12:09:05'),
(27,2,350,4,231,1631,14,'2024-03-09 12:09:05'),
(28,1,300,3,148.5,1048.5,14,'2024-03-09 12:09:05');

/*Table structure for table `tbl_sales` */

DROP TABLE IF EXISTS `tbl_sales`;

CREATE TABLE `tbl_sales` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sub` double DEFAULT NULL,
  `tendered` double DEFAULT NULL,
  `change` double DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_sales` */

insert  into `tbl_sales`(`sale_id`,`user_id`,`sale_date`,`sub`,`tendered`,`change`,`vat`,`total`) values 
(1,1,'2024-02-25',2200,5000,2437,363,2563),
(2,1,'2024-02-25',2200,NULL,-2563,363,2563),
(3,1,'2024-02-25',2200,5000,2437,363,2563),
(4,1,'2024-02-25',2200,5000,2437,363,2563),
(5,1,'2024-02-25',34500,50000,9807.5,5692.5,40192.5),
(6,1,'2024-02-25',350,500,92.25,57.75,407.75),
(7,1,'2024-02-25',300,400,50.5,49.5,349.5),
(8,1,'2024-02-25',10000,15000,3350,1650,11650),
(9,1,'2024-02-25',1200,200,-1198,198,1398),
(10,1,'2024-02-25',950,1500,393.25,156.75,1106.75),
(11,1,'2024-02-25',2750,5,-3198.75,453.75,3203.75),
(12,1,'2024-02-25',2900,5000,1621.5,478.5,3378.5),
(13,1,'2024-02-25',2985,5000,1522.475,492.525,3477.525),
(14,1,'2024-03-09',2465,3000,128.275,406.725,2871.725);

/*Table structure for table `tbl_settings` */

DROP TABLE IF EXISTS `tbl_settings`;

CREATE TABLE `tbl_settings` (
  `id` int(11) DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alt_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dep_type` int(11) DEFAULT NULL,
  `logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alt_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expire_alert_days` int(11) DEFAULT NULL,
  `vat` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_settings` */

insert  into `tbl_settings`(`id`,`address`,`phone`,`alt_phone`,`dep_type`,`logo`,`company`,`email`,`alt_email`,`expire_alert_days`,`vat`) values 
(1,'Blantyre\r\nMalawi','0995548992','+260777315753',NULL,NULL,'Nanga Unozge','briannkhata@gmail.com','briannkhata@gmail.com',NULL,16.5);

/*Table structure for table `tbl_suppliers` */

DROP TABLE IF EXISTS `tbl_suppliers`;

CREATE TABLE `tbl_suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_suppliers` */

insert  into `tbl_suppliers`(`supplier_id`,`name`,`address`,`phone`,`deleted`) values 
(1,'1','2024-01-30','finished',0),
(2,'1','2024-01-30','finished',0),
(3,'1','2024-01-30','finished',0),
(4,'1','2024-01-30','finished',0),
(5,'1','2024-01-30','finished',0),
(6,'1','2024-01-30','finished',0),
(7,'1','2024-01-30','finished',0),
(8,'1','2024-01-30','finished',0),
(9,'1','2024-01-30','finished',0),
(10,'1','2024-01-30','finished',0),
(11,'1','2024-01-30','finished',0),
(12,'1','0000-00-00','paused',0),
(13,'1','0000-00-00','paused',0),
(14,'1','0000-00-00','paused',0),
(15,'1','0000-00-00','paused',0),
(16,'1','0000-00-00','paused',0),
(17,'1','0000-00-00','paused',0),
(18,'1','0000-00-00','paused',0),
(19,'1','0000-00-00','paused',0),
(20,'1','0000-00-00','paused',0),
(21,'1','0000-00-00','paused',0),
(22,'1','0000-00-00','pending',0),
(23,'1','0000-00-00','pending',0),
(24,'1','0000-00-00','',0),
(25,'1','0000-00-00','',0),
(26,'1','0000-00-00','',0),
(27,'1','0000-00-00','',0),
(28,'1','0000-00-00','',0),
(29,'1','0000-00-00','',0),
(30,'1','0000-00-00','',0),
(31,'1','0000-00-00','',0),
(32,'1','0000-00-00','',0),
(33,'1','0000-00-00','',0),
(34,'1','0000-00-00','',0),
(35,'1','0000-00-00','',0),
(36,'1','0000-00-00','',0),
(37,'1','0000-00-00','',0),
(38,'1','0000-00-00','',0),
(39,'1','0000-00-00','',0),
(40,'1','0000-00-00','',0),
(41,'1','0000-00-00','',0),
(42,'1','0000-00-00','',0),
(43,'1','0000-00-00','',0),
(44,'1','0000-00-00','',0),
(45,'1','0000-00-00','',0),
(46,'1','0000-00-00','',0),
(47,'1','0000-00-00','',0),
(48,'1','0000-00-00','',0),
(49,'1','0000-00-00','',0),
(50,'1','0000-00-00','',0),
(51,'1','0000-00-00','',0),
(52,'1','0000-00-00','',0),
(53,'1','0000-00-00','',1),
(54,'Toyota Malawi','UP NORTH','0888015904',0),
(55,'Brian Nkhata','Blantyre','0888015904',0),
(56,'Brian Nkhata','Blantyre','0888015904',0);

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `role` varchar(200) NOT NULL DEFAULT '1',
  `added_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`user_id`,`name`,`phone`,`username`,`password`,`deleted`,`role`,`added_by`) values 
(1,'Admin','0','admin','21232f297a57a5a743894a0e4a801fc3',0,'0',1),
(6,'Cashier','+265 888 015 904','cash','84c8137f06fd53b0636e0818f3954cdb',0,'1',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
