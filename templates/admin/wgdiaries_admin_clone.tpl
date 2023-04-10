<!-- Header -->
<{include file='db:wgdiaries_admin_header.tpl' }>

<{if isset($form)}>
    <{$form|default:false}>
<{/if}>
<{if isset($result)}>
    <{$result|default:false}>
<{/if}>
<{if isset($error)}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgdiaries_admin_footer.tpl' }>
