<i id='itemId_<{$item.item_id}>'></i>

<{if isset($useGroups) && $useGroups}>
    <tr>
        <td><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></td>
        <td><{$item.groupname}></td>
    </tr>
<{/if}>

<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></td>
    <td><{$item.submitter}></td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_NAME}></td>
    <td><{$item.name}></td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_REMARKS}></td>
    <td><{$item.remarks|default:''}></td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_DATEFROM}></td>
    <td><{$item.datefrom}></td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_DATETO}></td>
    <td><{$item.dateto}></td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_CATID}></td>
    <td>
        <{if isset($item.catlogo)}>
            <img style="max-height:30px" src="<{$wgdiaries_upload_categoriesurl}>/<{$item.catlogo}>" alt="<{$item.category}>" title="<{$item.category}>">
        <{/if}>
        <{$item.category}>
    </td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_TAGS}></td>
    <td><{$item.tags|default:''}></td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_NBFILES}></td>
    <td>
        <{$item.nbfiles|default:0}>
        <{if isset($item.nbfiles) && $item.nbfiles > 0}>
            <ul>
                <{foreach item=file from=$item.files name=file}>
                    <li><{$file.name}></li>
                <{/foreach}>
                <{if isset($item.moreFiles) && $item.moreFiles}>
                    <li>...</li>
                <{/if}>
            </ul>
            <a class='btn btn-success right printNone' href='files.php?op=list&amp;redir=details&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_FILES_LIST}>'><{$smarty.const._MA_WGDIARIES_FILES_LIST}></a>
            <a class='btn btn-primary right printNone' href='files.php?op=new&amp;redir=details&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_FILE_ADD}>'><{$smarty.const._MA_WGDIARIES_FILE_ADD}></a>
        <{/if}>
    </td>
</tr>
<tr>
    <td><{$smarty.const._MA_WGDIARIES_ITEM_COMMENTS}></td>
    <td><{$item.comments|default:''}></td>
</tr>
<tr class="printNone">
    <td colspan="2">
        <a class='btn btn-success right' href='items.php?op=list&amp;#itemId_<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_ITEMS_LIST}>'><{$smarty.const._MA_WGDIARIES_ITEMS_LIST}></a>
        <{if isset($item.permEdit) && $item.permEdit}>
            <a class='btn btn-primary right' href='items.php?op=edit&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
            <a class='btn btn-danger right' href='items.php?op=delete&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
            <a class='btn btn-primary right' href='javascript:PrintDiv();' title='<{$smarty.const._DELETE}>'><{$smarty.const._MA_WGDIARIES_PRINT_ITEM}></a>
        <{/if}>
    </td>
</tr>
