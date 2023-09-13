<script lang="ts">
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PencilSquare, Trash } from '@steeze-ui/heroicons';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import Button from '$lib/components/atoms/buttons/Button.svelte';
	import toast from 'svelte-french-toast';

	export let data;

	$: gallery = data.favorites.works;
	let modalRename = false;
	let modalDelete = false;
	let error = '';
	let newName = '';
	$: title = data.favorites.title;
  $: folderID = data.favorites.id;

	function init(el: HTMLInputElement) {
		el.focus();
		error = '';
	}

	async function fetchData(method: string, body: object, folderID: number) {
		const response = fetch(`/api/favorite-folder/${folderID}`, {
			method,
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(body)
		});
		return response;
	}

	async function renameFolder() {
		if (newName.trim() === '') {
			error = 'Please enter a folder name';
			return;
		}
		const res = await fetchData('PUT', { title: newName }, data.favorites.id);
		if (res.ok) {
			toast.success('Folder renamed');
			modalRename = false;
			title = newName;
		}
	}

  async function removeFolder() {
      
      const res =  await fetchData("DELETE", {}, folderID);
     
        if (res.ok ){
           toast.success('Folder deleted');
            modalDelete = false;
            // window.location.href = '/my/favorites/0';
 
        }
 
   }

  
</script>

<div class="flex justify-between px-3 py-1 border rounded-sm bg-gray-100">
	<div class="flex gap-3 items-center leading-3">
		<h1 class="text-lg font-semibold">{title}</h1>
		<div class="h-1 w-1 bg-gray-500 rounded-full" />
		<span class="text-sm"> {data.favorites.works.length} works</span>
	</div>
	<div class="flex items-center gap-3">
		<button
			on:click={() => ((modalRename = true), (newName = title))}
			class="hover:bg-gray-100 cursor-pointer dark:hover:bg-zinc-800 rounded-md py-1 focus:outline-none"
		>
			<Icon
				src={PencilSquare}
				class="w-6 h-6 text-gray-700 hover:text-gray-500 dark:text-zinc-400"
			/>
		</button>

		{#if gallery.length === 0}
			<button
        on:click={() => (modalDelete = true)}
				class="hover:bg-gray-100 cursor-pointer dark:hover:bg-zinc-800 rounded-md py-1 focus:outline-none"
			>
				<Icon src={Trash} class="w-6 h-6 text-gray-700 hover:text-gray-500 dark:text-zinc-400" />
			</button>
		{/if}
	</div>
</div>

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

<ModalWindow bind:open={modalRename}>
	<div class="flex flex-col gap-3 text-center">
		<div class="relative">
			{#if error}
				<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
			{/if}
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

		<div class="flex gap-3 items-center justify-end">
			<Button
				type="button"
				on:click={() => (modalRename = false)}
				class=" px-3 py-1     dark:bg-zinc-300 dark:hover:bg-zinc-200 bg-zinc-300 text-white border border-transparent rounded-md hover:bg-zinc-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-zinc-500"
			>
				Cancel
			</Button>
			<button
				on:click={() => renameFolder()}
				class="flex items-center gap-1 border bg-blue-700 rounded-md px-3 py-1 text-white"
			>
				<span> Save </span>
			</button>
		</div>
	</div>
</ModalWindow>

<ModalWindow bind:open={modalDelete}>

    <div class="flex flex-col gap-6 text-center">
		
			<p class="font-semibold text-lg text-center">Are you sure you want to delete <br> "<span class="underline">{title}</span>"  folder?</p>	
      
		

			<div class="flex gap-3 items-center justify-center">
				<button
					on:click={() => removeFolder()}
					class="flex items-center gap-1 border bg-red-700 rounded-md px-3 py-1 text-white"
				>
					<span> Delete </span>
				</button>
				<button
					on:click={() => (modalDelete = false)}
					class=" border rounded-md px-3 py-1 bg-gray-500 text-white"
				>
					Cancel
				</button>
			</div>

	</div>
</ModalWindow>



