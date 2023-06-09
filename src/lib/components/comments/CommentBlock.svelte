<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';
	import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';
	import { page } from '$app/stores';
	import Time from 'svelte-time';
	import { data } from '$lib/stores/comment';

	export let comment: Comment;

	const onReplay = () => {
		data.showReplyForm(comment);
	};
	const handleReply = (content) => data.reply(content, comment);

	let value = '';
	let currentUser = $page.data.currentUser;
	$: html = new QuillDeltaToHtmlConverter(comment?.body?.ops, {}).convert();
</script>

<div class="text-sm text-gray-800 dark:text-gray-400">
	<div class="pt-6 space-y-1">
		<div class="flex items-center gap-1">
			<div class="font-semibold">
				<Avatar user={comment.owner} withName={true} size={'w-8 h-8 '} />
			</div>

			<span class="h-1 w-1 bg-gray-500 rounded-full" />
			<Time relative timestamp={comment.created_at} class="text-gray-500" />
		</div>

		<div
			class="relative prose prose-sm max-w-none border p-3 pb-6 rounded-md bg-gray-50 dark:bg-gray-900 dark:border-gray-600 space-y-2"
		>
			<div>{@html html}</div>

			{#if currentUser}
				<div
					class="absolute -bottom-4 right-0 flex justify-end items-center border rounded-full bg-white py-1 divide-x dark:bg-black dark:border-gray-600 dark:divide-gray-600 mr-3"
				>
					<button
						on:click={onReplay}
						class="flex gap-2 text-xs items-center hover:text-gray-900 text-gray-600 dark:text-gray-400 font-semibold px-3"
					>
						<span>Reply</span>
					</button>
					<div class="px-3 flex">
						<RatingPreviewVote
							entity={comment}
							{currentUser}
							allowDownVote
							size={'sm'}
							votable_type={'comment'}
						/>
					</div>
				</div>
			{/if}
		</div>

		{#if $data.replyCommentId === comment.id}
			<div class=" ">
				<CommentInput onSubmit={handleReply} isReply />
			</div>
		{/if}

		{#if comment?.answers}
			<div class="lg:ml-12">
				<div class=" border-l pl-6 lg:pl-9 dark:border-gray-800">
					{#each comment.answers as reply}
						<svelte:self comment={reply} />
					{/each}
				</div>
			</div>
		{/if}
	</div>
</div>
