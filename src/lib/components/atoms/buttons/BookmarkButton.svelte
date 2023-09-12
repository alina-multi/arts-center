<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bookmark, BookmarkSlash, Plus } from '@steeze-ui/heroicons';
	import { page } from '$app/stores';
	import ModalWindow from '../ModalWindow.svelte';
	import toast from 'svelte-french-toast';
	import { fetchData } from '$lib/helpers/fetch';

	export let work;
	let workID = Number(work.id);
	let currentUser = $page.data.currentUser;
	let isBookmarked = currentUser?.favorites.works.some((favorite: number) => favorite === workID);

	let open = false;
	let showInput = false;
	let error = '';
	let folderID = 0;
	$: folderName = showInput ? '' : 'Default';
	const folders = currentUser?.favorites.folders;

	async function onChange(e: Event) {
		folderID = Number(e.target.value);
		showInput = false;
	}

	function init(el: HTMLInputElement) {
		el.focus();
	}

	async function saveInExistingFolder() {
		const response = await fetchData('POST', { work_id: workID, folder_id: folderID });
		const data = await response.json();

		if (!response.ok) {
			error = data.message;
			return;
		}

		$page.data.currentUser.favorites.works.push(workID);
		toast.success('Work saved');
		open = false;
		isBookmarked = true;
	}

	async function createFolder() {
		if (folderName === '') {
			error = 'Folder name cannot be empty';
			return;
		}

		const response = await fetchData('POST', {
			work_id: workID,
			folder_title: folderName
		});

		const data = await response.json();
		if (!response.ok) {
			error = data.message;
			return;
		}

		toast.success(`Saved to ${folderName}`);
		open = false;
		isBookmarked = true;
	}

	async function remove() {
		await fetchData('DELETE', { work_id: workID });
		isBookmarked = false;
	}
</script>

<button
	type="button"
	on:click={isBookmarked ? remove : () => (open = true)}
	class=" text-sm dark:text-zinc-300 text-zinc-600 dark:border-zinc-700"
>
	{#if isBookmarked}
		<span class="sr-only"> Unbookmark </span>

		<Icon src={BookmarkSlash} class="h-7 w-7 text-gray-400 dark:text-zinc-600" aria-hidden="true" />
	{:else}
		<span class="sr-only">Bookmark</span>
		<Icon
			src={Bookmark}
			class="h-7 w-7   xl:hover:stroke-zinc-500 fill-white dark:fill-zinc-300 "
			aria-hidden="true"
		/>
	{/if}
</button>

{#if currentUser}
	<ModalWindow bind:open>
		<div class="flex flex-col gap-3">
			<slot name="header">
				<div class="flex items-center justify-between">
					<h2 class="text-base font-semibold text-gray-900">Save work to…</h2>

					{#if folders.length > 0}
						<button
							on:click={() => (showInput = true)}
							type="button"
							class="flex px-3 py-1 bg-gray-100 border rounded-sm items-center text-sm gap-1 cursor-pointer dark:text-zinc-300 focus-outline-none"
						>
							<span>Create folder</span>
							<Icon src={Plus} class="h-4 w-4 " aria-hidden="true" />
						</button>
					{/if}
				</div>
			</slot>

			<form
				on:submit={showInput || folders.length === 0 ? createFolder : saveInExistingFolder}
				class="flex flex-col gap-3"
			>
				{#if folders.length > 0}
					<div class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200">
						{#each folders as folder}
							<div class="relative flex items-start py-4">
								<div class="min-w-0 flex-1 text-sm leading-6">
									<label for={folder.id} class="select-none font-medium text-gray-900"
										>{folder.title}</label
									>
								</div>
								<div class="ml-3 flex h-6 items-center">
									<input
										id={folder.id}
										name="folder"
										type="radio"
										value={folder.id}
										checked={folderID === folder.id}
										on:change={onChange}
										class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
									/>
								</div>
							</div>
						{/each}
					</div>
				{/if}

				{#if folders.length === 0}
					<div class="flex flex-col gap-3">
						<label for="folder">Create folder</label>
						<input
							use:init
							type="text"
							name="folder"
							id="folder"
							bind:value={folderName}
							placeholder="Create folder"
							class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm rounded-md"
						/>
					</div>
				{/if}

				{#if showInput}
					<div class="flex flex-col gap-3">
						{#if error}
							<p class="text-red-500">{error}</p>
						{/if}
						<input
							on:focus={() => (error = false)}
							type="text"
							name="folder"
							id="folder"
							bind:value={folderName}
							placeholder="Create folder"
							class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm rounded-md"
						/>
					</div>
				{/if}

				<button
					type="submit"
					class="inline-flex justify-center px-3 py-1 text-sm font-medium text-white bg-zinc-600 border border-transparent rounded-md hover:bg-zinc-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-zinc-500"
				>
					Save
				</button>
			</form>
		</div>
	</ModalWindow>
{/if}

{#if !currentUser}
	<ModalWindow bind:open>
		<div class="flex flex-col gap-3">
			<slot name="header" class="flex justify-between font-semibold"
				>Login to bookmark this page</slot
			>

			<div class="flex flex-col gap-3">
				<button
					type="button"
					class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-zinc-600 border border-transparent rounded-md hover:bg-zinc-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-zinc-500"
				>
					Login
				</button>
				<button
					type="button"
					class="inline-flex justify-center px-4 py-2 text-sm font-medium text-zinc-700 bg-zinc-100 border border-transparent rounded-md hover:bg-zinc-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-zinc-500"
				>
					Sign up
				</button>
			</div>
		</div>
	</ModalWindow>
{/if}
