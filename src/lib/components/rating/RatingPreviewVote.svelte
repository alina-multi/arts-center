<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { User } from '$lib/interfaces/User';
	import type { Comment } from '$lib/interfaces/Comment';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbDown, HandThumbUp } from '@steeze-ui/heroicons';
	import VotedList from '$lib/components/rating/VotedList.svelte';

	export let entity: Work | Comment,
		allowDownVote = false,
		votable_type: string,
		showVotedPreview: boolean,
		currentUser: User;

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
		isLiked = true;
		rating += 1;
		votes?.unshift(currentUser);
		const response = await vote('POST').then((res) => res.json());
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
			: 'hover:text-zinc-100'} dark:hover:text-sky-700"
	>
		<span class="border-r pr-3">Like {rating}</span>
		{#if isLiked}
			<button on:click={cancelVote}
				><Icon src={HandThumbUp} theme="solid" class=" w-6 h-6  fill-gray-700  " /></button
			>
		{:else}
			<button on:click={like}
				><Icon
					src={HandThumbUp}
					theme="outline"
					class=" w-6 h-6  stroke-gray-700 hover:scale-110 "
				/></button
			>
		{/if}
	</div>

	{#if allowDownVote}
		<div class="flex items-center gap-2">
			<button on:click={dislike}
				><Icon
					src={HandThumbDown}
					theme="solid"
					class=" w-6 h-6  hover:scale-125 {isDownVoted ? 'fill-red-800' : 'fill-gray-700 '}"
				/></button
			>
		</div>
	{/if}
</div>
