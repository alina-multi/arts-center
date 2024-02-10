<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import VotedList from '$lib/components/rating/VotedList.svelte';
	import LikeButton from './LikeButton.svelte';
	import DislikeButton from './DislikeButton.svelte';
	import AuthModal from '../atoms/AuthModal.svelte';
	import { user } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let entity: Work | Comment,
		allowDownVote = false,
		votable_type: string,
		showVotedPreview = false,
		size = 'w-7 h-7';
	let votes = entity?.votes;
	let rating = entity?.rating;
	let isLiked = entity?.votes?.some((vote) => vote?.id?.toString() === $user?.id?.toString());
	let isDownVoted = false;
	let open = false;
	let votable_id = entity?.id.toString();
</script>

{#if showVotedPreview}
	<VotedList {votes} {isLiked} currentUser={$user} />
{/if}

<div class="inline-flex items-center gap-2 dark:text-zinc-100 cursor-pointer">
	<div
		class="flex items-center gap-2 {votable_type === 'work'
			? 'border  border-zinc-200 pr-2 xs:pr-4 rounded-sm shadow'
			: 'hover:text-zinc-100'}  dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
	>
		{#if votable_type === 'work'}
			<span
				class=" flex text-lg items-center border-r dark:border-zinc-700 dark:bg-zinc-700 px-2 xs:px-4 xs:mr-2 py-2 text-zinc-900 dark:text-white"
			>
				<span class="max-sm:hidden block"> {$t('global.voting.like')} </span>
				<span class="ml-1">{rating}</span></span
			>
		{/if}
		<LikeButton
			{size}
			bind:isLiked
			bind:isDownVoted
			bind:rating
			bind:open
			{votes}
			{votable_type}
			{votable_id}
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
			{votable_type}
			{votable_id}
		/>
	{/if}
</div>

{#if open}
	<AuthModal
		bind:open
		type={votable_type === 'comment'
			? $t('global.not_logged_in.comment')
			: $t('global.not_logged_in.like')}
	/>
{/if}
