<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import ModalWindow from '$lib/components/ModalWindow.svelte';
	export let work: Work;
	let showLikedByModal = true;
	// For now let's just show the first 3 votes
	// Later, this can be friends first like on FB
	const votesPreview = work?.votes?.slice(0, 3);
</script>


<ModalWindow bind:open={showLikedByModal}>

	<div slot="header" class="flex justify-between">
	
			<div class="text-lg font-semibold">Liked by</div>
			<!-- <button on:click={()=> (showLikedByModal = false)} class="hover:underline cursor-pointer ">
				x
			</button> -->
		
	</div>
	<div slot="main">
		<div class="grid grid-cols-2 gap-3 text-gray-900 text-sm  ">
			{#each work.votes as user}
				<div class="flex items-center gap-3">
					<Avatar {user} withName />
		
				</div>
			{/each}
			{#each work.votes as user}
				<div class="flex items-center gap-3">
					<Avatar {user} withName />
				
				</div>
			{/each}
		</div>
	</div>
	
</ModalWindow>

<div class="dark:text-gray-400 ">
	<div class="flex gap-3 items-center">
		<div>Comments: {work.comments}</div>
		<div class="flex items-center gap-2">
			<button on:click={()=> (showLikedByModal = true)} class="hover:underline cursor-pointer ">
				<span class="">Liked by</span>
				{work.rating}
			</button>
			{#if work.votes.length > 0}
				<div class="flex -space-x-1 cursor-pointer">
					{#each votesPreview as user}
						<Avatar {user}  />
					{/each}
				</div>
			{/if}
			
		</div>
	</div>
</div>

