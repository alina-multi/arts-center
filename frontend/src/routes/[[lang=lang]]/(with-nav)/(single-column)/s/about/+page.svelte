<script lang="ts">
	import { getContext } from 'svelte';
	import type { PageData } from './$types';
	import ContactUsBlock from '$lib/components/nav/ContactUsBlock.svelte';

	const t = getContext('t');

	export let data: PageData;
</script>

<h1 class="text-3xl text-center mt-5">{$t('static.about.h1')}</h1>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
	<div class="space-y-3">
		<h2 class="text-2xl my-5">{$t('static.about.mission.h1')}</h2>
		{#each ['1', '2', '3'] as number}
			<p>{$t(`static.about.mission.p${number}`)}</p>
		{/each}
		<h2 class="text-2xl my-5">{$t(`static.about.stats.h1`)}</h2>
		<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
			{#each ['artists', 'artworks', 'comments'] as stat}
				<div class="overflow-hidden rounded-sm bg-zinc-50 dark:bg-zinc-800 px-4 py-5 shadow sm:p-6">
					<dt class="truncate text-sm font-medium">{$t(`static.about.stats.${stat}`)}</dt>
					<dd class="mt-1 text-3xl font-semibold tracking-tight">{data[stat]}</dd>
				</div>
			{/each}
		</dl>
		<ContactUsBlock />
	</div>
	<div class="space-y-3">
		<h2 class="text-2xl my-5">{$t('static.about.history.h1')}</h2>
		<div class="flex">
			<div class="space-y-3">
				{#each ['1', '2'] as number}
					<p>{$t(`static.about.history.p${number}`)}</p>
				{/each}
			</div>
			<div>
				<div
					class="bg-zinc-50 dark:bg-zinc-800 rounded-sm py-3 w-36 text-center space-y-3 flex-shrink-0"
				>
					<img
						src="/Stepan_Orda.jpg"
						class="mx-auto h-24 w-24 rounded-full"
						alt={$t('static.about.team.stepan.alt')}
					/>
					<h3 class="text-base font-semibold tracking-tight text-gray-900 dark:text-gray-300">
						{$t('static.about.team.stepan.name')}
					</h3>
					<p class="text-sm text-gray-600 dark:text-gray-200">
						{$t('static.about.team.stepan.title')}
					</p>
				</div>
			</div>
		</div>
		{#each ['3', '4', '5', '6', '7', '8'] as number}
			<p>{$t(`static.about.history.p${number}`)}</p>
		{/each}
	</div>
</div>
