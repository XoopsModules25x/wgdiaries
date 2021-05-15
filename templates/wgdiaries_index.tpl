<{include file='db:wgdiaries_header.tpl' }>

<!-- Start index list -->
<table>
	<thead>
		<tr class='center'>
			<th><{$smarty.const._MA_WGDIARIES_TITLE}>  -  <{$smarty.const._MA_WGDIARIES_DESC}></th>
		</tr>
	</thead>
	<tbody>
		<tr class='center'>
			<td class='bold pad5'>
				<ul class='menu text-center'>
					<li><a href='<{$wgdiaries_url}>'><{$smarty.const._MA_WGDIARIES_INDEX}></a></li>
					<li><a href='<{$wgdiaries_url}>/items.php'><{$smarty.const._MA_WGDIARIES_ITEMS}></a></li>
				</ul>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr class='center'>
			<td class='bold pad5'>
				<{if $adv|default:''}><{$adv}><{/if}>
			</td>
		</tr>
	</tfoot>
</table>
<!-- End index list -->

<div class='wgdiaries-linetitle'><{$smarty.const._MA_WGDIARIES_INDEX_LATEST_LIST}></div>
<{if $itemsCount|default:0 > 0}>
	<!-- Start show new items in index -->
	<table class='table table-<{$table_type}>'>
					</tr><tr>
		<tr>
			<!-- Start new link loop -->
			<{foreach item=item from=$items name=item}>
				<td class='col_width<{$numb_col}> top center'>
					<{include file='db:wgdiaries_items_list.tpl' item=$item}>
				</td>
				<{if $smarty.foreach.item.iteration is div by $divideby}>
					</tr><tr>
				<{/if}>
			<{/foreach}>
			<!-- End new link loop -->
		</tr>
	</table>
<{/if}>
<{include file='db:wgdiaries_footer.tpl' }>
