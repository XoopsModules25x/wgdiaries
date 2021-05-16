<i id='guId_<{$groupuser.gu_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$groupuser.groupid}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem|default:''}>
			<a class='btn btn-success right' href='groupusers.php?op=list&amp;#guId_<{$groupuser.gu_id}>' title='<{$smarty.const._MA_WGDIARIES_GROUPUSERS_LIST}>'><{$smarty.const._MA_WGDIARIES_GROUPUSERS_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='groupusers.php?op=show&amp;gu_id=<{$groupuser.gu_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
		<{/if}>
		<{if $permEdit|default:''}>
			<a class='btn btn-primary right' href='groupusers.php?op=edit&amp;gu_id=<{$groupuser.gu_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='groupusers.php?op=delete&amp;gu_id=<{$groupuser.gu_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
