<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import { commentsState } from '$lib/stores/comment';
	import { user as currentUser, showAuthModal } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let comment: Comment,
		value: string,
		isEdited: boolean,
		isEditing: boolean,
		editing_comment: Comment | null;

	function onReply() {
		if (!$currentUser) {
			showAuthModal.set(true);
			return;
		}
		commentsState.showReplyForm(comment);
		commentsState.hideEditForm();
		value = '';
	}
</script>

<a
	href="#{comment.id}"
	class=" {isEditing ? 'hidden ' : ''} 
				relative prose prose-sm border block border-zinc-200 py-3 px-6 pb-3 rounded-full bg-zinc-50 dark:bg-zinc-900 dark:text-white dark:border-zinc-800 space-y-2"
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
			class="flex gap-2 text-xs items-center hover:text-black dark:hover:text-white text-zinc-600 dark:text-zinc-300 font-semibold px-3"
		>
			<span>{$t('global.comment.reply')}</span>
		</button>
		<div class="px-3 flex">
			<RatingPreviewVote entity={comment} allowDownVote size={'w-4 h-4'} votable_type={'comment'} />
		</div>
	</div>
</a>
