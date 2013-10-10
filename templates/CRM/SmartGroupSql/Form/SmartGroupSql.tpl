{*
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
*}

<div class="content" >

<h3>{ts}{$groupName}{/ts}</h3>

    <table>
    <tr>
      <td>
        <div style="float: left; margin: 5px;">
            <table>
              <thead></thead>
              <tbody>
                   <tr><td>{$form.description.label}</td><td>{$form.description.html}</td></tr>
                   <tr><td>{$form.smart_group_query.label}</td><td>{$form.smart_group_query.html}</td></tr>
                   <tr><td></td><td>Smart Group Query Returns {$smart_group_query_count} Records</td></tr>
                   <tr><td>{$form.where_clause.label}</td><td>{$form.where_clause.html}</td></tr>
                   <tr><td></td><td>With Where Clause Returns {$where_clause_count} Records</td></tr>
                   <tr><td>{$form.where_clause_active.label}</td><td>{$form.where_clause_active.html}</td></tr>
              </tbody>
            </table>
            <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl"}</div>
        </div>
      </td>
    </tr>
    </table>

</div>
