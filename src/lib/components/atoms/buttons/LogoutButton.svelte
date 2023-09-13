<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Power } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';
	import { t } from '$lib/translations';
</script>

<a
	href={localePath(`/logout`)}
	class=" flex gap-x-3 py-2 px-6 text-sm leading-6 font-semibold text-gray-700 hover:bg-gray-50 dark:text-zinc-300 dark:hover:text-white dark:hover:bg-zinc-700 rounded-sm"
	data-sveltekit-preload-data="tap"
	data-sveltekit-reload
>
	<Icon src={Power} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />{$t('global.my_links.logout')}
</a>
