<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import { page } from '$app/stores';
	import AuthStub from '../../AuthStub.svelte';

	export let work, comments;
</script>

<div
	class="flex max-lg:flex-col justify-beetwen items-stretch lg:items-start lg:mt-6 gap-3 dark:text-gray-300"
>
	<div class="flex flex-col sm:w-full lg:flex-col gap-6 lg:w-2/6">
		{#if work?.tags.length > 0}
			<div
				class="hidden lg:flex flex-wrap items-start justify-start border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 sm:p-3 gap-3 md:py-3 p-3 rounded-lgshadow-sm bg-gray-100"
			>
				<span>Tags:</span>
				{#each work.tags as { title }}
					<a
						href={`/tag/${title}/popular`}
						class="border shadow-sm dark:bg-zinc-800 bg-white dark:text-zinc-100 dark:border-zinc-700 pr-3 pl-2 rounded-full hover:border-amber-600 hover:shadow-sm flex items-center gap-1"
					>
						<span class="h-1.5 w-1.5 bg-amber-500 rounded-full" />
						<span>{title}</span>
					</a>
				{/each}
			</div>
		{/if}

		{#if !$page.data.currentUser}
			<div><AuthStub /></div>
		{/if}

		<div
			class=" hidden lg:flex flex-col border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 gap-3 p-3 sm:p-6 sm:gap-6 rounded-md shadow-sm md:max-lg:w-1/2"
		>
			{#each work.owners as user}
				<UserPreviewRegular {user} followBtn={'block'} />
			{/each}
		</div>
	</div>

	<div class="lg:w-4/6">
		<div class="flex flex-col text-gray-800 dark:text-gray-300">
			<div class="border py-3 bg-gray-100 dark:bg-zinc-900 dark:border-zinc-800">
				<span class="font-semibold text-sm px-3 md:px-6">Comments: {work.comments}</span>
			</div>

			<div
				class="flex flex-col md:border border-t-transparent md:px-6 pb-6 gap-6 md:rounded-b-md dark:border-zinc-800"
			>
				<CommentBlocks {comments} commentable_id={work.id} />
			</div>
		</div>
	</div>

	<div class="flex flex-col gap-3 sm:flex-row lg:hidden">
		{#if work?.tags.length > 0}
			<div
				class="sm:w-1/2 px-6 py-3 gap-3 flex flex-wrap items-start h-modal border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 sm:rounded-lg shadow-sm bg-gray-100"
			>
				<span>Tags:</span>
				{#each work.tags as { title }}
					<a
						href={`/tag/${title}/popular`}
						class="border shadow-sm dark:bg-zinc-800 bg-white dark:text-zinc-100 dark:border-zinc-700 pr-3 pl-2 rounded-full hover:border-amber-600 hover:shadow-sm flex items-center gap-1"
					>
						<span class="h-1.5 w-1.5 bg-amber-500 rounded-full" />
						<span>{title}</span>
					</a>
				{/each}
			</div>
		{/if}

		<div
			class=" sm:w-1/2 flex lg:hidden flex-col border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 p-3 gap-3 rounded-md shadow-sm s"
		>
			{#each work.owners as user}
				<UserPreviewRegular {user} followBtn={'block'} />
			{/each}
		</div>
	</div>
</div>
