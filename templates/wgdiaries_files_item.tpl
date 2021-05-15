<i id='fileId_<{$file.file_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$file.itemid}></span>
	<span class='col-sm-9 justify'><{$file.desc}></span>
	<span class='col-sm-9 justify'><{$file.name}></span>
	<span class='col-sm-9 justify'><{$file.datecreated}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem|default:''}>
			<a class='btn btn-success right' href='files.php?op=list&amp;#fileId_<{$file.file_id}>' title='<{$smarty.const._MA_WGDIARIES_FILES_LIST}>'><{$smarty.const._MA_WGDIARIES_FILES_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='files.php?op=show&amp;file_id=<{$file.file_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
		<{/if}>
		<{if $permEdit|default:''}>
			<a class='btn btn-primary right' href='files.php?op=edit&amp;file_id=<{$file.file_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='files.php?op=delete&amp;file_id=<{$file.file_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
