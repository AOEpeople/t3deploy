CREATE TABLE pages (
  tx_testextension_field_test varchar(64) NOT NULL default '',
  alias varchar(255) NOT NULL default ''
);

CREATE TABLE tx_testextension_test (
  id int(11) NOT NULL auto_increment,
  identifier varchar(250) NOT NULL default '',
  tag varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB;