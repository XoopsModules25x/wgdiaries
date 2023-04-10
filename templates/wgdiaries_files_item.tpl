<i id='fileId_<{$file.file_id}>'></i>
<tr>
    <td>
        <{if isset($file.isimage) && $file.isimage}>
            <img class="img-responsive img-fluid" src="<{$wgdiaries_uploadfileurl}><{$file.name}>" alt="<{$file.name}>" title="<{$file.name}>">
        <{else}>
            &nbsp;
            <img class="img-responsive img-fluid" src="<{$wgdiaries_fileiconurl}><{$file.icon}>" alt="<{$file.name}>" title="<{$file.name}>">
        <{/if}>
    </td>
    <td><{$file.name}></td>
    <td><{$file.desc|default:''}></td>
    <td><{$file.datecreated}></td>
    <td>
        <{if isset($permEdit) && $permEdit}>
            <a class='btn btn-primary right' href='files.php?op=edit&amp;file_id=<{$file.file_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
            <a class='btn btn-danger right' href='files.php?op=delete&amp;file_id=<{$file.file_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
        <{/if}>
        <a class='btn btn-success right' href='<{$wgdiaries_uploadfileurl}><{$file.name}>' title='<{$smarty.const._MA_WGDIARIES_FILE_OPEN}>'><{$smarty.const._MA_WGDIARIES_FILE_OPEN}></a>
    </td>
</tr>


