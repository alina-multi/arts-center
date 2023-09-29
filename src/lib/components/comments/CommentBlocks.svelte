<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import type { Comment } from '$lib/interfaces/Comment';
	import CommentInput from './CommentInput.svelte';
	import toast from 'svelte-french-toast';
	import { convertFetch } from '$lib/helpers/convertFetch';
	import { сommentValidations, commentMassage, scrollToBottom } from '$lib/helpers/comments';
	import { tick } from 'svelte';
	import NoResultsStub from './NoResultsStub.svelte';
	import {fetchData} from '$lib/helpers/fetchData';
	import { user } from '$lib/stores/auth';


	export let comments, commentable_id: string;
	commentable_id = commentable_id?.toString();
	const currentUser = $user;
	let parentComments = [...comments];
	$: value = '';
	let new_comment: Comment | null = null;
	let new_comment_loaded = false;
	let url = '/api/comment';

	if (new_comment) {
		new_comment = null;
	}

	async function addNewComment() {
		if (!сommentValidations(value)) {
			return;
		}
		new_comment_loaded = false;

		const fetch = fetchData('POST', url, {
			commentable_id,
			commentable_type: 'work',
			text: value
		});
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

<div class=" {comments.length > 0 || currentUser ? " md:border border-t-transparent dark:border-t-transparent md:px-6 pb-6 gap-6 md:rounded-b-sm dark:border-zinc-800": "" }  flex flex-col  ">
	<h3 class="sr-only">Comments</h3>
	{#if currentUser} <CommentInput onSubmit={addNewComment} bind:value /> {/if}
	{#if comments.length > 0}
	<div id="parentBlock">
		{#each parentComments as comment (comment.id)}
			{#if comment.id === new_comment?.id}
				<div
					class=" transition-opacity delay-500 {new_comment_loaded ? 'opacity-100' : 'opacity-50'}"
				>
					<CommentBlock {comment} {commentable_id} bind:parentComments  />
				</div>
			{:else}
				<CommentBlock {comment} {commentable_id} bind:parentComments  />
			{/if}
		{/each}
	</div>
	{:else}
	<NoResultsStub />
	{/if}

</div>
