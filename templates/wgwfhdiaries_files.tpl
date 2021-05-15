<{include file='db:wgwfhdiaries_header.tpl' }>

<{if $filesCount|default:0 > 0}>
<div class='table-responsive'>
	<table class='table table-<{$table_type}>'>
		<thead>
			<tr class='head'>
				<th colspan='<{$divideby}>'><{$smarty.const._MA_WGWFHDIARIES_FILES_TITLE}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=file from=$files name=file}>
				<td>
					<div class='panel panel-<{$panel_type}>'>
						<{include file='db:wgwfhdiaries_files_item.tpl' }>
					</div>
				</td>
				<{if $smarty.foreach.file.iteration is div by $divideby}>
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

<{include file='db:wgwfhdiaries_footer.tpl' }>
