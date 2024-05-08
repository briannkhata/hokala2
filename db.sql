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

/*Table structure for table `tbl_brands` */

DROP TABLE IF EXISTS `tbl_brands`;

CREATE TABLE `tbl_brands` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `desc` varchar(350) DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_brands` */

insert  into `tbl_brands`(`brand_id`,`brand_name`,`deleted`,`desc`) values 
(12,'COSMETICS',0,NULL),
(13,'Biscuits',0,NULL),
(14,'soaps',0,NULL),
(15,'Sweets',0,NULL);

/*Table structure for table `tbl_cart_move` */

DROP TABLE IF EXISTS `tbl_cart_move`;

CREATE TABLE `tbl_cart_move` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_cart_move` */

/*Table structure for table `tbl_cart_receive` */

DROP TABLE IF EXISTS `tbl_cart_receive`;

CREATE TABLE `tbl_cart_receive` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `cost_price` double DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  `expiry_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_cart_receive` */

insert  into `tbl_cart_receive`(`cart_id`,`product_id`,`user_id`,`price`,`qty`,`cost_price`,`total_cost`,`expiry_date`) values 
(66,1,1,5,3,5,15,'2024-05-02'),
(67,2,1,10000,5,10000,50000,'2024-05-03');

/*Table structure for table `tbl_cart_sales` */

DROP TABLE IF EXISTS `tbl_cart_sales`;

CREATE TABLE `tbl_cart_sales` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `qty` double NOT NULL,
  `vat` double NOT NULL,
  `sub_total` double NOT NULL,
  `total` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `sale_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_cart_sales` */

insert  into `tbl_cart_sales`(`cart_id`,`product_id`,`price`,`qty`,`vat`,`sub_total`,`total`,`user_id`,`shop_id`,`client_id`,`sale_type`) values 
(22,1,5,1,0.825,5,5.825,1,1,2,1),
(23,3,3500,1,577.5,3500,4077.5,1,1,2,1),
(24,4,500,2,165,1000,1165,1,1,2,1);

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `un_code` varchar(350) DEFAULT NULL,
  `desc` varchar(350) DEFAULT NULL,
  `category_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_category` */

insert  into `tbl_category`(`category_id`,`category`,`deleted`,`un_code`,`desc`,`category_code`) values 
(12,'COSMETICS',0,NULL,NULL,NULL),
(13,'Biscuits',0,NULL,NULL,NULL),
(14,'soaps',0,NULL,NULL,NULL),
(15,'Sweets',0,NULL,NULL,NULL);

/*Table structure for table `tbl_clients` */

DROP TABLE IF EXISTS `tbl_clients`;

CREATE TABLE `tbl_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_clients` */

insert  into `tbl_clients`(`client_id`,`name`,`email`,`password`,`address`,`username`,`phone`,`deleted`) values 
(1,'WALK-IN',NULL,NULL,NULL,NULL,'011111',0),
(2,'BRIAN NKHATA',NULL,NULL,'BLANTYRE',NULL,'0999',0),
(3,'Brian Henry Nkhata',NULL,NULL,'Blantyre',NULL,'0777315753',0),
(4,'Brian',NULL,NULL,'Blantyre',NULL,'0888015904',1),
(5,'Brian Nkhata',NULL,NULL,'Blantyre',NULL,'0888015904',0),
(6,'gigo',NULL,NULL,NULL,NULL,'07777777',0),
(7,'Chisomo Nkhata Phiri',NULL,NULL,NULL,NULL,'+265 888 015 904',0),
(8,'Jay',NULL,NULL,NULL,NULL,'099',0),
(9,'AKIMU',NULL,NULL,NULL,NULL,'099',0),
(10,'Savimbi',NULL,NULL,NULL,NULL,'',0),
(11,'Jerani',NULL,NULL,NULL,NULL,'',0),
(12,'Steve Kapoloma',NULL,NULL,NULL,NULL,'',0),
(13,'Steve Kapoloma2',NULL,NULL,NULL,NULL,'',0),
(14,'Brian Nkhata33',NULL,NULL,NULL,NULL,'',0),
(15,'Brian222',NULL,NULL,NULL,NULL,'',0),
(16,'Brian22222222',NULL,NULL,NULL,NULL,'',0),
(17,'WEZII',NULL,NULL,NULL,NULL,'',0),
(18,'WEZII999',NULL,NULL,NULL,NULL,'',0),
(19,'BRIAN NKHATA3333',NULL,NULL,NULL,NULL,'',0),
(20,'AKIMU',NULL,NULL,NULL,NULL,'088',0);

/*Table structure for table `tbl_menu_actions` */

DROP TABLE IF EXISTS `tbl_menu_actions`;

CREATE TABLE `tbl_menu_actions` (
  `menu_id` int(11) DEFAULT NULL,
  `action` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `position` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_menu_actions` */

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
(13,0,2,'New Sale','Sale','arrow_right',1,'New Sale','web_asset',2,'0,1'),
(16,3,1,'Categories','Category','arrow_right',0,'Product Management','web_asset',3,'0'),
(18,5,1,'Suppliers','Supplier','group',0,'User Management','group',3,'0'),
(19,5,3,'Users','User','group',0,'User Management','group',3,'0'),
(20,6,0,'Dashboard','Dashboard','home',1,'Dashboard','home',1,'0,1'),
(21,2,3,'Expiring','Report/expiring','arrow_right',0,'Reports','receipt_long',5,'0'),
(22,4,1,'Config','Config','arrow_right',0,'Settings','settings',4,'0'),
(23,2,4,'Expired','Report/expired','arrow_right',0,'Reports','receipt_long',5,'0'),
(24,2,5,'Depleted','Report/depleted','arrow_right',0,'Reports','receipt_long',5,'0'),
(25,2,6,'Running Low','Report/running_low','arrow_right',0,'Reports','receipt_long',5,'0'),
(26,3,3,'Receive Stock','Receive','arrow_right',0,'Product Management','web_asset',3,'0'),
(27,2,7,'Receivings/Orders','Report/receivings_report','arrow_right',0,'Reports','receipt_long',5,'0'),
(28,4,3,'Shops','Shop','arrow_right',0,'Settings','settings',4,'0'),
(29,4,2,'Warehouses','Warehouse','arrow_right',0,'Settings','settings',4,'0'),
(30,4,4,'Shifts','Shift','arrow_right',0,'Settings','settings',4,NULL),
(31,5,2,'Roles','Role','group',0,'User Management','group',3,'0'),
(32,3,4,'Move Stock','Move','arrow_right',0,'Product Management','web_asset',3,'0'),
(33,3,5,'Return Stock','Riteni','arrow_right',0,'Product Management','web_asset',3,'0'),
(34,3,6,'Order Requests','Order','arrow_right',0,'Product Management','web_asset',3,'0'),
(35,4,5,'Units','Unit','arrow_right',0,'Settings','settings',4,'0'),
(36,5,4,'Clients','Client','group',0,'User Management','group',3,'0'),
(37,4,6,'Payment Types','Payment_type','arrow_right',0,'Settings','settings',4,'0'),
(38,3,7,'Adjust Prices','AdjustPrice','arrow_right',0,'Product Management','web_asset',3,'0');

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

/*Table structure for table `tbl_payment_types` */

DROP TABLE IF EXISTS `tbl_payment_types`;

CREATE TABLE `tbl_payment_types` (
  `payment_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `details` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`payment_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_payment_types` */

insert  into `tbl_payment_types`(`payment_type_id`,`payment_type`,`details`,`deleted`) values 
(1,'CASH','CASH',0),
(2,'MO','3726723',0),
(3,'VISA','VISA',0),
(4,'MPAMBA','MPAMBA',0),
(5,'AIRTEL MONEY','AIRTEL MONEY',0);

/*Table structure for table `tbl_payments` */

DROP TABLE IF EXISTS `tbl_payments`;

CREATE TABLE `tbl_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_date` datetime DEFAULT NULL,
  `total_bill` double DEFAULT NULL,
  `payment_amount` double DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_payments` */

insert  into `tbl_payments`(`payment_id`,`payment_date`,`total_bill`,`payment_amount`,`sale_id`,`client_id`,`user_id`,`shop_id`,`payment_type_id`) values 
(1,'2024-04-01 03:04:10',6990,7000,1,1,1,1,1),
(2,'2024-04-01 03:04:10',0,7000,2,1,1,1,1),
(3,'2024-04-01 03:04:10',0,7000,3,1,1,1,1),
(4,'2024-04-01 03:04:10',0,7000,4,1,1,1,1),
(5,'2024-04-01 03:04:39',12815,13000,5,1,1,1,1),
(6,'2024-04-01 03:04:39',0,13000,6,1,1,1,1),
(7,'2024-04-01 03:04:39',0,13000,7,1,1,1,1),
(8,'2024-04-01 03:04:39',0,13000,8,1,1,1,1),
(9,'2024-04-01 03:04:39',0,13000,9,1,1,1,1),
(10,'2024-04-01 03:04:24',10485,11000,10,1,1,1,1),
(11,'2024-04-01 03:04:24',0,11000,11,1,1,1,1),
(12,'2024-04-01 03:04:24',0,11000,12,1,1,1,1),
(13,'2024-04-01 03:04:24',0,11000,13,1,1,1,1),
(14,'2024-04-01 03:04:24',0,11000,14,1,1,1,1),
(15,'2024-04-01 03:04:33',6990,7000,15,1,1,1,1),
(16,'2024-04-01 03:04:34',0,7000,16,1,1,1,1),
(17,'2024-04-01 03:04:34',0,7000,17,1,1,1,1),
(18,'2024-04-01 03:04:34',0,7000,18,1,1,1,1),
(19,'2024-04-01 04:04:47',10485,11000,19,1,1,1,1),
(20,'2024-04-01 04:04:47',0,11000,20,1,1,1,1),
(21,'2024-04-01 04:04:47',0,11000,21,1,1,1,1),
(22,'2024-04-01 04:04:47',0,11000,22,1,1,1,1),
(23,'2024-04-01 04:04:48',0,11000,23,1,1,1,1),
(24,'2024-04-01 04:04:39',5242.5,5500,24,3,1,1,1),
(25,'2024-04-01 04:04:39',0,5500,25,3,1,1,1),
(26,'2024-04-01 04:04:39',0,5500,26,3,1,1,1),
(27,'2024-04-01 04:04:39',0,5500,27,3,1,1,1),
(28,'2024-04-01 04:04:39',0,5500,28,3,1,1,1),
(29,'2024-04-01 04:04:26',5825,6000,29,1,1,1,1),
(30,'2024-04-01 04:04:26',0,6000,30,1,1,1,1),
(31,'2024-04-01 04:04:26',0,6000,31,1,1,1,1),
(32,'2024-04-01 04:04:40',8155,10000,32,1,1,1,1),
(33,'2024-04-01 04:04:40',0,10000,33,1,1,1,1),
(34,'2024-04-01 04:04:40',0,10000,34,1,1,1,1),
(35,'2024-04-01 04:04:40',0,10000,35,1,1,1,1),
(36,'2024-04-01 04:04:00',2330,3000,36,1,1,1,1),
(37,'2024-04-01 04:04:00',0,3000,37,1,1,1,1),
(38,'2024-04-01 04:04:01',0,3000,38,1,1,1,1),
(39,'2024-04-01 04:04:01',0,3000,39,1,1,1,1),
(40,'2024-04-01 04:04:01',0,3000,40,1,1,1,1),
(41,'2024-04-01 04:04:01',0,3000,41,1,1,1,1),
(42,'2024-04-01 04:04:57',2330,3000,42,1,1,1,1),
(43,'2024-04-01 04:04:57',0,3000,43,1,1,1,1),
(44,'2024-04-01 04:04:58',0,3000,44,1,1,1,1),
(45,'2024-04-01 04:04:58',0,3000,45,1,1,1,1),
(46,'2024-04-01 04:04:58',0,3000,46,1,1,1,1),
(47,'2024-04-01 04:04:58',0,3000,47,1,1,1,1),
(48,'2024-04-01 04:04:39',5825,6000,48,1,1,1,1),
(49,'2024-04-01 04:04:39',0,6000,49,1,1,1,1),
(50,'2024-04-01 04:04:39',0,6000,50,1,1,1,1);

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
  `expiry_date` varchar(100) DEFAULT NULL,
  `selling_price` double DEFAULT NULL,
  `reorder_level` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `promo_price` double DEFAULT NULL,
  `on_promotion` int(1) NOT NULL DEFAULT 0,
  `image` varchar(250) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `index_assetID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9539 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_products` */

insert  into `tbl_products`(`product_id`,`name`,`barcode`,`category_id`,`desc`,`date_added`,`added_by`,`deleted`,`expiry_date`,`selling_price`,`reorder_level`,`unit_id`,`modified_date`,`modified_by`,`promo_price`,`on_promotion`,`image`,`brand_id`) values 
(1,'GEISHA','111111',14,'GEISHS','2024-03-10 18:49:11',0,0,'2024-04-12 00:00:00',5,5,1,'2024-03-31 00:00:00',1,NULL,0,NULL,NULL),
(2,'PROTEX','222222',14,'PINK','2024-03-10 18:50:52',0,0,'2024-04-20',10000,5,1,NULL,NULL,NULL,0,NULL,NULL),
(3,'POLISH','333333',12,'BLACK','2024-03-10 20:31:42',0,0,'2024-03-31 00:00:00',3500,5,1,NULL,NULL,NULL,0,NULL,NULL),
(4,'BISCUIT','444444',12,'PANADO EXTRA','2024-03-10 20:31:42',0,0,'2024-03-31 00:00:00',500,5,2,'2024-04-01 00:00:00',1,NULL,0,NULL,NULL),
(5,'LOTION','555555',12,'NENIA','2024-03-10 20:31:42',0,0,'2024-03-31 00:00:00',3500,5,1,NULL,NULL,NULL,0,NULL,NULL),
(6,'BISCUIT POWE','444444',12,'GLUCO','2024-03-10 20:31:42',0,0,'2024-03-31 00:00:00',3500,5,1,NULL,NULL,NULL,0,NULL,NULL),
(9538,'BEEFBEEFBEEFBEEFBEEFBEEFBEEFBEEFBEEFBEEFBEEFBEEFBEEFBEEF','888888',13,'GOOD MEAT','2024-04-10 14:08:46',0,0,'2024-05-05',3000,1,1,NULL,NULL,NULL,0,NULL,NULL);

/*Table structure for table `tbl_quantities` */

DROP TABLE IF EXISTS `tbl_quantities`;

CREATE TABLE `tbl_quantities` (
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`qty`,`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_quantities` */

insert  into `tbl_quantities`(`product_id`,`qty`,`shop_id`) values 
(1,96,1),
(2,96,1),
(2,130,2),
(3,97,1),
(4,98,1),
(5,96,1),
(6,100,1),
(9538,100,1),
(9538,180,2);

/*Table structure for table `tbl_receive_details` */

DROP TABLE IF EXISTS `tbl_receive_details`;

CREATE TABLE `tbl_receive_details` (
  `receive_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `cost_price` double DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  `receive_id` int(11) DEFAULT NULL,
  `receive_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expiry_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`receive_detail_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_receive_details` */

insert  into `tbl_receive_details`(`receive_detail_id`,`product_id`,`price`,`qty`,`cost_price`,`total_cost`,`receive_id`,`receive_date`,`user_id`,`expiry_date`) values 
(1,9538,NULL,50,9,450,1,'2024-04-10 23:27:47',1,'2024-04-25'),
(2,2,2000,8,80000,640000,1,'2024-04-10 23:27:47',1,'2024-04-28'),
(3,1,5000,1,5,5,1,'2024-04-10 23:27:47',1,'2024-04-28'),
(4,4,500,1,500,500,1,'2024-04-10 23:27:47',1,'2024-04-30'),
(5,1,5,5,5,25,2,'2024-04-11 07:17:24',1,'2024-04-12'),
(6,2,2,9,2,18,2,'2024-04-11 07:17:24',1,'2024-04-19'),
(7,2,10000,30,8000,240000,3,'2024-04-11 08:02:04',1,'2024-04-20'),
(8,9538,3000,80,2500,200000,3,'2024-04-11 08:02:04',1,'2024-05-05');

/*Table structure for table `tbl_receivings` */

DROP TABLE IF EXISTS `tbl_receivings`;

CREATE TABLE `tbl_receivings` (
  `receiving_id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_date` datetime DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `order_details` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `total_cost` double DEFAULT NULL,
  PRIMARY KEY (`receiving_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_receivings` */

insert  into `tbl_receivings`(`receiving_id`,`receive_date`,`supplier_id`,`order_details`,`user_id`,`shop_id`,`warehouse_id`,`total_cost`) values 
(1,'2024-04-10 11:04:47',57,'ddddtest',1,2,NULL,640955),
(2,'2024-04-11 07:04:24',57,'09991',1,NULL,4,43),
(3,'2024-04-11 08:04:04',57,'09991',1,2,NULL,440000);

/*Table structure for table `tbl_roles` */

DROP TABLE IF EXISTS `tbl_roles`;

CREATE TABLE `tbl_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_roles` */

insert  into `tbl_roles`(`role_id`,`role`,`deleted`) values 
(1,'ADMINISTRATOR',0),
(2,'CASHIER',0);

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
  `sub_total` double DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `sale_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_detail_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_sale_details` */

insert  into `tbl_sale_details`(`sale_detail_id`,`product_id`,`price`,`qty`,`vat`,`total`,`sale_id`,`sale_date`,`sub_total`,`user_id`,`shop_id`,`client_id`,`sale_type`) values 
(1,5,3500,3,1732.5,12232.5,2,'2024-04-11 07:04:47',10500,1,1,1,NULL),
(2,3,3500,2,1155,8155,2,'2024-04-11 07:04:47',7000,1,1,1,NULL),
(3,5,3500,1,577.5,4077.5,3,'2024-04-11 08:04:50',3500,1,1,1,NULL);

/*Table structure for table `tbl_sales` */

DROP TABLE IF EXISTS `tbl_sales`;

CREATE TABLE `tbl_sales` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sale_date` datetime NOT NULL,
  `tendered` double DEFAULT NULL,
  `change` double DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `sub_total` double DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `details` varchar(300) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `sale_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_sales` */

insert  into `tbl_sales`(`sale_id`,`user_id`,`sale_date`,`tendered`,`change`,`vat`,`total`,`shop_id`,`sub_total`,`client_id`,`payment_type_id`,`details`,`balance`,`sale_type`) values 
(1,1,'2024-04-11 07:04:20',21000,612.5,2887.5,20387.5,1,17500,1,1,'',-612.5,1),
(2,1,'2024-04-11 07:04:47',21000,612.5,2887.5,20387.5,1,17500,1,1,'',-612.5,1),
(3,1,'2024-04-11 08:04:50',5000,922.5,577.5,4077.5,1,3500,1,1,'',-922.5,1);

/*Table structure for table `tbl_settings` */

DROP TABLE IF EXISTS `tbl_settings`;

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alt_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alt_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expire_alert_days` int(11) DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `vat_status` varchar(200) DEFAULT NULL,
  `installments` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_settings` */

insert  into `tbl_settings`(`id`,`address`,`phone`,`alt_phone`,`logo`,`company`,`email`,`alt_email`,`expire_alert_days`,`vat`,`vat_status`,`installments`) values 
(1,'Blantyre\r\nMalawi','0995548992','+260777315753','./assets/uploads/Screenshot 2023-08-12 202203 - Copy (3).png','Nanga Unozge','briannkhata@gmail.com','briannkhata@gmail.com',20,16.5,'exclude',1);

/*Table structure for table `tbl_shifts` */

DROP TABLE IF EXISTS `tbl_shifts`;

CREATE TABLE `tbl_shifts` (
  `shift_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` varchar(100) DEFAULT NULL,
  `end_time` varchar(100) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_shifts` */

insert  into `tbl_shifts`(`shift_id`,`name`,`start_time`,`end_time`,`deleted`) values 
(1,'MORNING SHIFT','06:00','12:00',0),
(2,'AFTERNOON','12:01','18:00',0),
(3,'EVENING','18:01','00:00',0);

/*Table structure for table `tbl_shops` */

DROP TABLE IF EXISTS `tbl_shops`;

CREATE TABLE `tbl_shops` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_shops` */

insert  into `tbl_shops`(`shop_id`,`name`,`description`,`deleted`) values 
(1,'LUNZU','NEAR M1 ROAD',0),
(2,'THYOLO','THYOLO',0);

/*Table structure for table `tbl_stock_movements` */

DROP TABLE IF EXISTS `tbl_stock_movements`;

CREATE TABLE `tbl_stock_movements` (
  `stock_movement_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `from_shop` int(11) DEFAULT NULL,
  `to_shop` int(11) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `from_wh` int(11) DEFAULT NULL,
  `to_wh` int(11) DEFAULT NULL,
  `date_moved` datetime DEFAULT NULL,
  `description` varchar(350) DEFAULT NULL,
  PRIMARY KEY (`stock_movement_id`),
  KEY `index_auditasset_ID` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_stock_movements` */

insert  into `tbl_stock_movements`(`stock_movement_id`,`product_id`,`user_id`,`qty`,`from_shop`,`to_shop`,`receiver`,`from_wh`,`to_wh`,`date_moved`,`description`) values 
(1,1,1,7,NULL,1,7,1,NULL,'2024-04-10 11:51:09','kuyesanso'),
(2,2,1,5,NULL,1,7,1,NULL,'2024-04-10 11:51:09','kuyesanso'),
(3,1,1,2,NULL,1,NULL,1,NULL,'2024-04-10 11:53:41','kachikena'),
(4,2,1,3,NULL,1,NULL,1,NULL,'2024-04-10 11:53:41','kachikena'),
(5,1,1,1,NULL,1,7,1,NULL,'2024-04-10 11:57:43','TESTING'),
(6,2,1,3,NULL,1,7,1,NULL,'2024-04-10 11:57:43','TESTING'),
(7,1,1,2,NULL,1,7,1,NULL,'2024-04-10 12:03:14','TESTING'),
(8,2,1,6,NULL,1,7,1,NULL,'2024-04-10 12:03:14','TESTING'),
(9,1,1,2,NULL,1,7,1,NULL,'2024-04-10 12:07:21','KACHIKENA'),
(10,2,1,2,NULL,1,7,1,NULL,'2024-04-10 12:07:21','KACHIKENA'),
(11,1,1,2,NULL,1,7,1,NULL,'2024-04-10 12:08:44','again'),
(12,2,1,3,NULL,1,7,1,NULL,'2024-04-10 12:08:44','again'),
(13,1,1,4,NULL,1,7,1,NULL,'2024-04-10 12:14:27',''),
(14,2,1,4,NULL,1,7,1,NULL,'2024-04-10 12:14:27',''),
(15,1,1,3,NULL,NULL,7,NULL,NULL,'2024-04-10 18:27:40','shop to shop test'),
(16,2,1,3,NULL,NULL,7,NULL,NULL,'2024-04-10 18:27:40','shop to shop test'),
(17,1,1,4,2,1,7,NULL,NULL,'2024-04-10 18:30:06','shop to shop Testing'),
(18,2,1,4,2,1,7,NULL,NULL,'2024-04-10 18:30:06','shop to shop Testing'),
(19,1,1,4,2,1,7,NULL,NULL,'2024-04-10 18:42:52','another test'),
(20,2,1,4,2,1,7,NULL,NULL,'2024-04-10 18:42:52','another test'),
(21,9538,1,3,1,NULL,NULL,NULL,4,'2024-04-10 18:49:42',''),
(22,9538,1,3,NULL,NULL,7,NULL,4,'2024-04-10 18:53:29','shop to warehiuse'),
(23,9538,1,3,2,NULL,7,NULL,4,'2024-04-10 18:57:57','testing'),
(24,9538,1,9,NULL,NULL,7,4,2,'2024-04-10 19:08:35','yyyyyy'),
(25,9538,1,9,NULL,NULL,NULL,2,4,'2024-04-10 19:13:55',''),
(26,9538,1,9,NULL,NULL,6,4,2,'2024-04-10 19:16:39','rrrr');

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

/*Table structure for table `tbl_units` */

DROP TABLE IF EXISTS `tbl_units`;

CREATE TABLE `tbl_units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_type` varchar(200) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `desc` varchar(300) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_units` */

insert  into `tbl_units`(`unit_id`,`unit_type`,`qty`,`desc`,`deleted`) values 
(1,'Each',1,'Each',0),
(2,'Pack',2,'Pack',0);

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
  `shop_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`user_id`,`name`,`phone`,`username`,`password`,`deleted`,`role`,`added_by`,`shop_id`) values 
(1,'Admin','0','admin','21232f297a57a5a743894a0e4a801fc3',0,'0',1,1),
(6,'Cashier','+265 888 015 904','cash','84c8137f06fd53b0636e0818f3954cdb',0,'1',1,1),
(7,'YONA','088','yona','4f721f3163abd3d24e9bf0bbb6ba5ff3',0,'1',1,1);

/*Table structure for table `tbl_warehouses` */

DROP TABLE IF EXISTS `tbl_warehouses`;

CREATE TABLE `tbl_warehouses` (
  `warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `country` varchar(300) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_warehouses` */

insert  into `tbl_warehouses`(`warehouse_id`,`name`,`description`,`deleted`,`country`,`city`) values 
(1,'MCHINJI','FOR SOYA',0,NULL,NULL),
(2,'LILONGWE','FOR ENERGY DRINK',0,NULL,NULL),
(3,'MZUZU','FOR CLOTHES',0,NULL,NULL),
(4,'BLANTYRE','ASSORTED AND MAIN BRANCH',0,NULL,NULL);

/*Table structure for table `tbl_wh_quantities` */

DROP TABLE IF EXISTS `tbl_wh_quantities`;

CREATE TABLE `tbl_wh_quantities` (
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`qty`,`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `tbl_wh_quantities` */

insert  into `tbl_wh_quantities`(`product_id`,`qty`,`warehouse_id`) values 
(1,4000,1),
(1,4005,4),
(2,4000,1),
(2,4009,4),
(3,4000,1),
(3,4000,4),
(4,4000,1),
(4,4000,4),
(5,4000,1),
(5,4000,4),
(6,4000,1),
(6,4000,4),
(9538,4000,1),
(9538,4000,4),
(9538,4009,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
