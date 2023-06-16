<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import { page } from '$app/stores';
	import CommentInput from './CommentInput.svelte';

	export let comments, commentable_id: string;
	commentable_id = commentable_id?.toString();
	const currentUser = $page.data.currentUser;

	let parentComments = [...comments];
	let textarea = '';

	let new_comment = null;

	if (new_comment) {
		new_comment = null;
	}

	async function fetchData(
		textarea: 
		comment_id: string | undefined = undefined
	) {
		return await fetch('/api/comment', {
			method: 'POST',
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({
				commentable_id,
				commentable_type: 'work',
				comment_id,
				text: textarea.value
			})
		});
	}

	async function addNewComment() {
		const response = await fetchData(textarea);
		if (response.ok) {
			new_comment = await response.json();
			parentComments = [...parentComments, { ...new_comment, owner: currentUser }];
			textarea.value = '';
		} else {
			console.error(response);
		}
	}

	console.log('parentComments First', parentComments);
</script>

<div>
	<h3 class="sr-only">Comments</h3>

	<div><CommentInput onSubmit={addNewComment} bind:textarea /></div>

	{#each parentComments as comment}
		<CommentBlock {comment} {commentable_id} bind:parentComments {fetchData} />
	{/each}
</div>
