<{include file='db:wgdiaries_header.tpl' }>

<h2 class='center'><{$smarty.const._MA_WGDIARIES_TITLE}></h2>

<{if isset($formFilter)}><{$formFilter}><{/if}>

<{if isset($filterResult)}>
    <h3><{$filterResult}></h3>
<{/if}>

<{if isset($itemsCount) && $itemsCount > 0}>
    <div id="divToPrint">
        <style></style>
        <h3><{$resultTitle|default:''}></h3>
        <link href="<{$wgdiaries_css_print_1}>" rel="stylesheet">
        <div class="row">
            <div class='table-responsive'>
                <table class='table table-<{$table_type|default:false}>'>
                    <thead>
                        <{if isset($showItem) && !$showItem}>
                            <tr class='head'>
                                <{if isset($useGroups) && $useGroups}>
                                    <th><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
                                <{/if}>
                                <{if isset($listGroup) && $listGroup}>
                                    <th><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></th>
                                <{/if}>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_LOGO}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_NAME}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_REMARKS}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_DATEFROM}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_DATETO}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_CATID}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_TAGS}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_NBFILES}></th>
                                <th><{$smarty.const._MA_WGDIARIES_ITEM_COMMENTS}></th>
                                <th class="printNone">&nbsp;</th>
                            </tr>
                        <{/if}>
                    </thead>
                    <tbody>
                        <{foreach item=item from=$items name=item}>
                            <{include file='db:wgdiaries_items_item.tpl' }>
                        <{/foreach}>
                    </tbody>
                    <tfoot><tr><td></td></tr></tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 center"><input class="btn btn-primary" type="button" value="<{$smarty.const._MA_WGDIARIES_PRINT_LIST}>" onclick="PrintDiv();"></div>
    </div>
<{/if}>

<{if isset($error)}>
    <{$error|default:false}>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>

<script type="text/javascript">
    function PrintDiv() {
        var divToPrint = document.getElementById('divToPrint');
        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();

    }
</script>
