<{include file='db:wgdiaries_header.tpl' }>

<{if $itemsCount|default:0 > 0}>
<div class='table-responsive'>
	<table class='table table-<{$table_type}>'>
		<thead>
			<tr class='head'>
				<th colspan='<{$divideby}>'><{$smarty.const._MA_WGDIARIES_ITEMS_TITLE}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=item from=$items name=item}>
				<td>
					<div class='panel panel-<{$panel_type}>'>
						<{include file='db:wgdiaries_items_item.tpl' }>
					</div>
				</td>
				<{if $smarty.foreach.item.iteration is div by $divideby}>
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
	<{$form}>
<{/if}>
<{if $error|default:''}>
	<{$error}>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>
