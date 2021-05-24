<{include file='db:wgdiaries_header.tpl' }>

<h2><{$smarty.const._MA_WGDIARIES_STATISTICS}></h2>

<!-- own items -->
<h3 class="wgd-statistics-header"><{$smarty.const._MA_WGDIARIES_STATISTICS_MY_YEAR}></h3>
<{if $itemsOwn.year|default:0 > 0}>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_PERIOD}>:</div>
		<div class="col-9"><{$itemsOwn.year.fromto}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_ITEMS_NB}>:</div>
		<div class="col-10"><{$itemsOwn.year.count}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_HOURS}>:</div>
		<div class="col-10"><{$itemsOwn.year.hours}></div>
	</div>
<{/if}>

<h3 class="wgd-statistics-header"><{$smarty.const._MA_WGDIARIES_STATISTICS_MY_MONTH}></h3>
<{if $itemsOwn.month|default:0 > 0}>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_PERIOD}>:</div>
		<div class="col-9"><{$itemsOwn.month.fromto}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_ITEMS_NB}>:</div>
		<div class="col-10"><{$itemsOwn.month.count}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_HOURS}>:</div>
		<div class="col-10"><{$itemsOwn.month.hours}></div>
	</div>
<{/if}>

<!-- group items -->
<h3 class="wgd-statistics-header"><{$smarty.const._MA_WGDIARIES_STATISTICS_GROUP_YEAR}></h3>
<{if $itemsGroup.year|default:0 > 0}>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_PERIOD}>:</div>
		<div class="col-9"><{$itemsGroup.year.fromto}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_ITEMS_NB}>:</div>
		<div class="col-10"><{$itemsGroup.year.count}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_HOURS}>:</div>
		<div class="col-10"><{$itemsGroup.year.hours}></div>
	</div>
<{/if}>

<h3 class="wgd-statistics-header"><{$smarty.const._MA_WGDIARIES_STATISTICS_GROUP_MONTH}></h3>
<{if $itemsGroup.month|default:0 > 0}>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_PERIOD}>:</div>
		<div class="col-9"><{$itemsGroup.month.fromto}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_ITEMS_NB}>:</div>
		<div class="col-10"><{$itemsGroup.month.count}></div>
	</div>
	<div class="row">
		<div class="wgd-statistics-title col-2"><{$smarty.const._MA_WGDIARIES_STATS_HOURS}>:</div>
		<div class="col-10"><{$itemsGroup.month.hours}></div>
	</div>
<{/if}>

<{include file='db:wgdiaries_footer.tpl' }>