CREATE TABLE `civicrm_group_additional_where_clause` (
  `id`              int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Where Clause ID',
  `group_id`        int(10) unsigned DEFAULT NULL COMMENT 'FK to group table.',
  `description`     text COLLATE utf8_unicode_ci COMMENT 'Description of where clause',
  `where_clause`    text COLLATE utf8_unicode_ci COMMENT 'the sql where clause',
  `is_active`       tinyint(4) DEFAULT NULL COMMENT 'Is this entry active?',
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_civicrm_group_additional_where_clause_group_id` FOREIGN KEY (`group_id`) REFERENCES `civicrm_group` (`id`) ON DELETE SET NULL
);
