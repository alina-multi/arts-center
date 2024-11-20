<script lang="ts">
	import TreadList from '$lib/components/thread/TreadList.svelte';
	import { user } from '$lib/stores/auth';
	import { page } from '$app/stores';
	import { getContext } from 'svelte';
	const t = getContext('t');
	export let data;
</script>

{#if $user}
	<main>
		<div class=" w-full container mx-auto h-[calc(100vh-108px)] flex flex-col">
			<div class="flex-1 flex overflow-hidden">
				<div
					class="md:w-1/3 md:border-x overflow-y-auto {$page.params.threadID
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
				<div
					class=" md:border-r {$page.params.threadID
						? 'flex-1 flex flex-col  '
						: 'hidden md:flex-1 md:flex md:flex-col'}  "
				>
					<slot />
				</div>
			</div>
		</div>
	</main>
{/if}
