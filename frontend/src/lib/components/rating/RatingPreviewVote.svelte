<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import type { Post } from '$lib/interfaces/Post';
	import VotedList from '$lib/components/rating/VotedList.svelte';
	import LikeButton from './LikeButton.svelte';
	import DislikeButton from './DislikeButton.svelte';

	import { user } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let entity: Work | Comment | Post,
		allowDownVote = false,
		votable_type: string,
		showVotedPreview = false,
		size = 'w-7 h-7';
	let votes = entity?.votes;
	let rating = entity?.rating;
	$: isLiked = entity?.votes?.some((vote) => vote?.id?.toString() === $user?.id?.toString());
	let isDownVoted = false;
	let votable_id = entity?.id.toString();
</script>

{#if showVotedPreview}
	<VotedList {votes} {isLiked} currentUser={$user} />
{/if}

<div class="inline-flex items-center gap-2 dark:text-white cursor-pointer">
	<div
		class="{votable_type === 'work' || votable_type === 'post'
			? ''
			: 'hover:text-zinc-900'} flex items-end gap-4 dark:text-white"
	>
		{#if votable_type === 'work' || votable_type === 'post'}
			<span
				class=" flex items-center border-r dark:border-zinc-700 pr-4 text-black dark:text-white"
			>
				<span class="hidden sm:block"> {$t('global.voting.like')} </span>
				<span class="ml-1">{rating}</span></span
			>
		{/if}
		<LikeButton
			{size}
			bind:isLiked
			bind:isDownVoted
			bind:rating
			{votes}
			{votable_type}
			{votable_id}
		/>
	</div>

	{#if votable_type === 'comment' && rating > 0}
		<span class={rating > 0 ? 'border-r dark:border-zinc-700 pr-3' : ''}>{rating}</span>
	{/if}

	{#if allowDownVote}
		<DislikeButton {size} bind:isLiked bind:isDownVoted bind:rating {votable_type} {votable_id} />
	{/if}
</div>
