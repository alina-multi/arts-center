<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Heart, Eye, EyeSlash } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';

	export let user, button, tags, showRatings, onToggle;
</script>

{#if button && user.ratings.length > 0}
	<div class="flex flex-wrap gap-2">
		<span>Rating by category:</span>
		<button
			class="flex xl:hidden gap-1 font-semibold items-center text-gray-800 hover:text-gray-600 dark:text-zinc-600"
			on:click={() => onToggle()}
		>
			{#if !showRatings}
				<span>View</span>
				<Icon src={Eye} theme="solid" class=" h-4 w-4 " />
			{:else}
				<span>Hide</span>
				<Icon src={EyeSlash} theme="solid" class=" h-4 w-4 transform rotate-180" />
			{/if}
		</button>
	</div>
{/if}

{#if tags}
	<div
		class="{showRatings
			? 'flex'
			: 'hidden xl:flex'}  flex-wrap items-center xl:justify-center gap-3 mt-3 sm:text-sm text-sm mx-auto"
	>
		{#each user.ratings as tag}
			<div
				class="flex items-center gap-1 border dark:border-transparent rounded-full pl-2 xl:pl-3 cursor-pointer hover:shadow-sm hover:border-amber-500 dark:hover:border-gray-600 dark:hover:shadow-sm"
			>
				<a href={localePath(`/${user.username}/tag/${tag?.tag?.title}`)}>{tag?.tag?.title}</a>
				<div
					class="flex items-center px-1 rounded-full bg-amber-600 text-white dark:bg-transparent dark:border-zinc-700 dark:border dark:text-zinc-100"
				>
					<Icon src={Heart} theme="solid" class=" h-3 w-3  " />
					<span class="text-xs leading-5 font-semibold dark:font-light"> {tag?.rating}</span>
				</div>
			</div>
		{/each}
	</div>
{/if}
