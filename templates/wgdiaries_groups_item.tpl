<i id='grpId_<{$group.grp_id}>'></i>
<tr>
	<td><img class='wgd-group-img' src='<{$wgdiaries_upload_url|default:false}>/images/groups/<{$group.logo}>' alt='<{$group.name}>' /></td>
	<td><{$group.name}></td>
	<td>
		<{if $group.users|default:false}>
			<{foreach item=user from=$group.users}>
				<p><{$user.name}></p>
			<{/foreach}>
		<{/if}>
	</td>
	<td>
		<{if $permEdit|default:''}>
			<a class='btn btn-primary right' href='groups.php?op=edit&amp;grp_id=<{$group.grp_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-success right' href='groupusers.php?op=edit&amp;grp_id=<{$group.grp_id}>' title='<{$smarty.const._MA_WGDIARIES_GROUPUSERS_EDIT}>'><{$smarty.const._MA_WGDIARIES_GROUPUSERS_EDIT}></a>
			<a class='btn btn-danger right' href='groups.php?op=delete&amp;grp_id=<{$group.grp_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</td>
</tr>
