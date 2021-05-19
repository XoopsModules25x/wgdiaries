<!-- Header -->
<{include file='db:wgdiaries_admin_header.tpl' }>

<{if $groupusers_list|default:''}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUPUSER_ID}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUPUSER_GROUPID}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUPUSER_UID}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUPUSER_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGDIARIES_GROUPUSER_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._MA_WGDIARIES_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $groupusers_count|default:''}>
		<tbody>
			<{foreach item=groupuser from=$groupusers_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$groupuser.id}></td>
				<td class='center'><{$groupuser.groupid}></td>
				<td class='center'><{$groupuser.username}></td>
				<td class='center'><{$groupuser.datecreated}></td>
				<td class='center'><{$groupuser.submitter}></td>
				<td class="center  width5">
					<a href="groupusers.php?op=edit&amp;gu_id=<{$groupuser.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> groupusers" /></a>
					<a href="groupusers.php?op=delete&amp;gu_id=<{$groupuser.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> groupusers" /></a>
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
