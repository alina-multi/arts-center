<script lang='ts'>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle } from '@steeze-ui/heroicons';
	import { localePath, t } from '$lib/translations';
	import { page } from '$app/stores';
	import { user } from '$lib/stores/auth';

	let href = '';
	let redirect = $page.url.pathname.length > 1 ? `?redirect=${$page.url.pathname}` : '';

	$:href = $user ? localePath(`/my/work/add`) : localePath(`/login${redirect}`);
</script>

<a
	{href}
	class=" inline-flex items-center shrink-0 text-sm hover:bg-amber-500 hover:border-amber-500   border border-amber-600 rounded-sm pl-2 pr-3 py-1 bg-amber-600   text-white shadow-md hover:shadow-xl"
>
	<span class='sr-only'>{$t('global.buttons.addwork')}</span>
	<Icon src={PlusCircle} theme='solid' class='h-5 w-5' aria-hidden='true' />
	<span class='ml-1'>{$t('global.buttons.addwork').toUpperCase()}</span>
</a>

