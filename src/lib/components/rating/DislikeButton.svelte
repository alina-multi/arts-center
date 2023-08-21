<script lang="ts">
import { Icon } from '@steeze-ui/svelte-icon';
import { HandThumbDown } from '@steeze-ui/heroicons';
import { page } from '$app/stores'; 


export let size:string,
    isLiked: boolean,
    isDownVoted: boolean,
    rating: number,
    open: boolean,
    vote: (method: string, vote: number) => void;

    let currentUser = $page.data.currentUser;


async function dislike() {
		if (!currentUser) {
			open = true;
			return;
		}

		if (isDownVoted) {
			isDownVoted = false;
			rating += 1;
			await vote('DELETE', -1).then((res) => res.json());
			return;
		}
		if (isLiked) {
			rating -= 2;
		} else {
			rating -= 1;
		}
		isLiked = false;
		isDownVoted = true;
		await vote('POST', -1).then((res) => res.json());
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