<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbUp } from '@steeze-ui/heroicons';
	import { page } from '$app/stores';

	export let size = 'w-6 h-6',
		votable_type: string,
		isLiked: boolean,
		isDownVoted: boolean,
		votes: [],
		rating: number,
		open: boolean,
		vote: (method: string, vote: number ) => void;
		let currentUser = $page.data.currentUser;

	async function like() {
		if (!currentUser) {
			open = true;
			return;
		}
		if (!isDownVoted) {
			isLiked = true;
			rating += 1;
			votes?.unshift(currentUser);
			await vote('POST').then((res) => res.json());
			return;
		}
		isDownVoted = false;
		isLiked = true;
		rating += 2;
		await vote('DELETE', -1).then((res) => res.json());
	}

	async function cancelVote() {
		if (!currentUser) {
			open = true;
			return;
		}
		isLiked = false;
		rating -= 1;
		votes?.some((vote, index) => {
			if (vote.id.toString() === currentUser.id.toString()) {
				votes?.splice(index, 1);
			}
		});
		await vote('DELETE').then((res) => res.json());
	}

</script>

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
			class=" {size} stroke-zinc-700 hover:scale-110 dark:stroke-zinc-100 hover:stroke-grzincay-700  "
		/></button
	>
{/if}
