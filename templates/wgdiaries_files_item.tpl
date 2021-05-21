<i id='fileId_<{$file.file_id}>'></i>
<tr>
	<td><{$file.icon}></td>
	<td><{$file.name}></td>
	<td><{$file.mimetype}></td>
	<td><{$file.desc}></td>
	<td><{$file.datecreated}></td>
	<td>
		<{if $permEdit|default:''}>
			<a class='btn btn-primary right' href='files.php?op=edit&amp;file_id=<{$file.file_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='files.php?op=delete&amp;file_id=<{$file.file_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</td>
</tr>


