<script lang="ts">
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PencilSquare, Trash } from '@steeze-ui/heroicons';
	import toast from 'svelte-french-toast';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import ActionModal from '$lib/components/my/ActionModal.svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let data;

	$: gallery = data.favorites.works;
	let modalRename = false;
	let modalDelete = false;
	let error = '';
	let newName = '';
	$: title = data.favorites.title;
	$: folderID = data.favorites.id;

	let url = '/api/favorite-folder';

	function init(el: HTMLInputElement) {
		el.focus();
		error = '';
	}

	async function renameFolder() {
		if (newName.trim() === '') {
			error = 'Please enter a folder name';
			return;
		}
		const res = await fetchData('PUT', `${url}/${data.favorites.id}`, { title: newName });
		if (res.ok) {
			toast.success('Folder renamed');
			modalRename = false;
			title = newName;
		}
	}

	async function removeFolder() {
		const res = await fetchData('DELETE', `${url}/${folderID}`, {});

		if (res.ok) {
			toast.success('Folder deleted');
			modalDelete = false;
			window.location.href = '/my/favorites/';
		}
	}
</script>

<div>
	<HeaderLayout {title}>
		<div slot="details" class="flex gap-3 items-center leading-3">
			<span>
				{data.favorites.works.length}
				{$t('my.favorite.saved')}
				{data.favorites.works.length === 1 ? $t('my.work') : $t('my.works')}</span
			>
		</div>
		<div slot="buttons" class="flex items-center gap-3">
			<button
				on:click={() => ((modalRename = true), (newName = title))}
				class="  hover:scale-105 cursor-pointer"
			>
				<Icon src={PencilSquare} class="w-7 h-7" />
			</button>

			{#if gallery.length === 0}
				<button
					on:click={() => (modalDelete = true)}
					class=" hover:text-red-500 hover:scale-105 cursor-pointer"
				>
					<Icon src={Trash} class="w-7 h-7 " />
				</button>
			{/if}
		</div>
	</HeaderLayout>

	{#if gallery.length > 0}
		<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-3 gap-6">
			{#each gallery as work (work.id)}
				<li>
					<ImageWork {work} withDesription />
				</li>
			{/each}
		</ul>
	{:else}
		<p class=" px-6 py-3 dark:border-zinc-800 dark:bg-zinc-900">
			{$t('my.favorite.no_works')}
		</p>
	{/if}
</div>

<ActionModal
	bind:open={modalRename}
	action={renameFolder}
	actionName="Save"
	class="bg-blue-600 hover:bg-blue-500 "
>
	<div slot="title" class="relative">
		{#if error}
			<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
		{/if}
		<p class="mb-1">{$t('my.favorite.collection_name')}</p>
		<input
			use:init
			on:focus={() => (error = '')}
			type="text"
			name="folder"
			bind:value={newName}
			placeholder="Rename folder"
			class="block w-full pl-3 pr-10 py-2 dark:bg-zinc-700 dark:border-zinc-800 dark:focus:ring-zinc-800 text-base border-zinc-500 dark:focus:border-ring-800 focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm rounded-sm dark:text-zinc-100 dark:placeholder:text-zinc-500"
		/>
	</div>
</ActionModal>

<ActionModal bind:open={modalDelete} action={removeFolder} actionName={$t('global.buttons.delete')}>
	<div slot="title" class="font-semibold">
		{$t('my.confirmation.delete')} "<span class="underline">{title}</span>" {$t(
			'my.favorite.collection'
		)}?
	</div>
</ActionModal>
