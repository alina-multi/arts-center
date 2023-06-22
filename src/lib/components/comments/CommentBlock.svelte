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
	import { сommentValidations, commentMassage } from '$lib/helpers/comments';
	import toast from 'svelte-french-toast';

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
	$: isEditing = $commentsState.editCommentId === comment?.id;
	let answer: Comment | null;
	let answers = comment?.answers ? [...comment?.answers] : [];

	$: if (answer) {
		answers = [{ ...answer, owner: currentUser }, ...answers];
		answer = null;
	}

	const onReply = () => {
		commentsState.showReplyForm(comment);
		commentsState.hideEditForm();
		value = '';
	};

	async function reply() {
		if (!сommentValidations(value)) {
			return;
		}

		const fetch = fetchData(value);
		toast.promise(convertFetch(fetch), commentMassage.reply);

		const response = await fetchData(value, comment_id);
		if (!response.ok) {
			return;
		}
		answer = await response.json();
		value = '';
	}

	function onEdit() {
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
		parentComments = parentComments.filter((item) => item.id !== comment_id);
	}
</script>

<div class="text-sm text-gray-800 dark:text-gray-400">
	<div class="pt-6 space-y-1">
		<div class="flex items-center gap-2">
			<div class="flex font-semibold">
				<Avatar user={comment.owner} withName={true} size={'w-8 h-8 '} />
			</div>
			<span class="h-1 w-1 bg-gray-500 rounded-full" />
			<Time relative timestamp={comment.created_at} class="text-gray-500" />

			{#if currentUser && Number(currentUser.id) === Number(comment.owner.id)}
				<div class="flex divide-x font-semibold text-gray-500 mr-3">
					<button class="px-3" on:click={() => onEdit()}> Edit </button>
					<button class="px-3" on:click={() => deleteComment(comment.id)}> Delete</button>
				</div>
			{/if}

			{#if isMy}
				<button class="px-3"> Delete</button>
			{/if}
		</div>

		<div
			class=" {isEditing
				? 'hidden'
				: ''} relative prose prose-sm max-w-none border p-3 pb-6 rounded-md bg-gray-50 dark:bg-gray-900 dark:border-gray-600 space-y-2"
		>
			<div class="whitespace-pre-wrap">{@html comment.text}</div>
			{#if currentUser}
				<div
					class="absolute -bottom-4 right-0 flex justify-end items-center border rounded-full bg-white py-1 divide-x dark:bg-black dark:border-gray-600 dark:divide-gray-600 mr-3"
				>
					<button
						on:click={onReply}
						class="flex gap-2 text-xs items-center hover:text-gray-900 text-gray-600 dark:text-gray-400 font-semibold px-3"
					>
						<span>Reply</span>
					</button>
					<div class="px-3 flex">
						<RatingPreviewVote
							entity={comment}
							{currentUser}
							allowDownVote
							size={'sm'}
							votable_type={'comment'}
						/>
					</div>
				</div>
			{/if}
		</div>

		{#if $commentsState.replyCommentId === comment.id}
			<div>
				<CommentInput isReplying onSubmit={reply} commentID={comment.id} bind:value />
			</div>
		{/if}

		{#if isEditing}
			<CommentInput bind:isEditing onSubmit={edit} commentID={comment.id} bind:value />
		{/if}

		{#if answers.length > 0}
			<div class="lg:ml-12">
				<div class=" border-l pl-6 lg:pl-9 dark:border-gray-800">
					{#each answers as reply}
						<svelte:self
							comment={reply}
							{commentable_id}
							bind:parentComments={answers}
							{fetchData}
						/>
					{/each}
				</div>
			</div>
		{/if}
	</div>
</div>
