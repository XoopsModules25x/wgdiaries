<tr>
    <{if $useGroups|default:false}>
        <td><{$item.groupname}></td>
    <{/if}>
    <{if $group|default:false}>
        <td><{$item.submitter}></td>
    <{/if}>
    <td class='center'>
        <{if $item.logo|default:false}>
            <img class="wgd-items-logo" src="<{$wgdiaries_upload_itemsurl}>/logos/<{$item.logo}>" alt="<{$item.logo}>" title="<{$item.logo}>">
        <{/if}>
    </td>
    <td><{$item.name}></td>
    <td><{$item.datefrom}></td>
    <td><{$item.dateto}></td>
    <td><{if $item.catid|default:0 > 0}>
        <{if $item.catlogo|default:''}>
            <img class="wgd-items-catlogo" src="<{$wgdiaries_upload_categoriesurl}>/<{$item.catlogo}>" alt="<{$item.category}>" title="<{$item.category}>">
        <{/if}>
        <{$item.category}>
        <{/if}>
    </td>
    <td><{$item.nbfiles}></td>
    <td><{$item.comments}></td>
    <td>
        <a class='btn btn-primary' href='items.php?op=show&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
    </td>
</tr>


