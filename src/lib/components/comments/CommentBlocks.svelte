<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import type { Comment } from '$lib/interfaces/Comment';
	import CommentInput from './CommentInput.svelte';
	import toast from 'svelte-french-toast';
	import { convertFetch } from '$lib/helpers/convertFetch';
	import { scrollToBottom, сommentValidations } from '$lib/helpers/comments';
	import { getContext, tick } from 'svelte';
	import NoResultsStub from './NoResultsStub.svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import { user } from '$lib/stores/auth';

	const t = getContext('t');

	// Todo, just use them in place
	const commentMassage = {
		add: {
			loading: $t('global.comment.add.loading'),
			success: $t('global.comment.add.success'),
			error: $t('global.comment.add.error')
		},
		delete: {
			loading: $t('global.comment.delete.loading'),
			success: $t('global.comment.delete.success'),
			error: $t('global.comment.delete.error')
		},
		edit: {
			loading: $t('global.comment.add.loading'),
			success: $t('global.comment.edit.success'),
			error: $t('global.comment.edit.error')
		}
	};

	export let comments, commentable_id: string, work_comments: number;
	commentable_id = commentable_id?.toString();
	let parentComments = [...comments];
	$: value = '';
	let new_comment: Comment | null = null;
	let new_comment_loaded = false;
	let url = '/api/comment';
	let comments_length = comments.length;

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
		work_comments++;

		if (!response.ok) {
			return;
		}

		scrollToBottom('parentBlock');
		parentComments = [...parentComments, { ...new_comment, owner: $user }];
		value = '';

		await tick();
		new_comment_loaded = true;
	}
</script>


	<div class="flex flex-col text-black dark:text-gray-300">
		<div class="border py-3 bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800 rounded-t-sm">
			<!-- <span class="font-semibold px-3 md:px-6"
				>{comments_length} {$t('global.comment.comments').toLowerCase()}</span
			> -->

			<span class="font-semibold px-3 md:px-6"
				>{work_comments}
				{work_comments === 1
					? $t('global.comment.comment').toLowerCase()
					: $t('global.comment.comments').toLowerCase()}</span
			>
		</div>

		<div
			class=" {comments_length > 0 || $user
				? ' md:border border-t-transparent dark:border-t-transparent md:px-6 pb-6 gap-6 md:rounded-b-sm dark:border-zinc-800'
				: ''}  flex flex-col"
		>
			<h3 class="sr-only">Comments</h3>
			{#if $user}
				<CommentInput onSubmit={addNewComment} bind:value />
			{/if}
			{#if comments_length > 0}
				<ul id="parentBlock">
					{#each parentComments as comment (comment.id)}
						{#if comment.id === new_comment?.id}
							<li
								class=" transition-opacity delay-500 {new_comment_loaded
									? 'opacity-100'
									: 'opacity-50'}"
							>
								<CommentBlock {comment} {commentable_id} bind:parentComments bind:work_comments />
							</li>
						{:else}
							<CommentBlock {comment} {commentable_id} bind:parentComments bind:work_comments />
						{/if}
					{/each}
				</ul>
			{:else}
				<NoResultsStub />
			{/if}
		</div>
	</div>

