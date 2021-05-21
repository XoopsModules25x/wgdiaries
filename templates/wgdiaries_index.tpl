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
				<{if $adv|default:''}><{$adv|default:false}><{/if}>
			</td>
		</tr>
	</tfoot>
</table>
<!-- End index list -->

<div class='wgdiaries-linetitle'><{$smarty.const._MA_WGDIARIES_INDEX_ITEMS_OWN}></div>
<{if $itemsOwnCount|default:0 > 0}>
	<!-- Start show new items in index -->
	<table class='table table-<{$table_type}>'>
		<thead>
		<tr class='head'>
			<{if $useGroups|default:false}>
				<th><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
			<{/if}>
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
			<!-- Start new link loop -->
			<{foreach item=itemown from=$itemsown name=itemown}>
				<{include file='db:wgdiaries_items_list.tpl' item=$itemown}>
			<{/foreach}>
			<!-- End new link loop -->
		</tbody>
	</table>
<{/if}>

<div class='wgdiaries-linetitle'><{$smarty.const._MA_WGDIARIES_INDEX_ITEMS_GROUP}></div>
<{if $itemsGroupCount|default:0 > 0}>
<!-- Start show new items in index -->
	<table class='table table-<{$table_type}>'>
		<thead>
		<tr class='head'>
			<{if $useGroups|default:false}>
			<th><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
			<{/if}>
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
			<!-- Start new link loop -->
			<{foreach item=itemgroup from=$itemsgroup name=itemgroup}>
				<{include file='db:wgdiaries_items_list.tpl' item=$itemgroup}>
			<{/foreach}>
			<!-- End new link loop -->
		</tbody>
	</table>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>
