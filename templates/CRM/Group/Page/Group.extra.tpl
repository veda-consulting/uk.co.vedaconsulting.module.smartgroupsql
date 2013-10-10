{if $SQLQueryGroupId gt 0}
{literal}
<!-- .tpl file invoked: CRM\Group\Page\Group.extra.tpl. Call via form.tpl if we have a form in the page. -->{/literal}
<script type="text/javascript">

    var SmartGroupSqlUrl = '/civicrm/group/sql?gid=' + {/literal}{$SQLQueryGroupId}{literal};
    
    // Add a row to the end of the Smart Group with class 'form-layout'
    cj('.form-layout').append('<tr><td></td><td><a href="' + SmartGroupSqlUrl + '">Customise/Set Smart Group Sql</a></td></tr>');

</script>
{/literal}
{/if}





