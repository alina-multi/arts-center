<script lang="ts">
	import TreadList from '$lib/components/thread/TreadList.svelte';
	import { user } from '$lib/stores/auth';
	import { page } from '$app/stores';
	import { getContext } from 'svelte';

	export let data;
	const t = getContext('t');
</script>

{#if $user}
	<main>
		<div class=" w-full container mx-auto h-[calc(100vh-150px)]    md:h-[calc(100vh-108px)]   flex flex-col">
			<div class="flex-1 flex overflow-hidden">
				<div
					class="md:w-1/3 md:border-x dark:border-x-zinc-800 overflow-y-auto {$page.params.threadID
						? 'hidden md:flex md:flex-col'
						: 'flex flex-col w-full'}"
				>
					<div>
						<h2 class="text-lg font-semibold py-4 px-4 md:pl-6">{$t(`my.messages.messages`)}</h2>
					</div>

					<div class=" flex-1 overflow-y-auto">
						<TreadList threads={data.threads} />
					</div>
				</div>

				<slot />
			</div>
		</div>
	</main>
{/if}
