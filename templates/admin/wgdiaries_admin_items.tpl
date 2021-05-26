<!-- Header -->
<{include file='db:wgdiaries_admin_header.tpl' }>

<{if $items_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_ID}></th>
                <{if $useGroups|default:false}>
                    <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
                <{/if}>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_NAME}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_REMARKS}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_DATEFROM}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_DATETO}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_CATID}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_TAGS}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_LOGO}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGDIARIES_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $items_count|default:''}>
        <tbody>
            <{foreach item=item from=$items_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$item.id}></td>
                <{if $useGroups|default:false}>
                    <td class='center'><{$item.groupname}></td>
                <{/if}>
                <td class='center'><{$item.name}></td>
                <td class='center'><{$item.remarks_short}></td>
                <td class='center'><{$item.datefrom}></td>
                <td class='center'><{$item.dateto}></td>
                <td class='center'><{$item.category}></td>
                <td class='center'><{$item.tags}></td>
                <td class='center'>
                    <img class="wgd-items-logo" src="<{$wgdiaries_upload_itemsurl}>/logos/<{$item.logo}>" alt="<{$item.logo}>" title="<{$item.logo}>">
                </td>
                <td class='center'><{$item.datecreated}></td>
                <td class='center'><{$item.submitter}></td>
                <td class="center  width5">
                    <a href="items.php?op=edit&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> items" /></a>
                    <a href="items.php?op=delete&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> items" /></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:''}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $form|default:''}>
    <{$form|default:false}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgdiaries_admin_footer.tpl' }>
