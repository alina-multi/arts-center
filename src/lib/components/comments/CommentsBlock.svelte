<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import type { Comment } from '$lib/interfaces/Comment';
	import { page } from '$app/stores';
	import CommentInput from './CommentInput.svelte';
	import { handleSubmitComment } from './handleSubmitComment';

	export let comments: Comment[], commentable_id: bigint;

	const currentUser = $page.data.currentUser;
	$: parentComments = [...comments];
	let textarea = '';
	let new_comment;
	let new_comments = [];

	if (new_comment) {
		parentComments.unshift(new_comment);
		console.log(new_comments);
		new_comment = null;
		
	}

	async function handleSubmit(method) {
		const response = await handleSubmitComment({
			method,
			commentable_id: commentable_id.toString(),
			commentable_type: 'work',
			text: textarea.value
		});

		if (response.ok) {
			const data = await response.json();
			new_comment = { ...data, owner: currentUser };
			new_comments = [new_comment, ...new_comments];
			parentComments = [new_comment, ...parentComments];
			
			textarea.value = '';
		} else {
			console.error(response);
		}
	}
</script>

<div>
	<h3 class="sr-only">Comments</h3>
	{#if currentUser}
		<div><CommentInput {handleSubmit} bind:textarea /></div>
	{/if}
	{#if new_comment}
	<h1>new comment</h1>
		{#each new_comments as comment}
			<CommentBlock {comment} {commentable_id} bind:parentComments />
		{/each}
	{/if}

	{#each comments as comment}
		<CommentBlock {comment} {commentable_id} bind:parentComments />
	{/each}
</div>
