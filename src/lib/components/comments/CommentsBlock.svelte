<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import { page } from '$app/stores';
	import CommentInput from './CommentInput.svelte';

	export let comments, commentable_id: string;
	commentable_id = commentable_id?.toString();
	const currentUser = $page.data.currentUser;

	let parentComments = [...comments];
	$: value = '';
	let new_comment = null;
	if (new_comment) {
		new_comment = null;
	}

	async function fetchData(value:string , comment_id:string | undefined = undefined) {
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
		const response = await fetchData(value);
		if (response.ok) {
			new_comment = await response.json();
			parentComments = [...parentComments, { ...new_comment, owner: currentUser }];
			value = '';
		} else {
			console.error(response);
		}
	}
</script>

<div>
	<h3 class="sr-only">Comments</h3>
	<CommentInput onSubmit={addNewComment} bind:value />
	{#each parentComments as comment}
		<CommentBlock {comment} {commentable_id} bind:parentComments  {fetchData} />
	{/each}
</div>
