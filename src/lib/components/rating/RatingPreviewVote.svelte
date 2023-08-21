<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import VotedList from '$lib/components/rating/VotedList.svelte';
	import { page } from '$app/stores';
	import LikeButton from './LikeButton.svelte';
	import DislikeButton from './DislikeButton.svelte';
	import AuthModal from '../atoms/AuthModal.svelte';

	export let entity: Work | Comment,
		allowDownVote = false,
		votable_type: string,
		showVotedPreview = false,
		size = 'w-6 h-6';
	let currentUser = $page.data.currentUser;
	let votes = entity?.votes;
	let rating = entity?.rating;
	let isLiked = entity?.votes?.some((vote) => vote?.id.toString() === currentUser?.id.toString());
	let isDownVoted = false;
	let open = false;

	async function vote(method, vote: number = 1) {
		return await fetch(`/api/vote`, {
			method,
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({ vote, votable_type, votable_id: entity.id.toString() })
		});
	}

</script>



{#if showVotedPreview}
	<VotedList {votes} {isLiked} {currentUser} />
{/if}

<div class="inline-flex items-center gap-2 dark:text-zinc-100 cursor-pointer">
	<div
		class="flex items-center gap-2 {votable_type === 'work'
			? 'border px-4 py-1 rounded-full shadow-md '
			: 'hover:text-zinc-100'}  dark:bg-zinc-800 bg-white dark:border-zinc-700 dark:text-white"
	>
		{#if votable_type === 'work'}
			<span class="border-r dark:border-zinc-700 pr-3 ">Like {rating}</span>
		{/if}
		<LikeButton
		    {size}
			bind:isLiked
			bind:isDownVoted
			bind:rating
			bind:open
			{votes}
			{votable_type}
			{vote}
			
		/>
			
	</div>

	{#if votable_type === 'comment' && rating > 0}
		<span class={rating > 0 ? 'border-r dark:border-zinc-700 pr-3' : ''}>{rating}</span>
	{/if}

	{#if allowDownVote}
	<DislikeButton
		{size}
		bind:isLiked
		bind:isDownVoted
		bind:rating
		bind:open
		{vote}	
	/>	
	{/if}
</div>



<AuthModal bind:open />