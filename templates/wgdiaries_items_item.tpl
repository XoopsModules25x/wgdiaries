<i id='itemId_<{$item.item_id}>'></i>
<tr>
    <{if isset($useGroups) && $useGroups}>
        <td><{$item.groupname}></td>
    <{/if}>
    <{if isset($listGroup) && $listGroup}>
        <td><{$item.submitter}></td>
    <{/if}>
    <td class='center'>
        <{if isset($item.logo) && $item.logo != ''}>
            <img class="wgd-items-logo" src="<{$wgdiaries_upload_itemsurl}>/logos/<{$item.logo}>" alt="<{$item.logo}>" title="<{$item.logo}>">
        <{/if}>
    </td>
    <td><{$item.name}></td>
    <td><{$item.remarks|default:''}></td>
    <td><{$item.datefrom}></td>
    <td><{$item.dateto}></td>
    <td><{if isset($item.catid) && $item.catid > 0}>
            <{if isset($item.catlogo)}>
                <img class="wgd-items-catlogo" src="<{$wgdiaries_upload_categoriesurl}>/<{$item.catlogo}>" alt="<{$item.category}>" title="<{$item.category}>">
            <{/if}>
            <{$item.category|default:''}>
        <{/if}>
    </td>
    <td><{$item.tags|default:''}></td>
    <td><{$item.nbfiles|default:0}></td>
    <td><{$item.comments|default:''}></td>
    <td class="printNone">
        <a class='btn btn-success right' href='items.php?op=show&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
        <{if isset($item.permEdit) && $item.permEdit}>
            <a class='btn btn-primary right' href='items.php?op=edit&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
            <a class='btn btn-primary right' href='items.php?op=clone&amp;item_id_source=<{$item.item_id}>' title='<{$smarty.const._CLONE}>'><{$smarty.const._CLONE}></a>
            <a class='btn btn-danger right' href='items.php?op=delete&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
            <a class='btn btn-primary right' href='files.php?op=new&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_FILE_ADD}>'><{$smarty.const._MA_WGDIARIES_FILE_ADD}></a>
            <{if isset($item.nbfiles) && $item.nbfiles > 0}>
                <a class='btn btn-success right' href='files.php?op=list&amp;redir=<{$redir|default:''}>&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_FILES_LIST}>'><{$smarty.const._MA_WGDIARIES_FILES_LIST}></a>
            <{/if}>
        <{/if}>
    </td>
</tr>
