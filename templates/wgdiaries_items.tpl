<{include file='db:wgdiaries_header.tpl' }>

<{if $itemsCount|default:0 > 0}>
	<h3><{$itemsTitle}></h3>
	<div class='table-responsive'>
		<table class='table table-<{$table_type|default:false}>'>
			<thead>
				<tr class='head'>
					<th><{$smarty.const._MA_WGDIARIES_GROUP}></th>
					<th><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></th>
					<th><{$smarty.const._MA_WGDIARIES_ITEM_REMARKS}></th>
					<th><{$smarty.const._MA_WGDIARIES_ITEM_DATEFROM}></th>
					<th><{$smarty.const._MA_WGDIARIES_ITEM_DATETO}></th>
					<th><{$smarty.const._MA_WGDIARIES_ITEM_NBFILES}></th>
					<th><{$smarty.const._MA_WGDIARIES_ITEM_COMMENTS}></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<{foreach item=item from=$items name=item}>
						<{include file='db:wgdiaries_items_item.tpl' }>
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
