<{include file='db:wgdiaries_header.tpl' }>

<{if $groupusersCount|default:0 > 0}>
<div class='table-responsive'>
	<table class='table table-<{$table_type|default:false}>'>
		<thead>
			<tr class='head'>
				<th colspan='<{$divideby|default:false}>'><{$smarty.const._MA_WGDIARIES_GROUPUSERS_TITLE}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=groupuser from=$groupusers name=groupuser}>
				<td>
					<div class='panel panel-<{$panel_type|default:false}>'>
						<{include file='db:wgdiaries_groupusers_item.tpl' }>
					</div>
				</td>
				<{if $smarty.foreach.groupuser.iteration is div by $divideby}>
					</tr><tr>
				<{/if}>
				<{/foreach}>
			</tr>
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
