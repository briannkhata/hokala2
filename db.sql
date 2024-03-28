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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_cart` */

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_category` */

insert  into `tbl_category`(`category_id`,`category`,`deleted`) values 
(12,'COSMETICS',0),
(13,'Biscuits',0),
(14,'soaps',0),
(15,'Sweets',0);

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
(7,2,1,'Sales Report','Report/sales_report','arrow_right',0,'Reports','receipt_long',5,'0,1'),
(11,2,2,'Inventoy Report','Report/inventory_report','arrow_right',0,'Reports','receipt_long',5,'0'),
(12,3,2,'Product List','Product','arrow_right',0,'Product Management','web_asset',3,'0'),
(13,0,2,'Point Of Sale','Product/pos','arrow_right',1,'Point Sale','web_asset',2,'0,1'),
(16,3,1,'Categories','Category','arrow_right',0,'Product Management','web_asset',3,'0'),
(18,5,1,'Suppliers','Supplier','group',0,'User Management','group',3,'0'),
(19,5,2,'Users','User','group',0,'User Management','group',3,'0'),
(20,6,0,'Dashboard','Dashboard','home',1,'Dashboard','home',1,'0,1'),
(21,2,3,'Expiring','Report/expiring','arrow_right',0,'Reports','receipt_long',5,'0'),
(22,4,4,'Settings','User/config','arrow_right',1,'Settings','settings',4,'0'),
(23,2,4,'Expired','Report/expired','arrow_right',0,'Reports','receipt_long',5,'0'),
(24,2,5,'Depleted','Report/depleted','arrow_right',0,'Reports','receipt_long',5,'0'),
(25,2,6,'Running Low','Report/running_low','arrow_right',0,'Reports','receipt_long',5,'0'),
(26,3,3,'Receive Product','Product/receive_product','arrow_right',0,'Product Management','web_asset',3,'0'),
(27,2,7,'Receivings/Orders','Report/receivings_report','arrow_right',0,'Reports','receipt_long',5,'0');

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
) ENGINE=InnoDB AUTO_INCREMENT=9535 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_products` */

insert  into `tbl_products`(`product_id`,`name`,`barcode`,`category_id`,`desc`,`date_added`,`added_by`,`deleted`,`expiry_date`,`selling_price`,`reorder_level`,`cost_price`,`supplier_id`,`qty`,`modified_date`,`modified_by`) values 
(9532,'GEISHA','1',14,'GEISHA WHITE','2024-03-10 18:49:11',0,0,'2024-03-10 00:00:00',6000,5,2500,57,47,NULL,NULL),
(9533,'PROTEX','2',14,'PINK','2024-03-10 18:50:52',0,0,'2025-01-01 00:00:00',2000,5,1700,57,24,NULL,NULL),
(9534,'POLISH','3',12,'BLACK','2024-03-10 20:31:42',0,0,'2024-03-31 00:00:00',3500,3,NULL,57,10,NULL,NULL);

/*Table structure for table `tbl_quantities` */

DROP TABLE IF EXISTS `tbl_quantities`;

CREATE TABLE `tbl_quantities` (
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`,`qty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_quantities` */

/*Table structure for table `tbl_receivings` */

DROP TABLE IF EXISTS `tbl_receivings`;

CREATE TABLE `tbl_receivings` (
  `receiving_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `selling_price` double DEFAULT NULL,
  `cost_price` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `receive_date` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  PRIMARY KEY (`receiving_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_receivings` */

insert  into `tbl_receivings`(`receiving_id`,`product_id`,`selling_price`,`cost_price`,`qty`,`receive_date`,`expiry_date`) values 
(1,9532,6000,5000,4,'2024-03-10 07:03:01','2024-03-10 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_sale_details` */

insert  into `tbl_sale_details`(`sale_detail_id`,`product_id`,`price`,`qty`,`vat`,`total`,`sale_id`,`sale_date`) values 
(61,9521,8000,1,1320,9320,34,'2024-03-10 16:59:57'),
(62,6,600,20,1980,13980,34,'2024-03-10 16:59:57'),
(63,9521,8000,1,1320,9320,35,'2024-03-10 16:59:57'),
(64,6,600,20,1980,13980,35,'2024-03-10 16:59:57'),
(65,9521,8000,1,1320,9320,36,'2024-03-10 17:00:52'),
(66,10,6900,1,1138.5,8038.5,36,'2024-03-10 17:00:53'),
(67,5,55,1,9.075,64.075,36,'2024-03-10 17:00:53'),
(68,9521,8000,1,1320,9320,38,'2024-03-10 17:03:31'),
(69,5,55,1,9.075,64.075,38,'2024-03-10 17:03:31'),
(70,10,6900,1,1138.5,8038.5,40,'2024-03-10 17:04:37'),
(71,2,350,3,173.25,1223.25,40,'2024-03-10 17:04:37'),
(72,9532,3000,4,0,12000,41,'2024-03-10 17:56:45'),
(73,9533,2000,5,0,10000,41,'2024-03-10 17:56:45'),
(74,9533,2000,1,0,2000,42,'2024-03-10 19:53:19'),
(75,9532,6000,3,0,18000,42,'2024-03-10 19:53:19');

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(14,1,'2024-03-09',2465,3000,128.275,406.725,2871.725),
(15,6,'2024-03-09',27075,32000,457.625,4467.375,31542.375),
(16,6,'2024-03-09',0,32000,32000,0,0),
(17,6,'2024-03-09',0,32000,32000,0,0),
(18,1,'2024-03-09',1880,2500,309.8,310.2,2190.2),
(19,1,'2024-03-09',800,1000,68,132,932),
(20,1,'2024-03-09',2405,3000,198.175,396.825,2801.825),
(21,1,'2024-03-09',1905,3000,780.675,314.325,2219.325),
(22,1,'2024-03-09',1595,2000,141.825,263.175,1858.175),
(23,1,'2024-03-09',1595,2000,141.825,263.175,1858.175),
(24,1,'2024-03-09',3200,4000,272,528,3728),
(25,1,'2024-03-09',0,4000,4000,0,0),
(26,1,'2024-03-10',28000,40000,7380,4620,32620),
(27,1,'2024-03-10',0,40000,40000,0,0),
(28,1,'2024-03-10',1100,2000,718.5,181.5,1281.5),
(29,1,'2024-03-10',0,2000,2000,0,0),
(30,1,'2024-03-10',13700,20000,4039.5,2260.5,15960.5),
(31,1,'2024-03-10',0,20000,20000,0,0),
(32,1,'2024-03-10',11900,15000,1136.5,1963.5,13863.5),
(33,1,'2024-03-10',11900,15000,1136.5,1963.5,13863.5),
(34,1,'2024-03-10',20000,25000,1700,3300,23300),
(35,1,'2024-03-10',20000,25000,1700,3300,23300),
(36,1,'2024-03-10',14955,20000,2577.425,2467.575,17422.575),
(37,1,'2024-03-10',0,20000,20000,0,0),
(38,1,'2024-03-10',8055,10000,615.925,1329.075,9384.075),
(39,1,'2024-03-10',0,10000,10000,0,0),
(40,6,'2024-03-10',7950,10000,738.25,1311.75,9261.75),
(41,1,'2024-03-10',22000,25000,3000,0,22000),
(42,1,'2024-03-10',20000,22000,2000,0,20000);

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
(1,'Blantyre\r\nMalawi','0995548992','+260777315753',NULL,NULL,'Nanga Unozge','briannkhata@gmail.com','briannkhata@gmail.com',NULL,0);

/*Table structure for table `tbl_suppliers` */

DROP TABLE IF EXISTS `tbl_suppliers`;

CREATE TABLE `tbl_suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_suppliers` */

insert  into `tbl_suppliers`(`supplier_id`,`name`,`address`,`phone`,`deleted`) values 
(57,'Self','Self','Self',0);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`user_id`,`name`,`phone`,`username`,`password`,`deleted`,`role`,`added_by`) values 
(1,'Admin','0','admin','21232f297a57a5a743894a0e4a801fc3',0,'0',1),
(6,'Cashier','+265 888 015 904','cash','84c8137f06fd53b0636e0818f3954cdb',0,'1',1),
(7,'YONA','088','yona','4f721f3163abd3d24e9bf0bbb6ba5ff3',0,'1',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
