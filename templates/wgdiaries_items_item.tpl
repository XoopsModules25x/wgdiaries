<i id='itemId_<{$item.item_id}>'></i>
<tr>
	<td><{$item.group}></td>
	<td><{$item.submitter}></td>
	<td><{$item.remarks}></td>
	<td><{$item.datefrom}></td>
	<td><{$item.dateto}></td>
	<td><{$item.nbfiles}></td>
	<td><{$item.comments}></td>
	<td>
		<{if $showItem|default:''}>
			<a class='btn btn-success right' href='items.php?op=list&amp;#itemId_<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_ITEMS_LIST}>'><{$smarty.const._MA_WGDIARIES_ITEMS_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='items.php?op=show&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
		<{/if}>
		<{if $item.permEdit|default:''}>
			<a class='btn btn-primary right' href='items.php?op=edit&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='items.php?op=delete&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
			<a class='btn btn-success right' href='files.php?op=new&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_FILE_ADD}>'><{$smarty.const._MA_WGDIARIES_FILE_ADD}></a>
			<a class='btn btn-success right' href='files.php?op=list&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_FILES_LIST}>'><{$smarty.const._MA_WGDIARIES_FILES_LIST}></a>
		<{/if}>
	</td>
</tr>
