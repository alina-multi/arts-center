<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { User } from '@steeze-ui/heroicons';
	import { handleAvatarError } from '$lib/helpers/handleImgError';
	import { localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';

	export let user, size, withName;
	$: href = localePath(`/${user.username}`);

	if (!size) {
		size = 'h-6 w-6';
	}

	console.log(user);
</script>

<a {href} class="inline-flex shrink-0">
	<div class="inline-flex items-center gap-2">
		<div class="bg-zinc-300 dark:bg-gray-800 rounded-full shadow-md">
			{#if user?.avatar}
				<img
					src={user?.avatar?.src}
					alt={user.name}
					class="flex-none {size} rounded-full object-cover"
					on:error={(event) => handleAvatarError(event)}
				/>
			{:else}
				<Icon
					theme="solid"
					src={User}
					class="{size} rounded-full fill-white dark:fill-gray-200 p-[5px]"
				/>
			{/if}
		</div>

		{#if withName}
			<p class="hover:underline">{user.name}</p>
		{/if}
	</div>
</a>
