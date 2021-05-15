<!-- Header -->
<{include file='db:wgwfhdiaries_admin_header.tpl' }>

<{if $items_list|default:''}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGWFHDIARIES_ITEM_ID}></th>
				<th class="center"><{$smarty.const._AM_WGWFHDIARIES_ITEM_REMARKS}></th>
				<th class="center"><{$smarty.const._AM_WGWFHDIARIES_ITEM_DATEFROM}></th>
				<th class="center"><{$smarty.const._AM_WGWFHDIARIES_ITEM_DATETO}></th>
				<th class="center"><{$smarty.const._AM_WGWFHDIARIES_ITEM_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGWFHDIARIES_ITEM_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGWFHDIARIES_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $items_count|default:''}>
		<tbody>
			<{foreach item=item from=$items_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$item.id}></td>
				<td class='center'><{$item.remarks_short}></td>
				<td class='center'><{$item.datefrom}></td>
				<td class='center'><{$item.dateto}></td>
				<td class='center'><{$item.datecreated}></td>
				<td class='center'><{$item.submitter}></td>
				<td class="center  width5">
					<a href="items.php?op=edit&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> items" /></a>
					<a href="items.php?op=delete&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> items" /></a>
				</td>
			</tr>
			<{/foreach}>
		</tbody>
		<{/if}>
	</table>
	<div class="clear">&nbsp;</div>
	<{if $pagenav|default:''}>
		<div class="xo-pagenav floatright"><{$pagenav}></div>
		<div class="clear spacer"></div>
	<{/if}>
<{/if}>
<{if $form|default:''}>
	<{$form}>
<{/if}>
<{if $error|default:''}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgwfhdiaries_admin_footer.tpl' }>
