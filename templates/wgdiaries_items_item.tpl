<i id='itemId_<{$item.item_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$item.remarks}></span>
	<span class='col-sm-9 justify'><{$item.datefrom}></span>
	<span class='col-sm-9 justify'><{$item.dateto}></span>
	<span class='col-sm-9 justify'><{$item.datecreated}></span>
	<span class='col-sm-9 justify'><{$item.submitter}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem|default:''}>
			<a class='btn btn-success right' href='items.php?op=list&amp;#itemId_<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_ITEMS_LIST}>'><{$smarty.const._MA_WGDIARIES_ITEMS_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='items.php?op=show&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
		<{/if}>
		<{if $permEdit|default:''}>
			<a class='btn btn-primary right' href='items.php?op=edit&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='items.php?op=delete&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
