<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';
	import { page } from '$app/stores';
	import { user } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	let href = '';
	let redirect = $page.url.pathname.length > 1 ? `?redirect=${$page.url.pathname}` : '';

	$: href = $user ? localePath($locale, `/my/work/add`) : localePath($locale, `/login${redirect}`);
</script>

<a
	{href}
	class="rounded-full inline-flex items-center justify-center shrink-0 text-sm hover:bg-amber-500 hover:border-amber-500 border border-amber-600 px-4 py-2 bg-amber-600 text-white hover:shadow"
>
	<span class="sr-only">{$t('global.buttons.addwork')}</span>

	<span class="mr-2">{$t('global.buttons.addwork').toUpperCase()}</span>
	<Icon src={PlusCircle} class="h-5 w-5" aria-hidden="true" />
</a>
