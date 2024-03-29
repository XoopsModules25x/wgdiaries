<{include file='db:wgdiaries_header.tpl' }>

<h3><{$smarty.const._MA_WGDIARIES_USERLIST_GROUP}></h3>

<{if isset($userlist)}>
    <table class='table table-<{$table_type|default:false}>'>
        <thead>
            <tr class='head'>
                <th><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></th>
                <th><{$smarty.const._MA_WGDIARIES_USERLIST_NB_ITEMS}></th>
                <{if isset($useGroups) && $useGroups}>
                    <th><{$smarty.const._MA_WGDIARIES_USERLIST_GROUPS}></th>
                <{/if}>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <{foreach item=user from=$userlist}>
                <tr>
                    <td>
                        <{if isset($user.user_avatar)}>
                            <img class="wgd-userlist-img" src="<{$xoops_upload_url}>/<{$user.user_avatar}>" alt="avatar">
                        <{/if}>
                        <{$user.name}>
                    </td>
                    <td><{$user.itemsCount}></td>
                    <{if isset($useGroups) && $useGroups}>
                        <td>
                            <ul>
                                <{foreach item=group from=$user.groups}>
                                    <li><{$group.name}></li>
                                <{/foreach}>
                            </ul>
                        </td>
                    <{/if}>
                    <td>
                        <{if isset($user.itemsCount) && $user.itemsCount > 0}>
                            <a class="btn btn-primary" href="items.php?op=listuser&amp;userId=<{$user.uid}>" target="_blank"><{$smarty.const._MA_WGDIARIES_ITEMS_LIST}></a>
                        <{/if}>
                    </td>
                </tr>
            <{/foreach}>
        </tbody>
        <tfoot><tr><td>&nbsp;</td></tr></tfoot>
    </table>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>
