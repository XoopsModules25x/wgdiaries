# SQL Dump for wgdiaries module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Tue May 25, 2021 to 08:07:00
# Server version: 5.5.5-10.4.10-MariaDB
# PHP Version: 8.0.1

#
# Structure table for `wgdiaries_items` 11
#

CREATE TABLE `wgdiaries_items` (
  `item_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_groupid` INT(10) NOT NULL DEFAULT '0',
  `item_name` VARCHAR(255) NOT NULL DEFAULT '',
  `item_remarks` TEXT NOT NULL ,
  `item_datefrom` INT(11) NOT NULL DEFAULT '0',
  `item_dateto` INT(11) NOT NULL DEFAULT '0',
  `item_catid` INT(10) NOT NULL DEFAULT '0',
  `item_tags` VARCHAR(255) NOT NULL DEFAULT '',
  `item_logo` VARCHAR(255) NOT NULL DEFAULT '',
  `item_comments` INT(10) NOT NULL DEFAULT '0',
  `item_datecreated` INT(11) NOT NULL DEFAULT '0',
  `item_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgdiaries_files` 7
#

CREATE TABLE `wgdiaries_files` (
  `file_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_itemid` INT(10) NOT NULL DEFAULT '0',
  `file_name` VARCHAR(255) NOT NULL DEFAULT '',
  `file_desc` VARCHAR(255) NOT NULL DEFAULT '',
  `file_mimetype` VARCHAR(255) NOT NULL DEFAULT '',
  `file_datecreated` INT(11) NOT NULL DEFAULT '0',
  `file_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgdiaries_categories` 5
#

CREATE TABLE `wgdiaries_categories` (
  `cat_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_name` VARCHAR(255) NOT NULL DEFAULT '',
  `cat_logo` VARCHAR(255) NOT NULL DEFAULT '',
  `cat_online` INT(1) NOT NULL DEFAULT '1',
  `cat_weight` INT(10) NOT NULL DEFAULT '0',
  `cat_datecreated` INT(11) NOT NULL DEFAULT '0',
  `cat_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB;

