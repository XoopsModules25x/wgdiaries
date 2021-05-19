<{include file='db:wgdiaries_header.tpl' }>

<{if $groupsCount|default:0 > 0}>
<div class='table-responsive'>
	<table class='table table-<{$table_type|default:false}>'>
		<thead>
			<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._MA_WGDIARIES_GROUP_LOGO}></th>
				<th class="center"><{$smarty.const._MA_WGDIARIES_GROUP_NAME}></th>
				<th class="center"><{$smarty.const._MA_WGDIARIES_GROUPUSERS}></th>
				<th class="center width5"><{$smarty.const._MA_WGDIARIES_FORM_ACTION}></th>
			</tr>
			</thead>
		</thead>
		<tbody>
			<{foreach item=group from=$groups name=group}>
				<{include file='db:wgdiaries_groups_item.tpl' }>
			<{/foreach}>
		</tbody>
		<tfoot><tr><td>&nbsp;</td></tr></tfoot>
	</table>
</div>
<{/if}>
<{if $form|default:''}>
	<{$form|default:false}>
<{/if}>
<{if $error|default:''}>
	<{$error|default:false}>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>
