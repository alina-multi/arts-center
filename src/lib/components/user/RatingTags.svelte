<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Heart, ChevronDown, ChevronUp } from '@steeze-ui/heroicons';
	import { localePath, t } from '$lib/translations';

	export let user;
	$: show = false;
</script>

<button on:click={() => (show = !show)} class="flex items-center justify-between w-full xl:hidden">
	<span>Rating by category</span>
	<Icon src={show ? ChevronUp : ChevronDown} class="w-6 h-6 " />
</button>

<div class=" space-y-2 overflow-hidden {show ? 'block' : 'hidden'} xl:block">
	{#each user.ratings as tag}
		<div class="flex items-center justify-between w-full">
			<a href={localePath(`/${user.username}/tag/${tag?.tag?.title}`)}>{tag?.tag?.title}</a>
			<div class="flex items-center gap-1">
				<Icon src={Heart} theme="solid" class=" h-4 w-4  fill-zinc-400" />
				<span> {tag?.rating}</span>
			</div>
		</div>
	{/each}
</div>
