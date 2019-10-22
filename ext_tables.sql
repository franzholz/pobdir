#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	tx_pobdir_directory tinyint(3) unsigned DEFAULT '1' NOT NULL
);  


#
# Table structure for table 'tx_pobdir_entry'
#
CREATE TABLE tx_pobdir_entry (
  uid int(11) unsigned NOT NULL AUTO_INCREMENT,
  pid int(11) unsigned DEFAULT NULL,
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  deleted tinyint(4) unsigned NOT NULL DEFAULT '0',
  hidden tinyint(4) unsigned NOT NULL DEFAULT '0',
  starttime int(11) unsigned NOT NULL DEFAULT '0',
  endtime int(11) unsigned NOT NULL DEFAULT '0',
  name tinytext CHARACTER SET utf8 NOT NULL,
  street tinytext NOT NULL,
  zip tinytext NOT NULL,
  city tinytext NOT NULL,
  tel tinytext NOT NULL,
  fax tinytext NOT NULL,
  mobil tinytext NOT NULL,
  email tinytext NOT NULL,
  www tinytext NOT NULL,
  profile text NOT NULL,
  image blob NOT NULL,
  category int(11) unsigned NOT NULL DEFAULT '0',
  map varchar(16) NOT NULL,
  description text NOT NULL,
  features varchar(32) NOT NULL,
  price tinytext NOT NULL,
  priceinfo text NOT NULL,
  stars tinyint(1) unsigned NOT NULL,
  capacity smallint(5) unsigned NOT NULL,
  ads tinytext NOT NULL,
  detail enum('0','1') NOT NULL,
  belongsto int(11) unsigned NOT NULL DEFAULT '0',
  do_not_filter tinyint(1) NOT NULL,
  mindestaufenthalt smallint(5) unsigned NOT NULL,
  pdf_info` text NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);                


#
# Table structure for table 'tx_pobdir_category'
#
CREATE TABLE tx_pobdir_category (
  uid int(11) unsigned NOT NULL AUTO_INCREMENT,
  pid int(11) unsigned DEFAULT NULL,
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  deleted tinyint(4) unsigned NOT NULL DEFAULT '0',
  hidden tinyint(4) unsigned NOT NULL DEFAULT '0',
  name tinytext NOT NULL,
  sorting int(11) NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);


#
# Table structure for table 'tx_pobdir_ad'
#
CREATE TABLE tx_pobdir_ad (
  uid int(11) unsigned NOT NULL AUTO_INCREMENT,
  pid int(11) unsigned DEFAULT NULL,
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  deleted tinyint(4) unsigned NOT NULL DEFAULT '0',
  name tinytext NOT NULL,
  ad text NOT NULL,
  hidden tinyint(4) unsigned NOT NULL DEFAULT '0',
 
  PRIMARY KEY (uid),
  KEY parent (pid)
);


#
# Table structure for table 'tx_pobdir_feature'
#
CREATE TABLE tx_pobdir_feature (
  uid int(11) unsigned NOT NULL AUTO_INCREMENT,
  pid int(11) unsigned DEFAULT NULL,
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  deleted tinyint(4) unsigned NOT NULL DEFAULT '0',
  name varchar(32) DEFAULT NULL,
  pikto varchar(32) DEFAULT NULL,
  title varchar(64) DEFAULT NULL,
  hidden tinyint(4) unsigned NOT NULL DEFAULT '0',
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);

#
# Table structure for table 'tx_pobdir_sperrzeiten'
#
CREATE TABLE tx_pobdir_sperrzeiten (
  uid int(11) unsigned NOT NULL AUTO_INCREMENT,
  pid int(11) unsigned DEFAULT NULL,
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  deleted tinyint(4) unsigned NOT NULL DEFAULT '0',
  hidden tinyint(4) unsigned NOT NULL DEFAULT '0',
  entry_uid int(11) unsigned NOT NULL,
  gesperrt_von int(11) NOT NULL,
  gesperrt_bis int(11) NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE VIEW tx_pobdir_v_entry AS 
SELECT e.*, c.sorting as cat_sorting 
FROM tx_pobdir_entry e, tx_pobdir_category c
WHERE e.category = c.uid
ORDER BY cat_sorting, name;