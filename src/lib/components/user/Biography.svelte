<script lang="ts">
	import { onMount } from 'svelte';
	export let user;
	let showBio = false;
	let lines = 0;

	onMount(() => {
		countLines();
	});

	function countLines() {
		let el = document.getElementById('bio');
		lines = el.offsetHeight / 24;
	}
</script>

{#if user?.bio}
	<div class="relative flex flex-col text-sm lg:text-base">
		<div
			id="bio"
			class="{showBio ? 'dark:text-gray-300' : ' line-clamp-4 leading-6 overflow-hidden '}  {lines >
				3 && !showBio
				? 'text-transparent bg-clip-text bg-gradient-to-b from-gray-900  to-transparent dark:from-white'
				: ''} whitespace-pre-line"
		>
			{user.bio}
		</div>
		{#if lines > 3}
			<div class=" self-end {showBio ? '' : 'absolute bottom-0'}">
				<button
					on:click={() => (showBio = !showBio)}
					class=" pl-2 rounded-full text-gray-800 leading-6 bg-white dark:bg-black dark:text-zinc-300 dark:hover:text-blue-600 hover:text-blue-700"
				>
					{#if showBio}
						show less
					{:else}
						show more &darr;
					{/if}
				</button>
			</div>
		{/if}
	</div>
{/if}
