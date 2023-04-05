<script lang="ts">
	import CommentsBlock from '$lib/components/comments/CommentsBlock.svelte';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';
	export let comments,
		count,
		autorizated = false;

	let visibleComments = comments.slice(0, 3);
	let hiddenComments = comments.slice(3);
	let showMore = false;
	let showMoreStep = 3;

	const onShowMore = () => {
		if (hiddenComments.length > showMoreStep) {
			visibleComments = visibleComments.concat(hiddenComments.slice(0, showMoreStep));
			hiddenComments = hiddenComments.slice(showMoreStep);
			showMore = true;
		} else {
			visibleComments = visibleComments.concat(hiddenComments);
			hiddenComments = [];
		}
	};
</script>

<div class="flex flex-col text-gray-800 dark:text-gray-300">
	{#if autorizated}
		<div class="flex flex-col  border border-b-transparent p-6 rounded-t-md ">
			<CommentInput />
		</div>
	{/if}
	<div class="border py-1  bg-gray-50  dark:bg-gray-900 dark:border-gray-800 ">
		<span class="px-6 text-sm ">Comments: {count}</span>
	</div>

	<div
		class="flex flex-col border-b  md:border border-t-transparent md:px-6 pb-6 gap-6 md:rounded-b-md dark:border-gray-800"
	>
		{#if comments.length > 0}
			<CommentsBlock comments={visibleComments} />
		{:else}
			<div class="text-center text-gray-500">
				This post has no comments yet. Be the first to comment!
			</div>
		{/if}

		{#if comments.length > 3 && hiddenComments.length > 0}
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<butoon
				on:click={onShowMore}
				class="  dark:bg-gray-900 text-center mx-auto  dark:border  rounded-full px-16 py-1 border  shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
				>Show more</butoon
			>
		{/if}
	</div>
</div>
