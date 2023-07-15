<script lang="ts">
	import { localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { User } from '@steeze-ui/heroicons';

	export let user, size, withName;
	$: href = localePath(`/${user.username}`);

	if (!size) {
		size = 'h-6 w-6';
	}
</script>

<a {href} class="inline-flex items-center gap-2 shrink-0 text-gray-700 dark:text-zinc-100 hover:text-gray-700 dark:hover:text-zinc-300 ">
		{#if user.photo}
			<div class=" {size}  bg-zinc-300 dark:bg-gray-800 rounded-full overflow-hidden shadow-sm">
				<Picture photo={user.photo} alt={user.username} style={ size + " object-cover "}/>
			</div>
		{:else}
			<Icon
				theme="solid"
				src={User}
				class="{size} bg-gray-50 dark:bg-zinc-800 rounded-full fill-zinc-300 dark:fill-zinc-400  p-[4px] border border-zinc-100 dark:border-zinc-700 shadow-sm"
			/>
		{/if}

		{#if withName}
			<p class="hover:underline font-semibold  ">{user.name}</p>
		{/if}

</a>
