<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import type { Comment } from '$lib/interfaces/Comment';
	import { page } from '$app/stores';
	import CommentInput from './CommentInput.svelte';
	import toast, { Toaster } from 'svelte-french-toast';
	import { convertFetch } from '$lib/helpers/convertFetch';
	import { сommentValidations, commentMassage, scrollToBottom } from '$lib/helpers/comments';
	import { tick } from 'svelte';

	export let comments, commentable_id: string;
	commentable_id = commentable_id?.toString();
	const currentUser = $page.data.currentUser;
	let parentComments = [...comments];
	$: value = '';
	let new_comment: Comment | null = null;
	let new_comment_loaded = false;

	if (new_comment) {
		new_comment = null;
	}

	async function fetchData(value: string, comment_id: string | undefined = undefined) {
		return await fetch('/api/comment', {
			method: 'POST',
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({
				commentable_id,
				commentable_type: 'work',
				comment_id,
				text: value
			})
		});
	}

	async function addNewComment() {
		if (!сommentValidations(value)) {
			return;
		}
		new_comment_loaded = false;

		const fetch = fetchData(value);
		toast.promise(convertFetch(fetch), commentMassage.add);
		const response = await fetch;
		new_comment = await response.json();

		if (!response.ok) {
			return;
		}

		scrollToBottom('parentBlock');
		parentComments = [...parentComments, { ...new_comment, owner: currentUser }];
		value = '';

		await tick();
		new_comment_loaded = true;
	}
</script>

<Toaster />
<div>
	<h3 class="sr-only">Comments</h3>
	{#if currentUser} <CommentInput onSubmit={addNewComment} bind:value /> {/if}
	<div id="parentBlock">
		{#each parentComments as comment (comment.id)}
			{#if comment.id === new_comment?.id}
				<div
					class=" transition-opacity delay-500 {new_comment_loaded ? 'opacity-100' : 'opacity-50'}"
				>
					<CommentBlock {comment} {commentable_id} bind:parentComments {fetchData} />
				</div>
			{:else}
				<CommentBlock {comment} {commentable_id} bind:parentComments {fetchData} />
			{/if}
		{/each}
	</div>
</div>
