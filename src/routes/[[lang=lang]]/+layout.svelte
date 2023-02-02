<script lang="ts">
	import "$lib/css/app.css";
	import { localePath, switchLocalePath, locale} from "$lib/translations";
	import { page } from '$app/stores';
	import { t } from '$lib/translations';
</script>

<div class="app">
	<div class="flex gap-1 justify-between p-3">
		<div>
			<a href="{localePath('/')}" class="border rounded shadow p-3">{$t('global.menu.gallery')}</a>
			<a href="{localePath('/users')}" class="border rounded shadow p-3">{$t('global.menu.users')}</a>
		</div>
		<div>
			<a href="{switchLocalePath('en', $page.url.pathname)}" data-sveltekit-preload-data="off" class="border rounded shadow p-3">{$t('lang.en')}</a>
			<a href="{switchLocalePath('uk', $page.url.pathname)}" data-sveltekit-preload-data="off" class="border rounded shadow p-3">{$t('lang.uk')}</a>
		</div>
	</div>
	<main class="mt-3 p-3">
		<slot />
	</main>
</div>
