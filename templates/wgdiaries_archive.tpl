<{include file='db:wgdiaries_header.tpl' }>


<h3><{$smarty.const._MA_WGDIARIES_ARCHIVE_TITLE}></h3>

<{if $monthsCount|default:0 > 0}>
    <ul>
        <{foreach name=year item=year key=key from=$arrYearMonth}>
            <li><{$key}> (<{$year.counterYear}>)</li>
            <ul>
                <{foreach item=month from=$year.months}>
                <li><a href="archive.php?op=listresult&amp;listdate=<{$month.timestamp}>" target="_blank"><{$month.string}>&emsp;(<{$month.counter}>)</a></li>
                <{/foreach}>
            </ul>
        <{/foreach}>
    </ul>
<{/if}>


<{if $itemsCount|default:0 > 0}>
    <div id="divToPrint">
        <link href="<{$wgdiaries_css_print_1}>" rel="stylesheet">
        <h3><{$itemsTitle}></h3>
        <div class="row">
            <div class='col-12'>
                <table class='table table-<{$table_type|default:false}>'>
                    <thead>
                        <tr class='head'>
                            <{if $useGroups|default:false}>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
                            <{/if}>
                            <th><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></th>
                            <th><{$smarty.const._MA_WGDIARIES_ITEM_LOGO}></th>
                            <th><{$smarty.const._MA_WGDIARIES_ITEM_NAME}></th>
                            <th><{$smarty.const._MA_WGDIARIES_ITEM_REMARKS}></th>
                            <th><{$smarty.const._MA_WGDIARIES_ITEM_DATEFROM}></th>
                            <th><{$smarty.const._MA_WGDIARIES_ITEM_DATETO}></th>
                            <th><{$smarty.const._MA_WGDIARIES_ITEM_CATID}></th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <{foreach item=item from=$items name=item}>
                            <tr>
                                <{if $useGroups|default:false}>
                                <td><{$item.groupname}></td>
                                <{/if}>
                                <td><{$item.submitter}></td>
                                <td class='center'>
                                    <{if $item.logo|default:false}>
                                <img class="wgd-items-logo" src="<{$wgdiaries_upload_itemsurl}>/logos/<{$item.logo}>" alt="<{$item.logo}>" title="<{$item.logo}>">
                                    <{/if}>
                                </td>
                                <td><{$item.name}></td>
                                <td><{$item.remarks}></td>
                                <td><{$item.datefrom}></td>
                                <td><{$item.dateto}></td>
                                <td><{if $item.catid|default:0 > 0}>
                                    <{if $item.catlogo|default:''}>
                                <img class="wgd-items-catlogo" src="<{$wgdiaries_upload_categoriesurl}>/<{$item.catlogo}>" alt="<{$item.category}>" title="<{$item.category}>">
                                    <{/if}>
                                    <{$item.category}>
                                    <{/if}>
                                </td>
                                <td class="printNone">
                                    <a class='btn btn-success right' href='items.php?op=show&amp;item_id=<{$item.item_id}>' title='<{$smarty.const._MA_WGDIARIES_DETAILS}>'><{$smarty.const._MA_WGDIARIES_DETAILS}></a>
                                </td>
                            </tr>
                        <{/foreach}>
                    </tbody>
                    <tfoot><tr><td>&nbsp;</td></tr></tfoot>
                </table>


            </div>
        </div>
    </div>
<{/if}>

<{if $error|default:''}>
    <{$error|default:false}>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>
