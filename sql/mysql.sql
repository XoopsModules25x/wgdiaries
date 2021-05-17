# SQL Dump for wgdiaries module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Sun May 16, 2021 to 08:06:48
# Server version: 8.0.16
# PHP Version: 8.0.0

#
# Structure table for `wgdiaries_items` 6
#

CREATE TABLE `wgdiaries_items` (
  `item_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_groupid` INT(11) NOT NULL DEFAULT '0',
  `item_remarks` TEXT NOT NULL ,
  `item_datefrom` INT(11) NOT NULL DEFAULT '0',
  `item_dateto` INT(11) NOT NULL DEFAULT '0',
  `item_comments` INT(11) NOT NULL DEFAULT '0',
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

#
# Structure table for `wgdiaries_groups` 6
#

CREATE TABLE `wgdiaries_groups` (
  `grp_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grp_name` VARCHAR(255) NOT NULL DEFAULT '',
  `grp_logo` VARCHAR(255) NOT NULL DEFAULT '',
  `grp_online` INT(1) NOT NULL DEFAULT '0',
  `grp_datecreated` INT(11) NOT NULL DEFAULT '0',
  `grp_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`grp_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgdiaries_groupusers` 5
#

CREATE TABLE `wgdiaries_groupusers` (
  `gu_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gu_groupid` INT(10) NOT NULL DEFAULT '0',
  `gu_uid` INT(10) NOT NULL DEFAULT '0',
  `gu_datecreated` INT(11) NOT NULL DEFAULT '0',
  `gu_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gu_id`)
) ENGINE=InnoDB;

