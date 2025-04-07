<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';
	import { commentsState } from '$lib/stores/comment';
	import { convertFetch } from '$lib/helpers/convertFetch';
	import { scrollToBottom, сommentValidations } from '$lib/helpers/comments';
	import toast from 'svelte-french-toast';
	import { getContext, tick } from 'svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import CommentHeader from '$lib/components/comments/CommentHeader.svelte';
	import CommentBody from '$lib/components/comments/CommentBody.svelte';
	import { user as currentUser } from '$lib/stores/auth';

	const t = getContext('t');
	export let comment: Comment,
		commentable_id: string,
		parentComments: [Comment] | [],
		commentsCount: number,
		commentable_type: 'post' | 'work',
		isMy: boolean;
	let url = '/api/comment';

	const comment_id = comment?.id?.toString();
	$: value = '';
	let answer: Comment | null = null;
	let answers = comment?.answers ? [...(comment?.answers ?? [])] : [];
	$: isEditing = $commentsState.editCommentId === comment?.id;
	let isEdited = false;
	let editing_comment: Comment | null = null;
	let new_comment_loaded = false;
	let isDelited = false;

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

	if (answer) {
		answer = null;
	}

	async function reply() {
		if (!сommentValidations(value)) {
			return;
		}
		new_comment_loaded = false;

		const fetch = fetchData('POST', url, {
			commentable_id: Number(commentable_id),
			commentable_type,
			comment_id,
			text: value
		});
		toast.promise(convertFetch(fetch), commentMassage.add);

		const response = await fetch;
		answer = await response.json();
		if (!response.ok) {
			return;
		}

		scrollToBottom(`${comment_id}`);
		value = '';
		commentsState.hideReplyForm();

		answers = [...answers, { ...answer, owner: $currentUser }];
		await tick();
		new_comment_loaded = true;
		commentsCount = commentsCount + 1;
	}

	function onEdit() {
		editing_comment = comment;
		value = comment.text;
		commentsState.showEditForm(comment);
		isEditing = true;
	}

	async function edit(comment_id: string) {
		if (!сommentValidations(value)) {
			return;
		}

		const response = await fetchData('PUT', `${url}/${comment_id}`, {
			text: value
		});

		toast.promise(convertFetch(response), commentMassage.edit);

		if (!response.ok) {
			return;
		}
		comment.text = value;
		commentsState.hideEditForm();

		await tick();
		isEdited = true;
	}

	async function deleteComment(comment_id: string) {
		const response = await fetchData('DELETE', `${url}/${comment_id}`, {});
		toast.dismiss();
		toast.promise(convertFetch(response), commentMassage.delete);

		if (!response.ok) {
			return;
		}
		isDelited = true;
		setTimeout(() => {
			answers = [];
			parentComments = parentComments.filter((item) => item.id.toString() !== comment_id);
		}, 500);
		commentsCount = commentsCount - 1;
	}
</script>

<li
	class="text-sm text-black dark:text-gray-400 transition-opacity delay-0 {isDelited
		? 'opacity-50'
		: 'opacity-100'}"
	id={comment_id}
>
	<div class="pt-6 space-y-1">
		<CommentHeader {isMy} {comment} {onEdit} {deleteComment} {parentComments} />
		<CommentBody {comment} bind:value {isEdited} {isEditing} {editing_comment} />

		{#if $commentsState.replyCommentId === comment.id}
			<div>
				<CommentInput isReplying onSubmit={reply} commentID={comment.id} bind:value />
			</div>
		{/if}

		{#if isEditing}
			<CommentInput bind:isEditing onSubmit={edit} commentID={comment.id} bind:value>
				<button
					on:click={() => {
						commentsState.hideEditForm();
						editing_comment = null;
					}}
					class=" px-6 py-1 shadow-sm border dark:border-zinc-600 text-zinc-500 text-sm font-semibold rounded-full hover:text-white hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700"
				>
					{$t('global.buttons.cancel')}
				</button>
			</CommentInput>
		{/if}

		{#if answers.length > 0}
			<ul class="lg:ml-12">
				<div class=" border-l pl-6 lg:pl-9 dark:border-zinc-800">
					{#each answers as reply (reply.id)}
						{#if reply.id.toString() === answer?.id.toString()}
							<li
								class=" transition-opacity delay-500 {new_comment_loaded
									? 'opacity-100'
									: 'opacity-50'}"
							>
								<svelte:self
									comment={reply}
									{commentable_id}
									{commentable_type}
									bind:parentComments={answers}
									bind:commentsCount
								/>
							</li>
						{:else}
							<svelte:self
								comment={reply}
								{commentable_id}
								{commentable_type}
								bind:parentComments={answers}
								bind:commentsCount
							/>
						{/if}
					{/each}
				</div>
			</ul>
		{/if}
	</div>
</li>
