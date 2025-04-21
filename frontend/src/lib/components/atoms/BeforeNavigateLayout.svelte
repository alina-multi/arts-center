<script lang="ts">
	import globalLoading from '$lib/stores/loading';
	import { beforeNavigate, goto, preloadData, pushState } from '$app/navigation';
	import { page } from '$app/stores';
	import type { LoadOutput } from '@sveltejs/kit';

	export let route: string;
	export let stateName: string;
	export let keysToInclude: string[];

	
	function safeSerializable(obj: Record<string, unknown>): Record<string, unknown> | null {
		try {
			return JSON.parse(
				JSON.stringify(obj, (key, value) => {
					if (typeof value === 'bigint') return value.toString();
					if (value instanceof Date) return value.toISOString();
					return value;
				})
			);
		} catch (error) {
			console.error(error);
			return null;
		}
	}

	beforeNavigate(async (navigation: import('@sveltejs/kit').BeforeNavigate) => {
		try {
			if (navigation.to?.route.id === route) {
				navigation.cancel();
				globalLoading.set(true);

				const preloaded: LoadOutput = await preloadData(navigation.to?.url.href);
				globalLoading.set(false);

				if (preloaded.type === 'loaded') {
					const rawData: Record<string, unknown> = keysToInclude.reduce(
						(acc: Record<string, unknown>, key: string) => {
							if (Object.prototype.hasOwnProperty.call(preloaded.data, key)) {
								acc[key] = preloaded.data[key];
							}
							return acc;
						},
						{}
					);

					const cleanData = safeSerializable(rawData);

					pushState(navigation.to?.url.href, {
						[stateName]: cleanData
					});
				} else {
					goto(navigation.to?.url.href);
				}
			}
		} catch (error) {
			console.error(error);
			goto(navigation.to?.url.href);
		}
	});
</script>

{#if $page?.state?.[stateName]}
	<slot />
{/if}
