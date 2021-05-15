# SQL Dump for wfh diaries module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Sat May 15, 2021 to 06:51:25
# Server version: 8.0.16
# PHP Version: 7.4.4

#
# Structure table for `wgdiaries_items` 6
#

CREATE TABLE `wgdiaries_items` (
  `item_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_remarks` TEXT NOT NULL ,
  `item_datefrom` INT(11) NOT NULL DEFAULT '0',
  `item_dateto` INT(11) NOT NULL DEFAULT '0',
  `item_datecreated` INT(11) NOT NULL DEFAULT '0',
  `item_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgdiaries_files` 6
#

CREATE TABLE `wgdiaries_files` (
  `file_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_itemid` INT(10) NOT NULL DEFAULT '0',
  `file_desc` VARCHAR(255) NOT NULL DEFAULT '',
  `file_name` VARCHAR(255) NOT NULL DEFAULT '',
  `file_datecreated` INT(11) NOT NULL DEFAULT '0',
  `file_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB;

