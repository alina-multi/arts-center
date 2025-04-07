<script>
	import { onMount } from 'svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowUpOnSquare } from '@steeze-ui/heroicons';
	let url = '';

	onMount(() => {
		url = window.location.href;
	});

	function share() {
		navigator.share({
			title: document.title,
			url: url
		});
	}
</script>

<button on:click={share}>
	<Icon src={ArrowUpOnSquare} class="w-7 h-7 stroke-1 " />
</button>
