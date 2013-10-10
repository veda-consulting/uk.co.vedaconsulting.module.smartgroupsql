<?php

/*
 +--------------------------------------------------------------------+
 | CiviCRM version 3.3                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2010                                |
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
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2010
 * $Id$
 *
 */

require_once 'CRM/Core/Form.php';
require_once 'CRM/Core/Session.php';

/**
 * This class provides the functionality to maintain an extra 
 * WHERE Clause condition associated with a Smart Group
 */

class CRM_SmartGroupSql_Form_SmartGroupSql extends CRM_Core_Form {

    /**
     * build all the data structures needed to build the form
     *
     * @return void
     * @access public
     */
    function preProcess()
  {
        parent::preProcess( );
        
        return false;

    }

    /**
     * Build the form
     *
     * @access public
     * @return void
     */
    function buildQuickForm( ) {

        require_once 'CRM/Core/Config.php';
        $config = CRM_Core_Config::singleton();
          
        // Here, incase,  but currently don't use Id in build Form Logic
        $id = CRM_Utils_Array::value('id', $_GET, '');
        $groupId = CRM_Utils_Array::value('gid', $_GET, '');

        if(empty($groupId)) {
            $groupId = CRM_Utils_Array::value('gid', $_POST, '');
        }

				if (empty($groupId)) {
        
//            $groupId     = null;
            $description = '';
            $whereClause = '';
            $isActive    = 0;
        }
        else {
        
            $selectSql  = " SELECT id ";
            $selectSql .= " ,      group_id ";
            $selectSql .= " ,      description ";
            $selectSql .= " ,      where_clause ";
            $selectSql .= " ,      is_active ";
            $selectSql .= " FROM civicrm_group_additional_where_clause ";
            $selectSql .= " WHERE group_id = %1 "; 

            $selectParams = array( 1 => array( $groupId, 'Integer' ), 
                           );
            $dao = CRM_Core_DAO::executeQuery( $selectSql, $selectParams );

            if ($dao->fetch()) {  
              $id          = $dao->id;
              $groupId     = $dao->group_id;
              $description = $dao->description;
              $whereClause = $dao->where_clause;
              $isActive    = $dao->is_active;
            }
            else {
                $description = '';
                $whereClause = 'AND 1=1';         
                $isActive    = 0;
            }
  
        }

        $smartGroupQuery = self::getSmartGroupQuery($groupId);        
        $queryCounts = self::getQueryCounts($smartGroupQuery, $whereClause); 

        $smartGroupQueryCount = $queryCounts['smart_group_count'];
        $whereClauseCount     = $queryCounts['where_clause_count'];        

        $this->assign( 'groupName', 'Group Name' );

        $this->addElement('hidden', 'id', $id );                            
        $this->addElement('hidden', 'gid', $groupId );                            

        $this->add('text', 'description', ts('Description'), array('size' => 80, 'maxlength' => 100), TRUE);
        $this->getElement('description')->setValue($description);

        $this->add('textarea', 'smart_group_query', ts('Group Query'), array('rows' => 15, 'cols' => 100), FALSE);
        $this->getElement('smart_group_query')->setValue($smartGroupQuery);

        $this->assign( 'smart_group_query_count', $smartGroupQueryCount );

        $this->add('textarea', 'where_clause', ts('Where Clause'), array('rows' => 5, 'cols' => 100), TRUE);
        $this->getElement('where_clause')->setValue($whereClause);

        $this->assign( 'where_clause_count', $whereClauseCount );

        $this->addElement('checkbox', 'where_clause_active', ts('Where Clause Active'), null, null);
        $defaults['where_clause_active'] = $isActive;
        $this->setDefaults( $defaults ); 
//die;  

        $this->addButtons(array( 
                                        array ( 'type'      => 'next', 
                                                'name'      => ts('Save'), 
                                                'subName'   => 'save', 
                                                'isDefault' => false   ), 
                                        array ( 'type'      => 'next', 
                                                'name'      => ts('Validate'), 
                                                'subName'   => 'validate', 
                                                'isDefault' => false   ), 
                                        array ( 'type'      => 'cancel', 
                                                'name'      => ts('Cancel'), 
                                                'subName'   => 'cancel', 
                                                'isDefault' => false ),
//                                                'js' => 'onClick="window.location=\'{crmURL p=\'civicrm/group\' q=\'reset=1\'}\';return false;"' ), 
                                        ) 
                                  );

    } //end of function buildQuickForm

    /**
     * process the form after the input has been submitted and validated
     *
     * @access public
     * @return None
     */
    public function postProcess() {

        $params = $this->_submitValues;

        $whereClauseId = $params['id'];
        $groupId       = $params['gid'];
        $description   = $params['description'];
        $whereClause   = $params['where_clause'];
        $isActive      = $params['where_clause_active'];

        if (empty($whereClauseId)) {
            //Insert
            $insertSql  = " INSERT INTO civicrm_group_additional_where_clause SET ";
            $insertSql .= " group_id     = %1, ";
            $insertSql .= " description  = %2, ";
            $insertSql .= " where_clause = %3, "; 
            $insertSql .= " is_active    = %4 "; 

            $insertParams = array( 1 => array((int)$groupId,        'Int'),
                                   2 => array((string)$description, 'String'),
                                   3 => array((string)$whereClause, 'String'),
                                   4 => array((int)$isActive,       'Int'),
                                 ); 

            CRM_Core_DAO::executeQuery($insertSql, $insertParams);  

        }
        else {
            //Update
            $updateSql  = " UPDATE civicrm_group_additional_where_clause SET ";
            $updateSql .= " group_id     = %1, ";
            $updateSql .= " description  = %2, ";
            $updateSql .= " where_clause = %3, ";
            $updateSql .= " is_active    = %4 ";
            $updateSql .= " WHERE id     = %5 ";

            $updateParams = array( 1 => array((int)$groupId,        'Int'),
                                   2 => array((string)$description, 'String'),
                                   3 => array((string)$whereClause, 'String'),
                                   4 => array((int)$isActive,       'Int'),
                                   5 => array($whereClauseId,       'Int'),
                                 ); 

            CRM_Core_DAO::executeQuery($updateSql, $updateParams);   

        }

    }//end of function postProcess

  function getSmartGroupQuery($groupId) {
  
      $this->_formValues['group'][$groupId] = 1;

      $this->_params = CRM_Contact_BAO_Query::convertFormValues($this->_formValues);

      $query = CRM_Contact_BAO_Query::getQuery($this->_params);
      
      return $query;

  }
  
  function getQueryCounts($smartGroupQuery, $whereClause) {

      $queryCounts = array();
      
      // Number of records returned by Smart Group Query
      $queryCount1  = " SELECT COUNT(1) AS query_count_1 ";
      $queryCount1 .= " FROM ( ";
      $queryCount1 .= $smartGroupQuery;
      $queryCount1 .= " ) query1 ";

      // Number of records returned by Smart Group Query using additional WHERE Clause
      $queryCount2  = " SELECT COUNT(1) AS query_count_2 ";
      $queryCount2 .= " FROM ( ";
      $queryCount2 .= $smartGroupQuery;
      $queryCount2 .= " ";
      $queryCount2 .= $whereClause;
      $queryCount2 .= " ) query2 ";

      $count1Dao = CRM_Core_DAO::executeQuery( $queryCount1 );

      if ($count1Dao->fetch()) {  
        $queryCount1 = $count1Dao->query_count_1;
      }

      try {
            $count2Dao = CRM_Core_DAO::executeQuery( $queryCount2 );

            if ($count2Dao->fetch()) {  
              $queryCount2 = $count2Dao->query_count_2;
            }
      }
      catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
      }

   
      $queryCounts['smart_group_count'] = $queryCount1;
      $queryCounts['where_clause_count'] = $queryCount2;
  
      return $queryCounts;
      
  }      
    
}
