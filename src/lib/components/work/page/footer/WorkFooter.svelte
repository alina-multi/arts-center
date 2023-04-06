<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import CommentsPrewiev from '$lib/components/comments/CommentsPrewiev.svelte';
	import TagButtons from '$lib/components/atoms/TagButtons.svelte';

	export let work,
		autorizated = false,
		comments;
		console.log(work);	
</script>

<div
	class="flex max-lg:flex-col justify-beetwen items-stretch lg:items-start  mt-3 lg:mt-6  gap-6  dark:text-gray-300"
>
	{#if !autorizated}
		<div
			class="flex lg:hidden flex-col border  border-gray-200 dark:border-gray-700 gap-6 p-6 rounded-md shadow-sm "
		>
			<h3 class="text-lg font-semibold">Sign in to comment this work</h3>
			<p class="text-gray-500">
				Sign in with your email address to follow this work and get updates on your Feed.
			</p>
			<button
				class=" dark:bg-gray-900 text-center mx-auto w-full sm:max-lg:w-1/2 dark:border-sky-700 dark:border rounded-full px-3 py-1 text-white bg-amber-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
				>Sign in</button
			>
		</div>
	{/if}

	<div class="lg:w-4/6"><CommentsPrewiev {comments} count={work.comments} /></div>

	<div class="flex flex-col sm:flex-row lg:flex-col  gap-6  lg:w-2/6 ">
		{#if !autorizated}
			<div
				class="hidden lg:flex flex-col border  border-gray-200 dark:border-gray-800 gap-6 p-6 rounded-md shadow-sm "
			>
				<h3 class="text-lg font-semibold">Sign in to comment this work</h3>
				<p class="text-gray-500">
					Sign in with your email address to follow this work and get updates on your Feed.
				</p>
				<button
					class=" dark:bg-gray-900 text-center dark:border-sky-700 dark:border rounded-full px-3 py-1 text-white bg-amber-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
					>Sign in</button
				>
			</div>
		{/if}
		{#if work.tags.length > 0}
			<div
				class="lg:hidden  flex  flex-col border  border-gray-200 dark:border-gray-800  gap-6 p-6 rounded-md shadow-sm  sm:w-1/2"
			>
				<div class="flex  items-center justify-start flex-wrap gap-3  dark:text-gray-100 ">
					<span>Tags:</span>
					<TagButtons tags={work.tags} dots/>
				</div>
			</div>
		{/if}

		<div
			class=" flex flex-col border  border-gray-200 dark:border-gray-800 gap-6 p-6 rounded-md shadow-sm "
		>
			{#each work.owners as user}
				<UserPreviewRegular {...user} />
			{/each}

			<butoon
				class="  dark:bg-gray-900 text-center dark:border-sky-700 dark:border rounded-full py-1 text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
				>Follow
				<span /></butoon
			>
		</div>
	</div>
</div>
