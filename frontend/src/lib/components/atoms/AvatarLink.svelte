<script lang="ts">
	import { localePath } from '$lib/translations';
	import type { User as UserType } from '$lib/interfaces/User';
	import Avatar from './Avatar.svelte';
	import { getContext } from 'svelte';

	export let user: UserType,
		size: string,
		withName: boolean = false,
		nameStyles: string = '',
		width: string | boolean = '';
	const locale = getContext('locale');
	$: href = localePath($locale, `/${user?.username}`);

	if (!size) {
		size = 'h-6 w-6';
	}
</script>

<a
	{href}
	class="{width} inline-flex items-center gap-2 text-black dark:text-zinc-100 hover:text-gray-700 dark:hover:text-zinc-300"
>
	<Avatar {user} {size} />

	{#if withName}
		<p class="hover:underline flex-1 {nameStyles}  ">{user?.name}</p>
	{/if}
</a>
