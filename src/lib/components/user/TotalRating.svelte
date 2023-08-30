<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Star } from '@steeze-ui/heroicons';
	import { t } from '$lib/translations';
	export let user,
		full = false,
		forSubscribed = false;
</script>

{#if user?.rating}
	{#if user.subscribed && forSubscribed}
		<div class="flex items-center text-sm text-zinc-600 gap-1 dark:text-zinc-300">
			<Icon src={Star} theme="solid" class="  w-4 fill-amber-600 stroke-amber-600 " />
			<span>{$t('global.user.total_rating')}: {user.rating}</span>
		</div>
	{/if}

{#if !forSubscribed }
		<div class="flex items-center text-sm {full ? 'gap-1 font-semibold' : ''} ">
			<Icon src={Star} theme="solid" class="  w-[16px] fill-amber-600 stroke-amber-600 " />
			{#if full} <span>{$t('global.user.total_rating')}: </span> {/if}
			<span> {user.rating}</span>
		</div>
	{/if}
{/if}
