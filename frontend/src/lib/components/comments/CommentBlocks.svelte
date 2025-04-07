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

	commentable_id;
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
			commentable_id: Number(commentable_id),
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

{#if !$isUserLoading}
	<div
		class=" flex flex-col xl:gap-12 xl:bg-zinc-100 md:dark:bg-black pb-16 xl:rounded-3xl overflow-hidden"
	>
		<h3 class="sr-only">Comments</h3>
		<div class=" w-full">
			{#if $user}
				<div
					class="w-full bg-zinc-100 px-4 py-9 xl:p-9 xl:px-9 md:dark:bg-zinc-900 xl:dark:border md:dark:border-zinc-800"
				>
					<div class="xl:max-w-4xl xl:mx-auto">
						<CommentInput onSubmit={addNewComment} bind:value />
					</div>
				</div>
			{:else}
				<AuthStub />
			{/if}
		</div>

		<div
			class=" xl:w-2/3 xl:mx-auto xl:p-12 md:dark:p-0 md:bg-white md:dark:bg-black md:rounded-3xl"
		>
			{#if commentsCount > 0}
				<div
					class="  border-b border-zinc-200 dark:px-6 dark:border dark:border-zinc-800 dark:bg-zinc-900 max-xl:py-6 xl:pb-6 dark:py-6 font-semibold"
				>
					<span class="px-4 md:px-9 lg:px-0"
						>{$t('global.comment.comments')} {commentsCount > 0 ? commentsCount : ''}</span
					>
				</div>

				<ul id="parentBlock" class=" px-4 md:px-9 lg:px-0">
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
									{commentable_type}
									bind:parentComments
									bind:commentsCount
								/>
							</li>
						{:else}
							<CommentBlock
								{comment}
								{commentable_type}
								{commentable_id}
								bind:parentComments
								bind:commentsCount
							/>
						{/if}
					{/each}
				</ul>
			{:else}
				<NoResultsStub />
			{/if}
		</div>
	</div>
{/if}
