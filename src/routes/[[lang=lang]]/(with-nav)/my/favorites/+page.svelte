<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Folder } from '@steeze-ui/heroicons';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let data;
	let folders = data.folders;
</script>

<div>
	<HeaderLayout title={$t('my.favorite.my_collections')}>
		<span slot="details"> {folders.length} {$t('my.favorite.folders')}</span>
	</HeaderLayout>

	<div class="divide-y dark:divide-zinc-800">
		{#if folders.length > 0}
			{#each folders as folder (folder.id)}
				<a
					href="favorites/{folder.id}"
					class="flex items-center gap-3 px-6 py-3 hover:bg-zinc-100 dark:hover:bg-zinc-800"
				>
					<Icon src={Folder} theme="solid" class="h-8 w-8 text-sky-500" />
					<span class=" text-lg">{folder.title}</span>
				</a>
			{/each}
		{:else}
			<div class="px-6 py-3">
				{$t('my.favorite.no_collections')}
			</div>
		{/if}
	</div>
</div>
