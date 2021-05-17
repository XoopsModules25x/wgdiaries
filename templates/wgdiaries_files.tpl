<{include file='db:wgdiaries_header.tpl' }>

<{if $filesCount|default:0 > 0}>
	<h4><{$smarty.const._MA_WGDIARIES_FILES_LIST}>: <{$itemCaption}></h4>
	<div class='table-responsive'>
		<table class='table table-<{$table_type|default:false}>'>
			<tbody>
				<tr>
					<{foreach item=file from=$files name=file}>
					<td>
						<div class='panel panel-<{$panel_type|default:false}>'>
							<{include file='db:wgdiaries_files_item.tpl' }>
						</div>
					</td>
					<{if $smarty.foreach.file.iteration is div by $divideby}>
						</tr><tr>
					<{/if}>
					<{/foreach}>
				</tr>
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
