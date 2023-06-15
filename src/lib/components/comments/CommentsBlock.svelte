<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import type { Comment } from '$lib/interfaces/Comment';
	import { page } from '$app/stores';
	import CommentInput from './CommentInput.svelte';
	import { handleSubmitComment } from './handleSubmitComment';
	

	export let comments: Comment[], commentable_id: bigint;

	const currentUser = $page.data.currentUser;
	let parentComments = [...comments];
	let textarea = '';
	let answer;

	console.log(parentComments);
	console.log(answer);

	 if (answer) {
		parentComments = [...answer, ...parentComments];
		answer = null;
	}

	async function handleSubmit() {
		const response = await handleSubmitComment({
			method: 'POST',
			commentable_id: commentable_id.toString(),
			commentable_type: 'work',
			text: textarea.value
		});

		if (response.ok) {
			const new_comment = await response.json();
			answer = {...new_comment, owner: currentUser};
			textarea.value = '';
			console.log(answer);
			
		} else {
			console.log(response);
		}
	}
</script>

<div>
	<h3 class="sr-only">Comments</h3>
	{#if currentUser}
		<div><CommentInput {handleSubmit} bind:textarea /></div>

	{/if}
	{#if answer}
	<h1>answer</h1>
	<CommentBlock comment={answer} {commentable_id} bind:parentComments />
	
{/if}

	{#each comments as comment}
		<CommentBlock {comment} {commentable_id} bind:parentComments />
	{/each}
</div>
