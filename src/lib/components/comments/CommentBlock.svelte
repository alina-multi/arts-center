<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';
	import { page } from '$app/stores';
	import Time from 'svelte-time';
	import { commentsState } from '$lib/stores/comment';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { convertFetch } from '$lib/helpers/convertFetch';
	import { сommentValidations, commentMassage, scrollToBottom } from '$lib/helpers/comments';
	import toast from 'svelte-french-toast';
	import { tick } from 'svelte';

	export let comment: Comment,
		commentable_id: string,
		parentComments: [Comment] | [],
		fetchData: (value: string, comment_id?: string) => Promise<Response>;

	const isMy = $page.data.work.owners.some((owner: { id: string }) =>
		handleIsMy($page.data.currentUser, owner.id)
	);
	const currentUser = $page.data.currentUser;
	const comment_id = comment?.id?.toString();
	$: value = '';
	let answer: Comment | null = null;
	let answers = comment?.answers ? [...(comment?.answers ?? [])] : [];
	$: isEditing = $commentsState.editCommentId === comment?.id;
	let isEdited = false;
	let editing_comment = null;
	let new_comment_loaded = false;
	let isDelited = false;

	if (answer) {
		answer = null;
	}

	function isEditable(): boolean {
		const now = new Date();
		const createdAt = new Date(comment.created_at);
		const elapsedMinutes = (now - createdAt) / (1000 * 60);
		return elapsedMinutes < 5;
	}

	function onReply() {
		if (!currentUser) {
			return;
		}
		commentsState.showReplyForm(comment);
		commentsState.hideEditForm();
		value = '';
	}

	async function reply() {
		if (!сommentValidations(value)) {
			return;
		}
		new_comment_loaded = false;

		const fetch = fetchData(value, comment_id);
		toast.promise(convertFetch(fetch), commentMassage.reply);

		const response = await fetch;
		answer = await response.json();
		if (!response.ok) {
			return;
		}

		scrollToBottom(`${comment_id}`);
		value = '';
		commentsState.hideReplyForm();

		answers = [...answers, { ...answer, owner: currentUser }];
		await tick();
		new_comment_loaded = true;
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

		const response = await fetch(`/api/comment/${comment_id}`, {
			method: 'PUT',
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({
				text: value
			})
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
		const response = await fetch(`/api/comment/${comment_id}`, {
			method: 'DELETE',
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({})
		});
		toast.dismiss();
		toast.promise(convertFetch(response), commentMassage.delete);

		if (!response.ok) {
			return;
		}
		isDelited = true;
		setTimeout(() => {
			answers = [];
			parentComments = parentComments.filter((item) => item.id !== comment_id);
		}, 500);
	}
</script>

<div
	class="text-sm text-gray-800 dark:text-gray-400 transition-opacity delay-0 {isDelited
		? 'opacity-50'
		: 'opacity-100'}"
	id={comment_id}
>
	<div class="pt-6 space-y-1">
		<div class="flex items-center gap-2">
			<div class="flex font-semibold">
				<Avatar user={comment.owner} withName={true} size={'w-8 h-8 '} />
			</div>
			<span class="h-1 w-1 bg-zinc-500 rounded-full" />
			<Time relative timestamp={comment.created_at} class="text-zinc-500" />

			<div
				class="flex divide-x font-semibold text-zinc-500 dark:text-zinc-400 dark:divide-zinc-800 mr-3"
			>
				{#if currentUser && Number(currentUser.id) === Number(comment.owner.id)}
					{#if isEditable()}<button class="px-3" on:click={() => onEdit()}> Edit </button>{/if}
					{#if !isMy}
						<button class="px-3" on:click={() => deleteComment(comment.id)}> Delete</button>{/if}
				{/if}

				{#if isMy}
					<button class="px-3" on:click={() => deleteComment(comment.id)}> Delete</button>
				{/if}
			</div>
		</div>

		<div
			class=" {isEditing ? 'hidden ' : ''} 
				relative prose prose-sm max-w-none border p-3 pb-6 rounded-md bg-gray-50 dark:bg-zinc-900 dark:text-white dark:border-zinc-800 space-y-2"
		>
			{#if comment.id === editing_comment?.id}
				<div
					class="whitespace-pre-wrap transition-all delay-500 {isEdited
						? 'opacity-100 '
						: 'opacity-50'}"
				>
					{comment.text}
				</div>
			{:else}
				<div class="whitespace-pre-wrap">{comment.text}</div>
			{/if}

			<div
				class="absolute -bottom-4 right-0 flex justify-end items-center border rounded-full bg-white py-1 divide-x dark:border-zinc-600 dark:divide-zinc-600 mr-3 dark:bg-zinc-800"
			>
				<button
					on:click={onReply}
					class="flex gap-2 text-xs items-center hover:text-gray-900 dark:hover:text-white text-zinc-600 dark:text-zinc-300 font-semibold px-3"
				>
					<span>Reply</span>
				</button>
				<div class="px-3 flex">
					<RatingPreviewVote
						entity={comment}
						allowDownVote
						size={'w-4 h-4'}
						votable_type={'comment'}
					/>
				</div>
			</div>
		</div>

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
					Cancel
				</button>
			</CommentInput>
		{/if}

		{#if answers.length > 0}
			<div class="lg:ml-12">
				<div class=" border-l pl-6 lg:pl-9 dark:border-zinc-800">
					{#each answers as reply (reply.id)}
						{#if reply.id.toString() === answer?.id.toString()}
							<div
								class=" transition-opacity delay-500 {new_comment_loaded
									? 'opacity-100'
									: 'opacity-50'}"
							>
								<svelte:self
									comment={reply}
									{commentable_id}
									bind:parentComments={answers}
									{fetchData}
								/>
							</div>
						{:else}
							<svelte:self
								comment={reply}
								{commentable_id}
								bind:parentComments={answers}
								{fetchData}
							/>
						{/if}
					{/each}
				</div>
			</div>
		{/if}
	</div>
</div>
