<script lang="ts">
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PencilSquare, Trash } from '@steeze-ui/heroicons';
	import toast from 'svelte-french-toast';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { t } from '$lib/translations';
	import ActionModal from '$lib/components/my/ActionModal.svelte';
	import {fetchData} from '$lib/helpers/fetchData';
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
		const res = await fetchData('DELETE', `${url}/${folderID}`,  {});

		if (res.ok) {
			toast.success('Folder deleted');
			modalDelete = false;
			window.location.href = '/my/favorites/';
		}
	}
</script>

<HeaderLayout {title}>
	<div slot="details" class="flex gap-3 items-center leading-3">
		<div class="h-1 w-1 bg-gray-500 rounded-full dark:bg-zinc-300" />
		<span> {data.favorites.works.length} saved  
			{data.favorites.works.length === 1 ? 'work' : 'works'}</span>
	</div>
	<div slot="buttons" class="flex items-center gap-3 dark:text-zinc-300 text-gray-700">
		<button
			on:click={() => ((modalRename = true), (newName = title))}
			class="  hover:text-gray-500 dark:hover:text-zinc-50 cursor-pointer"
		>
			<Icon src={PencilSquare} class="w-6 h-6" />
		</button>

		{#if gallery.length === 0}
			<button
				on:click={() => (modalDelete = true)}
				class=" hover:text-gray-500 dark:hover:text-zinc-50 cursor-pointer"
			>
				<Icon src={Trash} class="w-6 h-6 " />
			</button>
		{/if}
	</div>
</HeaderLayout>

{#if gallery.length > 0}
	<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
		{#each gallery as work (work.id)}
			<li>
				<ImageWork {work} withDesription />
			</li>
		{/each}
	</ul>
{:else}
	<div class="">
		<span>There are no works</span>
	</div>
{/if}

<ActionModal bind:open={modalRename} action={renameFolder} actionName="Save" className="bg-blue-600 hover:bg-blue-500 ">
	<div slot="title" class="relative">
		{#if error}
			<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
		{/if}
		<p class="mb-1">Collection name</p>
		<input
			use:init
			on:focus={() => (error = '')}
			type="text"
			name="folder"
			bind:value={newName}
			placeholder="Rename folder"
			class="block w-full pl-3 pr-10 py-2 dark:bg-zinc-700 dark:border-zinc-800 dark:focus:ring-zinc-800 text-base border-zinc-500 dark:focus:border-ring-800 focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm rounded-md dark:text-zinc-100 dark:placeholder:text-zinc-500"
		/>
	</div>
</ActionModal>

<ActionModal bind:open={modalDelete} action={removeFolder} actionName={$t('global.buttons.delete')}>
	<div slot="title" class="font-semibold">
		Are you sure you want to delete "<span class="underline">{title}</span> colection?
	</div>
</ActionModal>
