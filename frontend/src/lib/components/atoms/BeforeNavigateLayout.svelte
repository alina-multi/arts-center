<script lang="ts">
	import globalLoading from '$lib/stores/loading';
	import { beforeNavigate, goto, preloadData, pushState } from '$app/navigation';
	import { page } from '$app/stores';
	export let route: string, stateName;
	export let keysToInclude: Array<string>;

	beforeNavigate(async (navigation: import('@sveltejs/kit').BeforeNavigate) => {
		if (navigation.to?.route.id === route) {
			navigation.cancel();
			globalLoading.set(true);
			const preloaded = await preloadData(navigation.to?.url.href);
			globalLoading.set(false);
			if (preloaded.type === 'loaded') {
				const modalData = keysToInclude.reduce((acc, key) => {
					if (Object.prototype.hasOwnProperty.call(preloaded.data, key)) {
						acc[key] = preloaded.data[key];
					}

					return acc;
				}, {});
				pushState(navigation.to?.url.href, {
					[stateName]: modalData
				});

				// Fallback if for any reason preload fails
			} else {
				goto(preloaded.data.work);
			}
		}
	});
</script>

{#if $page?.state?.[stateName]}
	<slot />
{/if}
