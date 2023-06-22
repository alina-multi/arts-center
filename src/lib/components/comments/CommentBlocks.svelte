<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import { page } from '$app/stores';
	import CommentInput from './CommentInput.svelte';
	import toast, { Toaster } from 'svelte-french-toast';
	import { convertFetch } from '$lib/helpers/convertFetch';
	import { сommentValidations } from '$lib/helpers/comments';

	export let comments, commentable_id: string;
	commentable_id = commentable_id?.toString();
	const currentUser = $page.data.currentUser;

	let parentComments = [...comments];
	$: value = '';
	let new_comment = null;
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
		

		const fetch = fetchData(value);
		toast.promise(convertFetch(fetch), {
			loading: 'Adding comment...',
			success: 'comment added',
			error: 'Error adding comment'
		});

		const response = await fetch;
		new_comment = await response.json();

		if (!response.ok) {
			return;
		}

		parentComments = [...parentComments, { ...new_comment, owner: currentUser }];
		value = '';
	}
</script>

<Toaster />
<div>
	<h3 class="sr-only">Comments</h3>
	{#if currentUser} <CommentInput onSubmit={addNewComment} bind:value /> {/if}
	{#each parentComments as comment}
		<CommentBlock {comment} {commentable_id} bind:parentComments {fetchData} />
	{/each}
</div>
