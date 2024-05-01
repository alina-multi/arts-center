<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbDown } from '@steeze-ui/heroicons';
	import { fetchData } from '$lib/helpers/fetchData';
	import { user, showAuthModal } from '$lib/stores/auth';

	export let size: string,
		isLiked: boolean,
		isDownVoted: boolean,
		rating: number,
		votable_type: string,
		votable_id: string;
	let url = '/api/vote';

	async function dislike() {
		if (!$user) {
			showAuthModal.set(true);
			return;
		}

		if (isDownVoted) {
			isDownVoted = false;
			rating += 1;
			fetchData('DELETE', url, { vote: -1, votable_type, votable_id });
			return;
		}
		if (isLiked) {
			rating -= 2;
		} else {
			rating -= 1;
		}
		isLiked = false;
		isDownVoted = true;
		fetchData('POST', url, { vote: -1, votable_type, votable_id });
	}
</script>

<div class="flex items-center gap-2">
	<button on:click={dislike}
		><Icon
			src={HandThumbDown}
			theme={isDownVoted ? 'solid' : 'outline'}
			class=" {size} text-gray-400 {isDownVoted ? 'fill-red-800' : ''}"
		/></button
	>
</div>
