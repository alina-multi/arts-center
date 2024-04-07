<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Star } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let user;
</script>

{#if user?.rating}
	<div
		class="flex rounded-sm items-center font-semibold justify-between py-3 border-b bg-zinc-100 dark:bg-zinc-900 dark:border-zinc-800 px-9"
	>
		<span class="text-lg">{$t('global.user.total_rating')} </span>
		<div class="flex items-center gap-1 text-lg">
			<Icon src={Star} theme="solid" class="  w-5 fill-amber-500 stroke-amber-500 " />
			<span> {user.rating}</span>
		</div>
	</div>
{/if}
