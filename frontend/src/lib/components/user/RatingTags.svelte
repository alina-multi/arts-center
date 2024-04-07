<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Heart } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';

	const locale = getContext('locale');

	export let user;
</script>

<div class=" space-y-1 overflow-hidden t xl:block px-9 pt-3 pb-6">
	{#each user.ratings as tag}
		<div class="flex items-center justify-between w-full">
			<a
				href={localePath($locale, `/${user.username}/tag/${tag?.tag?.title}`)}
				class="cursor-pointer hover:underline">{tag?.tag?.title}</a
			>
			<div class="flex items-center gap-1">
				<Icon src={Heart} class=" h-4 w-4  " />
				<span> {tag?.rating}</span>
			</div>
		</div>
	{/each}
</div>
