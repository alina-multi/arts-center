<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbUp } from '@steeze-ui/heroicons';
	import {fetchData} from '$lib/helpers/fetchData';
	import { user } from '$lib/stores/auth';

	export let size = 'w-6 h-6',
		votable_type: string,
		isLiked: boolean,
		isDownVoted: boolean,
		votes: [],
		rating: number,
		open: boolean,
		votable_id: string;
		let currentUser = $user;
		let url = '/api/vote';

	async function like() {
		if (!currentUser) {
			open = true;
			return;
		}
		if (!isDownVoted) {
			isLiked = true;
			rating += 1;
			votes?.unshift(currentUser);
		    fetchData('POST', url, { vote: 1, votable_type, votable_id });
			
			return;
		}
		isDownVoted = false;
		isLiked = true;
		rating += 2;
         fetchData('DELETE', url, { vote: -1, votable_type, votable_id });
	
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
