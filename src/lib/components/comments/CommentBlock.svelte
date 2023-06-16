<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import CommentInput from '$lib/components/comments/CommentInput.svelte';
	import { page } from '$app/stores';
	import Time from 'svelte-time';
	import { data } from '$lib/stores/comment';
	import { handleIsMy } from '$lib/helpers/handleIsMy';

	export let comment: Comment,
		commentable_id: string,
		parentComments: [Comment],
		fetchData: Promise<Response>;

	const isMy = $page.data.work.owners.some((owner: { id: string }) =>
		handleIsMy($page.data.currentUser, owner.id)
	);
	const currentUser = $page.data.currentUser;
	const comment_id = comment?.id?.toString();
	let textarea = '';
	let editedValue = '';
	let answer: Comment | null;
	let answers = comment?.answers ? [...comment?.answers] : [];

	$: if (answer) {
		answers = [{ ...answer, owner: currentUser }, ...answers];
		answer = null;
	}

	async function edit(comment_id) {
		const response = await fetch(`/api/comment/${comment_id}`, {
			method: 'PUT',
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({
				text: editedValue
			})
		});

		if (response.ok) {
			// parentComments = parentComments.map((item) => {
			// 	if (item.id === comment_id) {
			// 		item.text = editedValue;
			// 	}
			// 	return item;
			// });
			console.log('response', response);

			// editedValue = '';
		} else {
			console.error(response);
		}
	}

	async function reply() {
		const response = await fetchData(textarea, comment_id);
		if (response.ok) {
			answer = await response.json();
			textarea.value = '';
		} else {
			console.error(response);
		}
	}

	async function deleteComment(comment_id) {
		const response = await fetch(`/api/comment/${comment_id}`, {
			method: 'DELETE',
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({})
		});
		if (response.ok) {
			parentComments = parentComments.filter((item) => item.id !== comment_id);
		} else {
			console.error(response);
		}
		return;
	}

	const onReply = () => {
		data.showReplyForm(comment);
	};

	function onEdit() {
		console.log('onEdit');
		editedValue = comment.text;
		console.log('editedValue', editedValue);
		data.showEditForm(comment);
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

			{#if Number(currentUser.id) === Number(comment.owner.id)}
				<div class="flex divide-x font-semibold text-gray-500 mr-3">
					<button class="px-3" on:click={onEdit(comment.id)}> Edit </button>
					<button class="px-3" on:click={() => deleteComment(comment.id)}> Delete</button>
				</div>
			{/if}

			{#if isMy}
				<button class="px-3"> Delete</button>
			{/if}
		</div>

		<div
			class="relative prose prose-sm max-w-none border p-3 pb-6 rounded-md bg-gray-50 dark:bg-gray-900 dark:border-gray-600 space-y-2"
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

		{#if $data.replyCommentId === comment.id}
			<div>
				<CommentInput isReply onSubmit={reply} commentID={$data.replyCommentId} bind:textarea />
			</div>
		{/if}

		{#if $data.editCommentId === comment.id}
			<div>
				EDIT
				<CommentInput
					isEdit
					onSubmit={edit}
					commentID={$data.editCommentId}
					bind:commentText={editedValue}
				/>
			</div>
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
