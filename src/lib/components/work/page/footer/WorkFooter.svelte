<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import { page } from '$app/stores';

	export let work, comments;
</script>

<div
	class="flex max-lg:flex-col justify-beetwen items-stretch lg:items-start  lg:mt-6 gap-3 dark:text-gray-300"
>
	<!-- {#if !$page.data.currentUser}
		<div
			class="flex lg:hidden flex-col border border-gray-200 dark:border-gray-700 gap-6 p-6 rounded-md shadow-sm"
		>
			<h3 class="text-lg font-semibold">Sign in to comment this work</h3>
			<p class="text-gray-500">
				Sign in with your email address to follow this work and get updates on your Feed.
			</p>
			<button
				class=" dark:bg-gray-900 text-center mx-auto w-full sm:max-lg:w-1/2 dark:border-sky-700 dark:border rounded-full px-3 py-1 text-white bg-amber-700 font-semibold shadow-sm hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
				>Sign in</button
			>
		</div>
	{/if} -->

	<div class="flex flex-col sm:flex-row sm:w-full lg:flex-col gap-3 sm:gap-6 lg:w-2/6">
		 <!-- {#if !$page.data.currentUser}
			<div
				class="hidden lg:flex flex-col border border-gray-200 dark:border-gray-800 gap-3 p-3 rounded-md shadow-sm"
			>
				<h3 class="text-lg font-semibold">Sign in to comment this work</h3>
				<p class="text-gray-500">
					Sign in with your email address to follow this work and get updates on your Feed.
				</p>
				<button
					class=" dark:bg-gray-900 text-center dark:border-sky-700 dark:border rounded-full px-3 py-1 text-white bg-amber-700 font-semibold shadow-sm hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
					>Sign in</button
				>
			</div>
		{/if}  -->

		{#if work?.tags.length > 0}
			<div
				class=" flex sm:max-lg:w-1/2 flex-wrap items-start justify-start border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 p-3 gap-3 sm:p-6 rounded-md shadow-sm"
			>
				<span>Tags:</span>
				{#each work.tags as { title }}
					<a
						href={`/tag/${title}/popular`}
						class="border dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700 shadow-sm px-3 rounded-full hover:border-amber-600 hover:shadow-sm"
						>#{title}</a
					>
				{/each}
			</div>
		{/if} 

		<div
			class=" flex flex-col border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900  gap-3 p-3 rounded-md shadow-sm sm:max-lg:w-1/2"
		>
			{#each work.owners as user}
				<UserPreviewRegular {user} followBtn={'block'} />
			{/each}
		</div>
	</div>

	<div class="lg:w-4/6 ">
		<div class="flex flex-col text-gray-800 dark:text-gray-300">
			<div class="border py-3 bg-gray-50 dark:bg-zinc-800 dark:border-zinc-800">
				<span class="px-6 font-semibold">Comments: {work.comments}</span>
			</div>

			<div
				class="flex flex-col border-b md:border border-t-transparent md:px-6 pb-6 gap-6 md:rounded-b-md dark:border-zinc-800"
			>
				<CommentBlocks {comments} commentable_id={work.id} />
			</div>
		</div>
	</div>

	
</div>
