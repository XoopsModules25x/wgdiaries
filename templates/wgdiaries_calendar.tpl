<{include file='db:wgdiaries_header.tpl' }>

<h3><{$smarty.const._MA_WGDIARIES_CALENDAR_ITEMS}></h3>

<{if isset($formFilter)}><{$formFilter}><{/if}>

<{if isset($items_calendar)}>
    <div class="row wgd-cal-navbar">
        <div class="col-12 center">
            <a class="wgd-cal-navbar-link" href="calendar.php?filterFrom=<{$filterFromPrevY}>&amp;filterTo=<{$filterToPrevY}>&amp;<{$otherParams}>"><i class="fa fa-angle-double-left" title="<{$smarty.const._MA_WGDIARIES_CAL_PREVYEAR}>"></i></a>
            <a class="wgd-cal-navbar-link" href="calendar.php?filterFrom=<{$filterFromPrevM}>&amp;filterTo=<{$filterToPrevM}>&amp;<{$otherParams}>"><i class="fa fa-angle-left" title="<{$smarty.const._MA_WGDIARIES_CAL_PREVMONTH}>"></i></a>
            <span class="wgd-cal-navbar-month"><{$monthNav|default:''}> <{$yearNav|default:''}></span>
            <a class="wgd-cal-navbar-link" href="calendar.php?filterFrom=<{$filterFromNextM}>&amp;filterTo=<{$filterToNextM}>&amp;<{$otherParams}>"><i class="fa fa-angle-right" title="<{$smarty.const._MA_WGDIARIES_CAL_NEXTMONTH}>"></i></a>
            <a class="wgd-cal-navbar-link" href="calendar.php?filterFrom=<{$filterFromNextY}>&amp;filterTo=<{$filterToNextY}>&amp;<{$otherParams}>"><i class="fa fa-angle-double-right" title="<{$smarty.const._MA_WGDIARIES_CAL_NEXTYEAR}>"></i></a>
        </div>
    </div>
    <div class="row">
        <div class="col-12"><{$items_calendar}></div>
    </div>
<{/if}>

<{if isset($form)}>
    <{$form|default:false}>
<{/if}>
<{if isset($error)}>
    <{$error|default:false}>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>
