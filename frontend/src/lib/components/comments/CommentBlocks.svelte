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
	import { user, isUserLoading } from '$lib/stores/auth';
	import AuthStub from '$lib/components/content/AuthStub.svelte';

	const t = getContext('t');
	const comments: Comment[] = getContext('comments');

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

	export let commentable_id: bigint,
		commentsCount: number,
		isMy: boolean,
		commentable_type: 'work' | 'post';

	commentable_id = commentable_id?.toString();
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
			commentable_type,
			text: value
		});
		toast.promise(convertFetch(fetch), commentMassage.add);
		const response = await fetch;
		new_comment = await response.json();
		commentsCount++;

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

<div class=" flex flex-col">
	<h3 class="sr-only">Comments</h3>
	<div class=" h-[270px] xs:h-64 w-full">
		{#if !$isUserLoading}
			{#if $user}
				<div
					class="md:bg-zinc-100 md:shadow md:px-6 xl:py-6 max-xl:mt-9 md:dark:bg-zinc-900 md:dark:border md:dark:border-zinc-800"
				>
					<CommentInput onSubmit={addNewComment} bind:value />
				</div>
			{:else}
				<AuthStub />
			{/if}
		{/if}
	</div>

	<div
		class="max-xl:bg-zinc-100 max-xl:shadow xl:border-b border-zinc-200 dark:px-6 dark:border dark:border-zinc-800 dark:bg-zinc-900 py-3 font-semibold"
	>
		<span class="max-xl:px-4"
			>{$t('global.comment.comments')} {commentsCount > 0 ? commentsCount : ''}</span
		>
	</div>

	{#if commentsCount > 0}
		<ul id="parentBlock" class=" max-xs:px-4">
			{#each parentComments as comment (comment.id)}
				{#if comment.id === new_comment?.id}
					<li
						class=" transition-opacity delay-500 {new_comment_loaded
							? 'opacity-100'
							: 'opacity-50'}"
					>
						<CommentBlock
							{isMy}
							{comment}
							{commentable_id}
							bind:parentComments
							bind:commentsCount
						/>
					</li>
				{:else}
					<CommentBlock {comment} {commentable_id} bind:parentComments bind:commentsCount />
				{/if}
			{/each}
		</ul>
	{:else}
		<NoResultsStub />
	{/if}
</div>
