<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import type { User } from '$lib/interfaces/User';

	export let user: User,
		followButton = false,
		size;
</script>

<div
	class="group inline-flex items-center gap-3 text-gray-600 hover:text-gray-500 dark:hover:text-gray-400 dark:text-gray-300"
>
	<Avatar {user} withName={true} />
	{#if followButton}
		<butoon
			class=" inline-flex dark:bg-gray-900 dark:border-gray-800 dark:border rounded-full px-3 py-1 text-xs text-white bg-sky-700/90 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
			>Follow</butoon
		>
	{/if}
</div>
