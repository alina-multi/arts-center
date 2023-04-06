<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';
	import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowUturnLeft } from '@steeze-ui/heroicons';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';

	let isReply = false;
	let value = '';

	export let comment: Comment,
		autorized = false;
	$: html = new QuillDeltaToHtmlConverter(comment?.body?.ops, {}).convert();

	const onReplay = () => {
		isReply = true;
	};
</script>

<div class="text-sm text-gray-800 dark:text-gray-400 ">
	<div class="pt-3 lg:pt-6">
		<div class="">
			<UserPreviewInline user={comment.owner} />
			<div class="prose prose-sm max-w-none  border  p-3 rounded-md bg-gray-50 dark:bg-gray-900 dark:border-gray-600">
				{@html html}
			</div>
			{#if autorized}
				<div class="flex justify-end items-center gap-6 ">
					<button on:click={onReplay} class="flex gap-2  items-center hover:text-gray-600">
						<Icon src={ArrowUturnLeft} class="w-4 h-4" />
						<span>Reply</span>
					</button>
					<RatingPreviewVote rating={comment.rating} allowDownVote={true} />
				</div>
			{/if}
		</div>

		{#if isReply}
			<div class="my-6">
				<CommentInput />
			</div>
		{/if}

		{#if comment?.answers}
			<div class="lg:ml-12 ">
				<div class=" border-l pl-3 lg:pl-9 dark:border-gray-600 ">
					{#each comment.answers as reply}
						<svelte:self comment={reply} />
					{/each}
				</div>
			</div>
		{/if}
	</div>
</div>
