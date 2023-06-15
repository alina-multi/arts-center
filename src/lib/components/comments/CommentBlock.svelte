<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';
	import { page } from '$app/stores';
	import Time from 'svelte-time';
	import { data } from '$lib/stores/comment';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { handleSubmitComment } from './handleSubmitComment';

	export let comment: Comment, commentable_id, parentComments;

	let isMy = $page.data.work.owners.some((owner) => handleIsMy($page.data.currentUser, owner.id));
	let currentUser = $page.data.currentUser;
	let textarea = '';

	let answers = comment?.answers ? [...comment?.answers] : [];
	let answer = null;

	$: if (answer) {
		answers = [{ ...answer, owner: currentUser }, ...answers];
		answer = null;
	}

	let comment_id = comment?.id.toString();
	commentable_id = commentable_id?.toString();

	

	async function postComment() {
		const response = await handleSubmitComment({
			method: 'POST',
			commentable_id,
			commentable_type: 'work',
			comment_id,
			text: textarea.value
		});

		if (response.ok) {
			const new_comment = await response.json();
			textarea.value = '';
			return new_comment;
		} else {
			return 'error';
		}
	}

	async function handleSubmit(method) {
		if (method === 'POST') {
			const response = await postComment();
			if (response !== 'error') {
				answer = response;
			} else {
				console.log(response);
			}
			return;
		}

		if (method === 'DELETE') {
			const response = await handleSubmitComment({
				method: 'DELETE',
				deleteId: comment.id
			});
			if (response.ok) {
				parentComments = parentComments.filter((item) => item.id !== comment.id);
			}
			return;
		}
	}

	const onReplay = () => {
		data.showReplyForm(comment);
	};
</script>

<div class="text-sm text-gray-800 dark:text-gray-400">
	<div class="pt-6 space-y-1">
		<div class="flex items-center gap-2">
			<div class="flex font-semibold">
				<Avatar user={comment.owner} withName={true} size={'w-8 h-8 '} />
			</div>

			<span class="h-1 w-1 bg-gray-500 rounded-full" />
			<Time relative timestamp={comment.created_at} class="text-gray-500" />

			{#if Number(currentUser.id) === Number(comment.owner.id)}
				<div class="flex divide-x font-semibold text-gray-500 mr-3">
					<button class="px-3"> Edit </button>
					<button class="px-3" on:click={() => handleSubmit('DELETE')}> Delete</button>
				</div>
			{/if}

			{#if isMy}
				<button class="px-3"> Delete</button>
			{/if}
		</div>

		<div
			class="relative prose prose-sm max-w-none border p-3 pb-6 rounded-md bg-gray-50 dark:bg-gray-900 dark:border-gray-600 space-y-2"
		>
			<div class="whitespace-pre-wrap">{@html comment.text}</div>

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
				<CommentInput isReply {handleSubmit} bind:textarea />
			</div>
		{/if}

		{#if answers.length > 0}
			<div class="lg:ml-12">
				<div class=" border-l pl-6 lg:pl-9 dark:border-gray-800">
					{#each answers as reply}
						{#if answer}
							<svelte:self comment={answer} {commentable_id} />
						{/if}
						<svelte:self comment={reply} {commentable_id} bind:parentComments={answers} />
					{/each}
				</div>
			</div>
		{/if}
	</div>
</div>
