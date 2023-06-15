<script lang="ts">
	import CommentsBlock from '$lib/components/comments/CommentsBlock.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowDown } from '@steeze-ui/heroicons';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';
	import { page } from '$app/stores';

	export let comments, count: number, commentable_id: bigint;
	

	let currentUser = $page.data.currentUser;

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
	{#if currentUser}
		
		<div class="-mt-6 mb-6"><CommentInput  {commentable_id} commentable_type={'work'} /></div>	
		
	{/if}
	<div class="border py-1 bg-gray-50 dark:bg-gray-900 dark:border-gray-800 ">
		<span class="px-6 text-sm ">Comments: {count}</span>
	</div>

	<div
		class="flex flex-col border-b md:border border-t-transparent md:px-6 pb-6 gap-6 md:rounded-b-md dark:border-gray-800"
	>
		{#if comments.length > 0}
			<CommentsBlock comments={visibleComments}  {commentable_id}/>
		{:else}
			<div class="text-center text-gray-500">
				This post has no comments yet. Be the first to comment!
			</div>
		{/if}

		{#if comments.length > 3 && hiddenComments.length > 0}
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<butoon
				on:click={onShowMore}
				class=" flex items-center gap-1 text-center mx-auto hover:underline text-sky-700 rounded-full dark:text-gray-100 cursor-pointer"
				>show {hiddenComments.length} more comments
				<Icon class="w-3 h-3 stroke-sky-600" src={ArrowDown} theme="solid" />
			</butoon>
		{/if}
	</div>
</div>
