<script lang="ts">
	import { localePath } from '$lib/translations';
	import type { User as UserType } from '$lib/interfaces/User';
	import Avatar from './Avatar.svelte';

	export let user: UserType,
		size: string,
		withName: boolean = false,
		nameStyles: string = '';
	$: href = localePath(`/${user.username}`);

	if (!size) {
		size = 'h-6 w-6';
	}
</script>

<a
	{href}
	class="inline-flex items-center gap-2 shrink-0 text-gray-700 dark:text-zinc-100 hover:text-gray-700 dark:hover:text-zinc-300"
>
	<Avatar {user} size={size} />

	{#if withName}
		<p class="hover:underline {nameStyles}  ">{user?.name}</p>
	{/if}
</a>