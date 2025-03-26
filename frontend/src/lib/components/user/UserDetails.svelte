<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import Country from '$lib/components/user/UserCountry.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Star } from '@steeze-ui/heroicons';

	export let user: User;
</script>

<div
	class="flex flex-wrap text-sm gap-1.5 items-center leading-none text-zinc-700 dark:text-zinc-300"
>
	{#if user?.rating}
		<div class="flex items-center gap-1">
			<Icon src={Star} theme="solid" class="w-[14px] h-[14px] fill-amber-600 " />
			<span> {user.rating}</span>
		</div>
		<div class="rounded-full h-0.5 w-0.5 bg-zinc-400 dark:bg-zinc-300"></div>
	{/if}
	<Country {user} />
</div>
