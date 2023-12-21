<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Star } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let user,
		forSubscribed = false;
</script>

{#if user?.rating}
	{#if user.subscribed && forSubscribed}
		<div class="flex items-center text-sm text-zinc-600 gap-1 dark:text-zinc-300">
			<Icon src={Star} theme="solid" class="  w-4 fill-amber-600 stroke-amber-600 " />
			<span>{$t('global.user.total_rating')}: {user.rating}</span>
		</div>
	{/if}

	{#if !forSubscribed}
		<div class="flex items-center font-semibold justify-between">
			<span>{$t('global.user.total_rating')} </span>
			<div class="flex items-center gap-1">
				<Icon src={Star} theme="solid" class="  w-[18px] fill-amber-500 stroke-amber-500 " />
				<span> {user.rating}</span>
			</div>
		</div>
	{/if}
{/if}
