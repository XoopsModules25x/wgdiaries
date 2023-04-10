<{include file='db:wgdiaries_header.tpl' }>

<h2 class='center'><{$smarty.const._MA_WGDIARIES_TITLE}></h2>
<{if isset($indexHeader)}>
    <h3><{$indexHeader}></h3>
<{/if}>

<!-- Start index list -->
<table>
    <thead></thead>
    <tbody>
        <tr class='center'>
            <td class='bold pad5'>
                <ul class='menu text-center'>
                    <li><a href='<{$wgdiaries_url}>'><{$smarty.const._MA_WGDIARIES_INDEX}></a></li>
                    <li><a href='<{$wgdiaries_url}>/items.php'><{$smarty.const._MA_WGDIARIES_ITEMS}></a></li>
                </ul>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr class='center'>
            <td class='bold pad5'>
                <{if isset($adv)}><{$adv|default:''}><{/if}>
            </td>
        </tr>
    </tfoot>
</table>
<!-- End index list -->

<h3><{$smarty.const._MA_WGDIARIES_INDEX_ITEMS_OWN}></h3>
<{if isset($itemsOwnCount) && $itemsOwnCount > 0}>
    <!-- Start show new items in index -->
    <table class='table table-<{$table_type}>'>
        <thead>
        <tr class='head'>
            <{if isset($useGroups) && $useGroups}>
                <th><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
            <{/if}>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_LOGO}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_NAME}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_DATEFROM}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_DATETO}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_CATID}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_NBFILES}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_COMMENTS}></th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            <!-- Start new link loop -->
            <{foreach item=itemown from=$itemsown name=itemown}>
                <{include file='db:wgdiaries_items_list.tpl' item=$itemown}>
            <{/foreach}>
            <!-- End new link loop -->
        </tbody>
    </table>
<{/if}>

<h3><{$smarty.const._MA_WGDIARIES_INDEX_ITEMS_GROUPOTHER}></h3>
<{if isset($itemsGroupCount) && $itemsGroupCount > 0}>
<!-- Start show new items in index -->
    <table class='table table-<{$table_type}>'>
        <thead>
        <tr class='head'>
            <{if isset($useGroups) && $useGroups}>
                <th><{$smarty.const._MA_WGDIARIES_ITEM_GROUPID}></th>
            <{/if}>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_SUBMITTER}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_LOGO}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_REMARKS}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_DATEFROM}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_DATETO}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_CATID}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_NBFILES}></th>
            <th><{$smarty.const._MA_WGDIARIES_ITEM_COMMENTS}></th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            <!-- Start new link loop -->
            <{foreach item=itemgroup from=$itemsgroup name=itemgroup}>
                <{include file='db:wgdiaries_items_list.tpl' item=$itemgroup group=true}>
            <{/foreach}>
            <!-- End new link loop -->
        </tbody>
    </table>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>
