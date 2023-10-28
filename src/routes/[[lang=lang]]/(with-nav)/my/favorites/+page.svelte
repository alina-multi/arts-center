<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Folder } from '@steeze-ui/heroicons';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { t } from '$lib/translations';

	export let data;
	let folders = data.folders;
</script>

<div>
	<HeaderLayout title={$t('my.favorite.my_collections')}>
		<span slot="details"> {folders.length} {$t('my.favorite.folders')}</span>
	</HeaderLayout>

	<div
		class="flex flex-col border-x border-b py-3 dark:border-t rounded-b-sm dark:border-zinc-800 dark:border-t-transparent  dark:bg-zinc-900"
	>
		{#if folders.length > 0}
			{#each folders as folder}
				<a
					href="favorites/{folder.id}"
					class="flex items-center gap-3 px-6 py-3 hover:bg-zinc-100 dark:hover:bg-zinc-800"
				>
					<Icon src={Folder} theme="solid" class="h-10 w-10 text-zinc-600" />
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
