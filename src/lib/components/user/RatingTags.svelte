<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Heart, Eye, EyeSlash } from '@steeze-ui/heroicons';
	import { localePath, t } from '$lib/translations';

	export let user, showRatings, onToggle;
</script>

<div class="flex flex-wrap gap-2">
	<span class="xl:hidden">Rating by category:</span>
	<button
		class="flex xl:hidden gap-1 items-center text-zinc-500 hover:text-gray-600 dark:text-zinc-600"
		on:click={() => onToggle()}
	>
		{#if !showRatings}
			<span>{$t('global.buttons.show')}</span>
			<Icon src={Eye} theme="solid" class=" h-4 w-4 " />
		{:else}
			<span>{$t('global.buttons.hide')}</span>
			<Icon src={EyeSlash} theme="solid" class=" h-4 w-4 transform rotate-180" />
		{/if}
	</button>
</div>

<div class="{showRatings ? 'block' : 'hidden xl:block'} max-xl:mt-3">
	{#each user.ratings as tag}
		<div class="flex items-center justify-between min-[500px]:w-1/2 sm:w-1/3 xl:w-full">
			<a href={localePath(`/${user.username}/tag/${tag?.tag?.title}`)}>{tag?.tag?.title}</a>
			<div class="flex items-center gap-1">
				<Icon src={Heart} theme="solid" class=" h-4 w-4  fill-zinc-300" />
				<span class=""> {tag?.rating}</span>
			</div>
		</div>
	{/each}
</div>
