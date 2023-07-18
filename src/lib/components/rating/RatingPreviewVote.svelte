<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { User } from '$lib/interfaces/User';
	import type { Comment } from '$lib/interfaces/Comment';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbDown, HandThumbUp } from '@steeze-ui/heroicons';
	import VotedList from '$lib/components/rating/VotedList.svelte';
	import { page } from '$app/stores';

	export let entity: Work | Comment,
		allowDownVote = false,
		votable_type: string,
		showVotedPreview = false,
		size: string = 'w-6 h-6';

	let currentUser = $page.data.currentUser;
	let votes = entity?.votes;
	let rating = entity?.rating;
	let isLiked = entity?.votes?.some((vote) => vote?.id.toString() === currentUser?.id.toString());
	let isDownVoted = false;

	async function vote(method, vote = 1) {
		return await fetch(`/api/vote`, {
			method,
			headers: {
				'content-type': 'application/json'
			},
			body: JSON.stringify({ vote, votable_type, votable_id: entity.id.toString() })
		});
	}
	async function like() {
		if (!currentUser) {
			onClickNotLoggedIn();
			return;
		}
		if (!isDownVoted) {
			isLiked = true;
			rating += 1;
			votes?.unshift(currentUser);
			const response = await vote('POST').then((res) => res.json());
			return;
		}
		isDownVoted = false;
		isLiked = true;
		rating += 2;
		const response = await vote('DELETE', -1).then((res) => res.json());
	}

	async function cancelVote() {
		if (!currentUser) {
			onClickNotLoggedIn();
			return;
		}
		isLiked = false;
		rating -= 1;
		votes?.some((vote, index) => {
			if (vote.id.toString() === currentUser.id.toString()) {
				votes?.splice(index, 1);
			}
		});
		const response = await vote('DELETE').then((res) => res.json());
	}

	async function dislike() {
		if (!currentUser) {
			onClickNotLoggedIn();
			return;
		}

		if (isDownVoted) {
			isDownVoted = false;
			rating += 1;
			const response = await vote('DELETE', -1).then((res) => res.json());
			return;
		}
		if (isLiked) {
			rating -= 2;
		} else {
			rating -= 1;
		}
		isLiked = false;
		isDownVoted = true;
		const response = await vote('POST', -1).then((res) => res.json());
	}

	function onClickNotLoggedIn() {
		console.log('ModalWindow for Login or Signup');
	}
</script>

{#if showVotedPreview}
	<VotedList {votes} {isLiked} {currentUser} />
{/if}

<div class="inline-flex items-center gap-2 dark:text-zinc-100 cursor-pointer">
	<!-- svelte-ignore a11y-click-events-have-key-events -->
	<div
		class="flex items-center gap-2 {votable_type === 'work'
			? 'border px-4 py-1 rounded-full shadow-md '
			: 'hover:text-zinc-100'}  dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
	>
		{#if votable_type === 'work'}
			<span class="border-r dark:border-zinc-700 pr-3">Like {rating}</span>
		{/if}
		{#if isLiked}
			<button on:click={cancelVote}
				><Icon
					src={HandThumbUp}
					theme="solid"
					class=" {size}   {votable_type === 'comment'
						? 'fill-blue-700 '
						: 'fill-gray-700 dark:fill-blue-600 '}"
				/></button
			>
		{:else}
			<button on:click={like}
				><Icon
					src={HandThumbUp}
					theme="outline"
					class=" {size} stroke-zinc-700 hover:scale-110 dark:stroke-zinc-100 hover:stroke-blue-700  "
				/></button
			>
		{/if}
	</div>

	{#if votable_type === 'comment' && rating > 0}
		<span class={rating > 0 ? 'border-r dark:border-zinc-700 pr-3' : ''}>{rating}</span>
	{/if}

	{#if allowDownVote}
		<div class="flex items-center gap-2">
			<button on:click={dislike}
				><Icon
					src={HandThumbDown}
					theme={isDownVoted ? 'solid' : 'outline'}
					class=" {size} text-gray-400 {isDownVoted ? 'fill-red-800' : ''}"
				/></button
			>
		</div>
	{/if}
</div>
