<tr>
    <{if isset($useGroups) && $useGroups}>
        <td><{$item.groupname}></td>
    <{/if}>
    <{if isset($group) && $group}>
        <td><{$item.submitter}></td>
    <{/if}>
    <td class='center'>
        <{if isset($item.logo) && $item.logo != ''}>
            <img class="wgd-items-logo" src="<{$wgdiaries_upload_itemsurl}>/logos/<{$item.logo}>" alt="<{$item.logo}>" title="<{$item.logo}>">
        <{/if}>
    </td>
    <td><{$item.name}></td>
    <td><{$item.datefrom}></td>
    <td><{$item.dateto}></td>
    <td><{if isset($item.catid) && $item.catid > 0}>
        <{if isset($item.catlogo)}>
            <img class="wgd-items-catlogo" src="<{$wgdiaries_upload_categoriesurl}>/<{$item.catlogo}>" alt="<{$item.category}>" title="<{$item.category}>">
        <{/if}>
        <{$item.category}>
        <{/if}>
    </td>
    <td><{$item.nbfiles|default:0}></td>
    <td><{$item.comments|default:''}></td>
    <td>
        <a class='btn btn-primary' href='items.php?op=show&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
    </td>
</tr>


