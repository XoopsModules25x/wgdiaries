<tr>
    <{if $useGroups|default:false}>
        <td><{$item.groupname}></td>
    <{/if}>
    <td><{$item.submitter}></td>
    <td><{$item.remarks}></td>
    <td><{$item.datefrom}></td>
    <td><{$item.dateto}></td>
    <td><{$item.nbfiles}></td>
    <td><{$item.comments}></td>
    <td>
        <a class='btn btn-primary' href='items.php?op=show&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
    </td>
</tr>


