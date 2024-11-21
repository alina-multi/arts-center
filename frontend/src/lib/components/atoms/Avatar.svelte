<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { User } from '@steeze-ui/heroicons';
	import type { User as UserType } from '$lib/interfaces/User';

	export let user: UserType, size: string;

	if (!size) {
		size = 'h-6 w-6';
	}
</script>

{#if user?.photo}
	<div class=" {size} shrink-0 bg-zinc-300 dark:bg-gray-800 rounded-full overflow-hidden shadow-sm">
		<Picture photo={user.photo} alt={user?.username} class={size + ' object-cover '} />
	</div>
{:else}
	<Icon
		theme="solid"
		src={User}
		class="{size} shrink-0 bg-gray-50 dark:bg-zinc-800 rounded-full fill-zinc-300 dark:fill-zinc-400  p-[4px] border border-zinc-100 dark:border-zinc-700 shadow-sm"
	/>
{/if}
