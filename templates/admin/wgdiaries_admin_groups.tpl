<!-- Header -->
<{include file='db:wgdiaries_admin_header.tpl' }>

<{if $groups_list|default:''}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUP_ID}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUP_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUP_LOGO}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUP_ONLINE}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUP_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUP_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGDIARIES_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $groups_count|default:''}>
		<tbody>
			<{foreach item=group from=$groups_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$group.id}></td>
				<td class='center'><{$group.name}></td>
				<td class='center'><img src="<{$wgdiaries_upload_url|default:false}>/images/groups/<{$group.logo}>" alt="groups" style="max-width:100px" /></td>
				<td class='center'><{$group.online}></td>
				<td class='center'><{$group.datecreated}></td>
				<td class='center'><{$group.submitter}></td>
				<td class="center  width5">
					<a href="groups.php?op=edit&amp;grp_id=<{$group.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> groups" /></a>
					<a href="groups.php?op=delete&amp;grp_id=<{$group.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> groups" /></a>
				</td>
			</tr>
			<{/foreach}>
		</tbody>
		<{/if}>
	</table>
	<div class="clear">&nbsp;</div>
	<{if $pagenav|default:''}>
		<div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
		<div class="clear spacer"></div>
	<{/if}>
<{/if}>
<{if $form|default:''}>
	<{$form|default:false}>
<{/if}>
<{if $error|default:''}>
	<div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgdiaries_admin_footer.tpl' }>
