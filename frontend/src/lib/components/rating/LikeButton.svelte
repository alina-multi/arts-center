<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbUp } from '@steeze-ui/heroicons';
	import { fetchData } from '$lib/helpers/fetchData';
	import { user } from '$lib/stores/auth';

	export let size = 'w-6 h-6',
		votable_type: string,
		isLiked: boolean,
		isDownVoted: boolean,
		votes: [],
		rating: number,
		open: boolean,
		votable_id: string;

	let url = '/api/vote';

	async function like() {
		if (!$user) {
			open = true;
			return;
		}
		if (!isDownVoted) {
			isLiked = true;
			rating += 1;
			votes?.unshift($user);
			fetchData('POST', url, { vote: 1, votable_type, votable_id });

			return;
		}
		isDownVoted = false;
		isLiked = true;
		rating += 2;
		fetchData('DELETE', url, { vote: -1, votable_type, votable_id });
	}

	async function cancelVote() {
		if (!$user) {
			open = true;
			return;
		}
		isLiked = false;
		rating -= 1;
		votes?.some((vote, index) => {
			if (vote.id.toString() === $user.id.toString()) {
				votes?.splice(index, 1);
			}
		});
		fetchData('DELETE', url, { vote: -1, votable_type, votable_id });
	}
</script>

{#if isLiked}
	<button on:click={cancelVote}
		><Icon
			src={HandThumbUp}
			theme="solid"
			class=" {size}   {votable_type === 'comment'
				? 'fill-blue-700 '
				: 'fill-blue-400 dark:fill-blue-500'}"
		/></button
	>
{:else}
	<button on:click={like}
		><Icon
			src={HandThumbUp}
			theme="outline"
			class=" {size} stroke-zinc-700 stroke-1 hover:scale-110 dark:stroke-zinc-100   "
		/></button
	>
{/if}
