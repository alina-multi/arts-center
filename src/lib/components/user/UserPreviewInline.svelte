<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle } from '@steeze-ui/heroicons';
	import type { User } from '../../interfaces/User';

	export let user: User;
</script>

<a
	href="/{user.username}"
	class="group inline text-sm pr-3 text-zinc-600 hover:text-zinc-500 dark:hover:text-zinc-400 dark:text-zinc-300"
>
	<div class="inline-flex items-center gap-2">
		<div class="bg-zinc-300 rounded-full">
		{#if user.avatar}
			<img src="{user.avatar.src}" alt={user.name} class="flex-none h-8 w-8 rounded-full object-cover" />
		{:else}
			<Icon src={UserCircle} class="h-8 w-8 rounded-full stroke-zinc-600 dark:stroke-zinc-400" />
		{/if}
	</div>
		<p>{user.name}</p>
	</div>
</a>
