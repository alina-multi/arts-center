<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import { PencilSquare, EllipsisVertical, XMark, Folder, FolderOpen, Pencil } from '@steeze-ui/heroicons';
    import Button from '$lib/components/atoms/buttons/Button.svelte';

	import toast from 'svelte-french-toast';


	export let data;
	let folders = data.folders;
	let open = false;
	$: folderForDeleting = null;
    $: renamedFolder = null;
    $: newName = '';
  
    let error = '';

    export async function fetchData(method: string, body: object, folderID: number) {
    const response = fetch(`/api/favorite-folder/${folderID}`, {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    return response;
}

function init(el: HTMLInputElement) {
		el.focus();
		error = '';
	}

	$: currentFolder = Number(data.params?.folder_id);
    $:console.log(newName);
    $:console.log(renamedFolder);

	async function removeFolder(folderID: number) {
      
	   const res =  await fetchData("DELETE", {}, folderID);
       console.log(res);
       if (res.ok ){
          toast.success('Folder deleted');
            folders = folders.filter(folder => folder.id !== folderID);
            folderForDeleting = null;

       }

	}

    async function renameFolder(folderID: number) {
        if (newName.trim() === '') {
            error = 'Please enter a folder name';
            return;
        }
        const res = await fetchData("PUT", {title: newName}, folderID);
        if (res.ok) {
            toast.success('Folder renamed');
            folders = folders.map(folder => {
                if (folder.id === folderID) {
                    folder.title = newName;
                }
                return folder;
            });
            renamedFolder = null;
        }
    }

</script>

{#if folders.length > 0}
	<div class="space-y-3">
		<div class="flex justify-between px-3 py-1 rounded-sm border bg-gray-100">
			<div class="flex gap-3 items-center leading-3">
				<h1 class="text-lg font-semibold">Collections</h1>
				<div class="h-1 w-1 bg-gray-500 rounded-full" />
				<span class="text-sm"> {folders.length} folders</span>
			</div>
			<button
				on:click={() => (open = true)}
				class="hover:text-blue-900 text-gray-700 cursor-pointer dark:hover:bg-zinc-800 rounded-md py-1 focus:outline-none"
			>
				<Icon src={EllipsisVertical} class="w-6 h-6 " />
			</button>
		</div>

		<div class="flex flex-wrap gap-3 items-center">
			{#each folders as folder}
				<a
					href={folder.id}
					class="pr-9 rounded-md flex items-center gap-3 border {currentFolder === folder.id
						? 'border-blue-600'
						: 'border-gray-400'} cursor-pointer overflow-hidden"
				>
					<div class="p-3 {currentFolder === folder.id ? 'bg-blue-600' : 'bg-gray-400'}">
						{#if currentFolder === folder.id}
							<Icon src={FolderOpen} theme="solid" class="h-9 w-9  text-white" />
						{:else}
							<Icon src={Folder} theme="solid" class="h-9 w-9 text-gray-50" />
						{/if}
					</div>

					<span>{folder.title}</span>
				</a>
			{/each}
		</div>
	</div>
{:else}
	<div class="">
		<span>There are no folders</span>
	</div>
{/if}

<slot />

<ModalWindow bind:open>
	<slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="text-base font-semibold">Collections</h2>

			<button
				on:click={() => (open = false)}
				type="button"
				class="flex items-center text-sm hover:text-gray-700 text-gray-900 dark:text-white dark:hover:text-zinc-300 cursor-pointer focus-outline-none focus:ring-transparent"
			>
				<Icon src={XMark} class="h-6 w-6 " aria-hidden="true" />
			</button>
		</div>
	</slot>
	<div class="flex flex-col">
		{#each folders as folder}
			<div class="relative flex items-center justify-between py-3  cursor-pointer hover:text-gray-600">
               
				<div class="min-w-0 flex-1 text-sm flex gap-3 items-center select-none ">
					<Icon src={Folder} class="h-6 w-6 " aria-hidden="true" />
					{folder.title}
				</div>

				<button
					on:click={() => (renamedFolder = folder, newName = folder.title)}
					class=" text-sm text-gary-700 hover:text-gray-500 hover:underline"
				> 
                <Icon src={Pencil} class="w-5 h-5 " />
				</button>
			</div>
		{/each}
	</div>

	{#if renamedFolder}
		<div class="flex flex-col gap-3 text-center ">
			
            <div class="relative">
                {#if error}
                    <span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
                {/if}
                <input
                    use:init
                    on:focus={() => (error = '')}
                    type="text"
                    name="folder"
                    id="folder"
                    bind:value={newName}
                    placeholder="Rename folder"
                    class="block w-full pl-3 pr-10 py-2 dark:bg-zinc-700 dark:border-zinc-800 dark:focus:ring-zinc-800 text-base border-zinc-500 dark:focus:border-ring-800 focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm rounded-md dark:text-zinc-100 dark:placeholder:text-zinc-500"
                />
            </div>

			<div class="flex gap-3 items-center justify-end">
				<Button
					type="button"
					on:click={() => (renamedFolder = null)}
					class=" px-3 py-1     dark:bg-zinc-300 dark:hover:bg-zinc-200 bg-zinc-300 text-white border border-transparent rounded-md hover:bg-zinc-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-zinc-500"
				>
					Cancel
				</Button>
				<!-- <button
					on:click={() => (folderForDeleting = null)}
					class=" border rounded-md px-3 py-1 bg-gray-500 text-white"
				>
					Cancel
				</button> -->
                <button
                on:click={() => renameFolder(renamedFolder?.id)}
                class="flex items-center gap-1 border bg-blue-700 rounded-md px-3 py-1 text-white"
            >
                <span> Save </span>
            </button>
			</div>
		</div>
	{/if}
</ModalWindow>




<!-- <ModalWindow bind:open>
	<slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="text-base font-semibold">Collections</h2>

			<button
				on:click={() => (open = false)}
				type="button"
				class="flex items-center text-sm hover:text-gray-700 text-gray-900 dark:text-white dark:hover:text-zinc-300 cursor-pointer focus-outline-none focus:ring-transparent"
			>
				<Icon src={XMark} class="h-6 w-6 " aria-hidden="true" />
			</button>
		</div>
	</slot>
	<div class="flex flex-col">
		{#each folders as folder}
			<div class="relative flex items-center justify-between py-3">
				<div class="min-w-0 flex-1 text-sm flex gap-3 items-center select-none cursor-pointer">
					<Icon src={Folder} class="h-6 w-6 " aria-hidden="true" />
					{folder.title}
				</div>

				<button
					on:click={() => (folderForDeleting = folder)}
					class=" text-sm text-red-700 hover:text-red-500 hover:underline cursor-pointer"
				>
					Delete
				</button>
			</div>
		{/each}
	</div>

	{#if folderForDeleting}
		<div class="flex flex-col gap-3 text-center">
			<div class="font-semibold border-y py-6">
				Delete  "<span class="underline">{folderForDeleting.title}</span>"  collection?
			</div>

			<div class="flex gap-3 items-center justify-center">
				<button
					on:click={() => removeFolder(folderForDeleting?.id)}
					class="flex items-center gap-1 border border-red-700 rounded-md px-3 py-1 text-red-700"
				>
					<span> Delete </span>
					<Icon src={Trash} class="h-4 w-4 " aria-hidden="true" />
				</button>
				<button
					on:click={() => (folderForDeleting = null)}
					class=" border rounded-md px-3 py-1 bg-gray-500 text-white"
				>
					Cancel
				</button>
			</div>
		</div>
	{/if}
</ModalWindow> -->
