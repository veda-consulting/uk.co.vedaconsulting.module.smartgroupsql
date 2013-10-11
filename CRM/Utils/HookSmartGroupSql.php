<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.3                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2013                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 *
 * @package CiviCRM_Hook
 * @copyright CiviCRM LLC (c) 2004-2013
 * $Id: $
 *
 */

abstract class CRM_Utils_HookSmartGroupSql extends CRM_Utils_Hook {

  /**
   * This hook is called when composing the ACL where clause to restrict
   * visibility of contacts to the logged in user
   *
   * @param int    $type          the type of permission needed
   * @param int    $contactID     the contactID for whom the check is made
   * @param string $tableName     the tableName which is being permissioned
   * @param array  $allGroups     the set of all the objects for the above table
   * @param array  $currentGroups the set of objects that are currently permissioned for this contact
   *
   * @return null the return value is ignored
   * @access public
   */
  static function smartGroupWhereClause($groupID, &$sql) {
    return self::singleton()->invoke(2, $groupID, $sql,
      self::$_nullObject, self::$_nullObject, self::$_nullObject,
						'civicrm_smartGroupWhereClause');
  }
	
}
