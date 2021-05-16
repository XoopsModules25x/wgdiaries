<i id='grpId_<{$group.grp_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$group.name}></span>
	<span class='col-sm-3'><img src='<{$wgdiaries_upload_url|default:false}>/images/groups/<{$group.logo}>' alt='groups' /></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem|default:''}>
			<a class='btn btn-success right' href='groups.php?op=list&amp;#grpId_<{$group.grp_id}>' title='<{$smarty.const._MA_WGDIARIES_GROUPS_LIST}>'><{$smarty.const._MA_WGDIARIES_GROUPS_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='groups.php?op=show&amp;grp_id=<{$group.grp_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
		<{/if}>
		<{if $permEdit|default:''}>
			<a class='btn btn-primary right' href='groups.php?op=edit&amp;grp_id=<{$group.grp_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='groups.php?op=delete&amp;grp_id=<{$group.grp_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
