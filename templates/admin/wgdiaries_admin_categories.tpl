<!-- Header -->
<{include file='db:wgdiaries_admin_header.tpl' }>

<{if $categories_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGDIARIES_CATEGORY_ID}></th>
                <th class="center"><{$smarty.const._AM_WGDIARIES_CATEGORY_NAME}></th>
                <th class="center"><{$smarty.const._AM_WGDIARIES_CATEGORY_LOGO}></th>
                <th class="center"><{$smarty.const._AM_WGDIARIES_CATEGORY_ONLINE}></th>
                <th class="center"><{$smarty.const._AM_WGDIARIES_CATEGORY_WEIGHT}></th>
                <th class="center"><{$smarty.const._AM_WGDIARIES_CATEGORY_DATECREATED}></th>
                <th class="center"><{$smarty.const._AM_WGDIARIES_CATEGORY_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGDIARIES_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $categories_count|default:''}>
        <tbody>
            <{foreach item=category from=$categories_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$category.id}></td>
                <td class='center'><{$category.name}></td>
                <td class='center'><img src="<{$wgdiaries_upload_url|default:false}>/categories/<{$category.logo}>" alt="categories" style="max-width:100px"></td>
                <td class='center'>
                    <{if $category.cat_online|default:0 == 1}>
                    <a href="categories.php?op=change_yn&amp;field=cat_online&amp;value=0&amp;cat_id=<{$category.id}>&amp;start=<{$start|default:0}>&amp;limit=<{$limit|default:0}>" title="<{$smarty.const._MA_WGDIARIES_ACTIVE}>">
                        <img src="<{$wgdiaries_icons_url}>/32/1.png" alt="<{$smarty.const._MA_WGDIARIES_ACTIVE}>"></a>
                    <{else}>
                    <a href="categories.php?op=change_yn&amp;field=cat_online&amp;value=1&amp;cat_id=<{$category.id}>&amp;start=<{$start|default:0}>&amp;limit=<{$limit|default:0}>" title="<{$smarty.const._MA_WGDIARIES_NONACTIVE}>">
                        <img src="<{$wgdiaries_icons_url}>/32/0.png" alt="<{$smarty.const._MA_WGDIARIES_NONACTIVE}>"></a>
                    <{/if}>

                </td>
                <td class='center'><{$category.weight}></td>
                <td class='center'><{$category.datecreated}></td>
                <td class='center'><{$category.submitter}></td>
                <td class="center  width5">
                    <a href="categories.php?op=edit&amp;cat_id=<{$category.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> categories"></a>
                    <a href="categories.php?op=delete&amp;cat_id=<{$category.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> categories"></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:''}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $form|default:''}>
    <{$form|default:false}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgdiaries_admin_footer.tpl' }>
