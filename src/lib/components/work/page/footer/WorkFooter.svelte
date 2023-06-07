<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import CommentsPrewiev from '$lib/components/comments/CommentsPrewiev.svelte';
	import { page } from '$app/stores';

	export let work,
		autorizated = false,
		comments;
</script>

<div
	class="flex max-lg:flex-col justify-beetwen items-stretch lg:items-start mt-3 lg:mt-6 gap-6 dark:text-gray-300"
>
	{#if !$page.data.user}
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
	{/if}

	<div class="lg:w-4/6"><CommentsPrewiev {comments} count={work.comments} /></div>

	<div class="flex flex-col sm:flex-row lg:flex-col gap-3 sm:gap-6 lg:w-2/6">
		{#if !$page.data.user}
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
		{/if}

		{#if work?.tags.length > 0}
			<div
				class=" flex flex-0 flex-wrap items-start justify-start border border-gray-200 dark:border-gray-800 p-3 gap-3 sm:p-6 rounded-md shadow-sm"
			>
				<span>Tags:</span>
				{#each work.tags as { title }}
					<a
						href={`/tag/${title}/popular`}
						class="border shadow-sm px-3 rounded-full hover:border-amber-600 hover:shadow-sm"
						>#{title}</a
					>
				{/each}
			</div>
		{/if}

		<div
			class=" flex flex-col border border-gray-200 dark:border-gray-800 gap-3 p-3 rounded-md shadow-sm"
		>
			{#each work.owners as user}
				<UserPreviewRegular {user} followBtn={'block'} />
			{/each}
		</div>
	</div>
</div>
