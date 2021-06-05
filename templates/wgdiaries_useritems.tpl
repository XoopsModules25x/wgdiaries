<{include file='db:wgdiaries_header.tpl' }>

<h3><{$useritemsTitle}></h3>

<{if $userlist|default:''}>

    <table class='table table-<{$table_type|default:false}>'>
        <thead>
            <tr class='head'>
                <th><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></th>
                <th><{$smarty.const._MA_WGDIARIES_USERLIST_NB_ITEMS}></th>
                <{if $useGroups|default:false}>
                    <th><{$smarty.const._MA_WGDIARIES_USERLIST_GROUPS}></th>
                <{/if}>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <{foreach item=user from=$userlist}>
                <tr>
                    <td>
                        <{if $user.user_avatar|default:''}>
                            <img class="wgd-userlist-img" src="<{$xoops_upload_url}>/<{$user.user_avatar}>" alt="avatar">
                        <{/if}>
                        <{$user.name}>
                    </td>
                    <td><{$user.itemsCount}></td>
                    <{if $useGroups|default:false}>
                        <td>
                            <ul>
                                <{foreach item=group from=$user.groups}>
                                    <li><{$group.name}></li>
                                <{/foreach}>
                            </ul>
                        </td>
                    <{/if}>
                    <td><a class="btn btn-primary" href="items.php?op=listuser&amp;userId=<{$user.uid}>" target="_blank"><{$smarty.const._MA_WGDIARIES_ITEMS_LIST}></a></td>
                </tr>
            <{/foreach}>
        </tbody>
        <tfoot><tr><td>&nbsp;</td></tr></tfoot>
    </table>
<{/if}>


<{include file='db:wgdiaries_footer.tpl' }>
