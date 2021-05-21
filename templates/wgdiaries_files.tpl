<{include file='db:wgdiaries_header.tpl' }>

<{if $filesCount|default:0 > 0}>
	<h4><{$smarty.const._MA_WGDIARIES_FILES_LIST}>: <{$itemCaption}></h4>
	<div class='table-responsive'>
		<table class='table table-<{$table_type|default:false}>'>
			<thead>
			<tr class='head'>
				<th>&nbsp;</th>
				<th><{$smarty.const._MA_WGDIARIES_FILE_NAME}></th>
				<th><{$smarty.const._MA_WGDIARIES_FILE_MIMETYPE}></th>
				<th><{$smarty.const._MA_WGDIARIES_FILE_DESC}></th>
				<th><{$smarty.const._MA_WGDIARIES_FILE_DATECREATED}></th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
				<{foreach item=file from=$files name=file}>
					<{include file='db:wgdiaries_files_item.tpl' }>
				<{/foreach}>
			</tbody>
			<tfoot><tr><td>&nbsp;
					<a class='btn btn-success right' href='files.php?op=new&amp;item_id=<{$itemId}>' title='<{$smarty.const._ADD}>'><{$smarty.const._ADD}></a>
				</td></tr></tfoot>
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
