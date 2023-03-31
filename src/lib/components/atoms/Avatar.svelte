<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle } from '@steeze-ui/heroicons';
	import { handleAvatarError } from '$lib/helpers/handleImgError';
	import { localePath } from '$lib/translations';
	

	export let user, size, withName;
	$: href = localePath(`/${user.username}`);

	if (!size) {
		size = 'h-8 w-8';
	}

</script>


<a
	{href}
	class="inline-flex"
>
	<div class="inline-flex items-center gap-2">
<div class="bg-zinc-300 rounded-full">
	{#if user.avatar}
		<img
			src={user.avatar.src}
			alt={user.name}
			class="flex-none {size} rounded-full object-cover"
			on:error={(event) => handleAvatarError(event)}
		/>
	{:else}
		<Icon src={UserCircle} class="{size} border rounded-full stroke-zinc-600 dark:stroke-zinc-400" />
	{/if}
</div>

{#if withName}
<p>{user.name}</p>
{/if}
</div>
</a>
