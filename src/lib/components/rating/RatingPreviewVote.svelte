<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import VotedList from '$lib/components/rating/VotedList.svelte';
	import { page } from '$app/stores';
	import LikeButton from './LikeButton.svelte';
	import DislikeButton from './DislikeButton.svelte';
	import AuthModal from '../atoms/AuthModal.svelte';
	import { t } from '$lib/translations';

	export let entity: Work | Comment,
		allowDownVote = false,
		votable_type: string,
		showVotedPreview = false,
		size = 'w-6 h-6';
	let currentUser = $page.data.currentUser;
	let votes = entity?.votes;
	let rating = entity?.rating;
	let isLiked = entity?.votes?.some((vote) => vote?.id?.toString() === currentUser?.id?.toString());
	let isDownVoted = false;
	let open = false;
	let votable_id = entity?.id.toString();

</script>

	{#if showVotedPreview}
	<VotedList {votes} {isLiked} {currentUser} />
{/if}

<div class="inline-flex items-center gap-2 dark:text-zinc-100 cursor-pointer">
	<div
		class="flex items-center gap-2 {votable_type === 'work'
			? 'border  px-4 py-1 rounded-sm rounded-r-none '
			: 'hover:text-zinc-100'}  dark:bg-zinc-800 bg-white dark:border-zinc-700 dark:text-white"
	>
		{#if votable_type === 'work'}
			<span class=" flex items-center border-r dark:border-zinc-700 pr-3"
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
<AuthModal bind:open type={votable_type === "comment" ? $t('global.not_logged_in.comment')  : $t('global.not_logged_in.like')} />
{/if}


