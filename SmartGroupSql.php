<?php

require_once 'SmartGroupSql.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function smartgroupsql_civicrm_config(&$config) {
  _smartgroupsql_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function smartgroupsql_civicrm_xmlMenu(&$files) {
  _smartgroupsql_civix_civicrm_xmlMenu($files);
}

function smartgroupsql_civicrm_smartGroupWhereClause( $grouID, &$sql) {

    $selectSql  = " SELECT where_clause ";
    $selectSql .= " FROM civicrm_group_additional_where_clause ";
    $selectSql .= " WHERE is_active = 1 "; 
    $selectSql .= " AND group_id    = %1 "; 

    $selectParams = array( 1 => array( (int)$grouID, 'Integer' ), 
                   );
    $dao = CRM_Core_DAO::executeQuery( $selectSql, $selectParams );

    if ($dao->fetch()) {  
      $whereClause = ' '.$dao->where_clause;
    }
    else {
        $whereClause = ' ';         
    }
    $sql .= $whereClause;
print($sql);			
}    

/**
 * Implementation of hook_civicrm_install
 */
function smartgroupsql_civicrm_install() {

//  register_install();

  // On install, create a table for keeping track of online direct debits
  require_once "CRM/Core/DAO.php";
  CRM_Core_DAO::executeQuery("
      CREATE TABLE IF NOT EXISTS  `civicrm_group_additional_where_clause` (
        `id`              int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Where Clause ID',
        `group_id`        int(10) unsigned DEFAULT NULL COMMENT 'FK to group table.',
        `description`     text    COLLATE utf8_unicode_ci COMMENT 'Description of where clause',
        `where_clause`    text    COLLATE utf8_unicode_ci COMMENT 'the sql where clause',
        `is_active`       tinyint(4) DEFAULT NULL COMMENT 'Is this entry active?',
        PRIMARY KEY (`id`),
        CONSTRAINT `FK_civicrm_group_additional_where_clause_group_id` FOREIGN KEY (`group_id`) REFERENCES `civicrm_group` (`id`) ON DELETE SET NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
  ");

  return _smartgroupsql_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function smartgroupsql_civicrm_uninstall() {
  return _smartgroupsql_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function smartgroupsql_civicrm_enable() {
  return _smartgroupsql_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function smartgroupsql_civicrm_disable() {
  return _smartgroupsql_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function smartgroupsql_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _smartgroupsql_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function smartgroupsql_civicrm_managed(&$entities) {
  return _smartgroupsql_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function smartgroupsql_civicrm_buildForm($formName, &$form) {
	
	// Should only allow link to add SQL Criteria if smart group
	// currently this isn't working though!
	if ($formName == 'CRM_Group_Form_Edit') {
		//&& $form->getVar('saved_search_id') > 0) {
		//print_r($form);
		//print($form->getVar('saved_search_id'));
		$groupID = $form->getVar('_id');
		$form->assign('SQLQueryGroupId', $groupID);
		//die;
	}
}
