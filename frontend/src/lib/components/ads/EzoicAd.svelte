<script lang="ts">
	import { onMount, onDestroy } from 'svelte';
	import { browser } from '$app/environment';

	export let placeholderId: number;
	export let className: string = '';

	let mounted = false;

	onMount(() => {
		mounted = true;
		if (browser && window.ezstandalone?.cmd) {
			window.ezstandalone.cmd.push(function () {
				window.ezstandalone.showAds(placeholderId);
			});
		}
	});

	onDestroy(() => {
		if (browser && mounted && window.ezstandalone?.destroyPlaceholders) {
			window.ezstandalone.cmd.push(function () {
				window.ezstandalone.destroyPlaceholders(placeholderId);
			});
		}
	});
</script>

<div id="ezoic-pub-ad-placeholder-{placeholderId}" class={className}></div>
