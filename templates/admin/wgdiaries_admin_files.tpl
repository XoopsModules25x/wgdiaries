<!-- Header -->
<{include file='db:wgdiaries_admin_header.tpl' }>

<{if isset($files_list)}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._MA_WGDIARIES_FILE_ID}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_FILE_ITEMID}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_FILE_DESC}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_FILE_NAME}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_FILE_MIMETYPE}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_FILE_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGDIARIES_FILE_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGDIARIES_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if isset($files_count) && $files_count > 0}>
        <tbody>
            <{foreach item=file from=$files_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$file.id}></td>
                <td class='center'><{$file.itemid}></td>
                <td class='center'><{$file.desc}></td>
                <td class='center'><{$file.name}></td>
                <td class='center'><{$file.mimetype}></td>
                <td class='center'><{$file.datecreated}></td>
                <td class='center'><{$file.submitter}></td>
                <td class="center  width5">
                    <a href="files.php?op=edit&amp;file_id=<{$file.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> files"></a>
                    <a href="files.php?op=delete&amp;file_id=<{$file.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> files"></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if !empty($pagenav)}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if !empty($form)}>
    <{$form|default:false}>
<{/if}>
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgdiaries_admin_footer.tpl' }>
