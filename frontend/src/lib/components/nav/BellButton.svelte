<script clang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bell } from '@steeze-ui/heroicons';
	import { invalidateAll } from '$app/navigation';
	import { localePath } from '$lib/translations';
	import { user } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const locale = getContext('locale');
</script>

<a
	href={localePath($locale, '/my/notifications')}
	on:click={() => invalidateAll()}
	class="relative hover:bg-gray-100 dark:hover:bg-zinc-700 flex items-center justify-center rounded-full p-1 transition-all"
>
	<Icon src={Bell} class="h-8 w-8  stroke-1" aria-hidden="true" />
	{#if $user?.unread > 0}
		<span
			class="absolute right-1 top-1 bg-amber-500 text-white text-xs rounded-full leading-3 px-1 py-0.5"
		>
			{$user?.unread}
		</span>
	{/if}
</a>
