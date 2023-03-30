<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle } from '@steeze-ui/heroicons';
	import { handleAvatarError } from '$lib/helpers/handleImgError';

	export let name: string, avatar: { src: string }, size: string;

	if (!size) {
		size = 'h-8 w-8';
	}
</script>

<div class="bg-zinc-300 rounded-full">
	{#if avatar}
		<img
			src={avatar.src}
			alt={name}
			class="flex-none h-8 w-8 rounded-full object-cover"
			on:error={(event) => handleAvatarError(event)}
		/>
	{:else}
		<Icon src={UserCircle} class="{size} rounded-full stroke-zinc-600 dark:stroke-zinc-400" />
	{/if}
</div>
