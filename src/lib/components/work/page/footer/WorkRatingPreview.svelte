<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle } from '@steeze-ui/heroicons';
	import type { Work } from '$lib/interfaces/Work';
	import { localePath } from '$lib/translations';

	export let work: Work;
	// For now let's just show the first 3 votes
	// Later, this can be friends first like on FB
	const votesPreview = work?.votes?.slice(0, 3);
</script>

<div class="dark:text-gray-400 ">
	<div class="flex gap-3 items-center">
		<div>Comments: {work.comments}</div>
		<div class="flex items-center gap-2">
			<div class="hover:underline cursor-pointer ">
				<span class="">Liked by</span>
				{work.rating}
			</div>
			{#if work.votes.length > 0}
				<div class="flex -space-x-3 cursor-pointer">
					{#each votesPreview as vote}
						<a href={localePath('/' + vote.username)}>
							{#if vote.avatar === null}
								<Icon
									src={UserCircle}
									theme="solid"
									class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300 border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
								/>
							{:else}
								<img
									class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300 border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
									src={vote.avatar.src}
								/>
							{/if}
						</a>
					{/each}
				</div>
			{/if}
		</div>
	</div>
</div>
