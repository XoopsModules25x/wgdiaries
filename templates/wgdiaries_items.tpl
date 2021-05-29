<{include file='db:wgdiaries_header.tpl' }>

<{if $itemsCount|default:0 > 0}>
    <div id="divToPrint">
        <link href="<{$wgdiaries_css_print_1}>" rel="stylesheet">
        <h3><{$itemsTitle}></h3>
        <{if $items_calendar|default:'' && $showItem|default:false == false}>
            <div class="row printNone"><div class="col-12"><{$items_calendar}></div></div>
        <{/if}>

        <div class="row">
            <div class='col-12'>
                <table class='table table-<{$table_type|default:false}>'>
                    <thead>
                        <{if $showItem|default:false == false}>
                            <tr class='head'>
                                <{if $useGroups|default:false}>
                                    <th><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
                                <{/if}>
                                <{if $listGroup|default:false}>
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
                                <th>&nbsp;</th>
                            </tr>
                        <{/if}>
                    </thead>
                    <tbody>
                        <{foreach item=item from=$items name=item}>
                            <{if $showItem|default:false}>
                                <{include file='db:wgdiaries_items_single.tpl' }>
                            <{else}>
                                <{include file='db:wgdiaries_items_item.tpl' }>
                            <{/if}>
                        <{/foreach}>
                    </tbody>
                    <tfoot><tr><td>&nbsp;</td></tr></tfoot>
                </table>


            </div>
        </div>
        <{if $showItem|default:false}>
            <div class="row">
                <div class="col-12 center"><input class="btn btn-primary" type="button" value="<{$smarty.const._MA_WGDIARIES_PRINT_ITEM}>" onclick="PrintDiv();" /></div>
            </div>
        <{/if}>
    </div>
<{/if}>

<{if $form|default:''}>
    <{$form|default:false}>
<{/if}>
<{if $error|default:''}>
    <{$error|default:false}>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>

<script>
    $(document).ready(function(){
        countFields = 0;
        $('.add_more').click(function(e){
            countFields++;
            if (countFields == <{$maxfileuploads|default:0}>) {
                alert('<{$smarty.const._MA_WGDIARIES_ITEM_UPLOADFILES_MAX}>');
            } else {
                e.preventDefault();
                $(this).before("<input type='file' class='form-control' name='item_file" + countFields + "' id='item_file" + countFields + "' title=''><input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='item_file" + countFields + "'>");
            }
        });
    });
</script>

<script type="text/javascript">
    function PrintDiv() {
        var divToPrint = document.getElementById('divToPrint');
        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();

    }
</script>

