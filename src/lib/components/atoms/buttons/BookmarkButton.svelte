<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bookmark, BookmarkSlash, Folder, FolderPlus } from '@steeze-ui/heroicons';
	import { page } from '$app/stores';
	import ModalWindow from '../ModalWindow.svelte';
	import toast from 'svelte-french-toast';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import ButtonsGroup from '$lib/components/forms/ButtonsGroup.svelte';
	import CancelButton from '$lib/components/forms/CancelButton.svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import AuthModal from '../AuthModal.svelte';
	import { t } from '$lib/translations';

	export let work;
	let url = '/api/favorite';
	let workID = Number(work.id);
	let currentUser = $page.data.currentUser;
	let isBookmarked = currentUser?.favorites.works.some((favorite: number) => favorite === workID);

	let open = false;
	let showInput = false;
	let error = '';
	let folderID = 0;
	$: folderName = showInput ? '' : 'All works';
	const folders = currentUser?.favorites.folders;

	function onChange(e: Event & { target: HTMLInputElement }) {
		folderID = Number(e.target.value);
		showInput = false;
		error = '';
	}

	function init(el: HTMLInputElement) {
		el.focus();
		error = '';
	}

	async function saveInExistingFolder() {
		if (folderID === 0) {
			error = 'Please select a folder';
			return;
		}
		const response = await fetchData('POST', url, { work_id: workID, folder_id: folderID });
		const data = await response.json();

		if (!response.ok) {
			error = data.message;
			return;
		}

		toast.success('Work saved');
		open = false;
		isBookmarked = true;
	}

	async function createFolder() {
		if (folderName === '') {
			error = 'Please enter a folder name';
			return;
		}

		const response = await fetchData('POST', url, {
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
		showInput = false;
	}

	async function remove() {
		await fetchData('DELETE', url, { work_id: workID });
		isBookmarked = false;
	}
</script>

<div class="flex border border-l-transparent rounded-sm px-3 -ml-4 py-1">
	<button
		type="button"
		on:click={isBookmarked ? remove : () => (open = true)}
		class=" text-sm dark:text-zinc-300 text-zinc-600 dark:border-zinc-700"
	>
		{#if isBookmarked}
			<span class="sr-only"> Unbookmark </span>

			<Icon
				src={BookmarkSlash}
				class="h-6 w-6 text-gray-400 dark:text-zinc-600"
				aria-hidden="true"
			/>
		{:else}
			<span class="sr-only">Bookmark</span>
			<Icon
				src={Bookmark}
				class="h-6 w-6   xl:hover:stroke-zinc-500 dark:hover:stroke-zinc-100 dark:hover:fill-zinc-100 fill-white dark:fill-zinc-300 "
				aria-hidden="true"
			/>
		{/if}
	</button>

	{#if currentUser}
		<ModalWindow bind:open>
			<slot name="header">
				<div class="flex items-center justify-between mb-3">
					<h2 class="text-base font-semibold">Save work to…</h2>

					{#if folders.length > 0}
						<button
							on:click={() => ((showInput = true), (folderID = 0))}
							type="button"
							class="flex items-center text-sm hover:text-gray-700 text-gray-900 dark:text-white dark:hover:text-zinc-300 cursor-pointer focus-outline-none focus:ring-transparent"
						>
							<Icon src={FolderPlus} class="h-7 w-7 " aria-hidden="true" />
						</button>
					{/if}
				</div>
			</slot>

			<form
				on:submit={showInput || folders.length === 0 ? createFolder : saveInExistingFolder}
				class="flex flex-col gap-6"
			>
				{#if folders.length > 0}
					<div
						class="relative divide-y divide-gray-200 dark:divide-zinc-800 border-b border-t border-gray-200 dark:border- dark:border-zinc-800"
					>
						{#if error && !showInput}
							<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
						{/if}
						{#each folders as folder}
							<div class="relative flex items-center justify-between py-3">
								<label
									for={folder.id}
									class="min-w-0 flex-1 text-sm flex gap-3 items-center select-none cursor-pointer"
								>
									<Icon src={Folder} class="h-6 w-6 " aria-hidden="true" />
									{folder.title}
								</label>

								<input
									id={folder.id}
									name="folder"
									type="radio"
									value={folder.id}
									checked={folderID === folder.id}
									on:change={onChange}
									class="h-4 w-4 border-gray-300 dark:bg-zinc-300 text-blue-600 focus:ring-blue-600 cursor-pointer"
								/>
							</div>
						{/each}
					</div>
				{/if}

				{#if showInput || folders.length === 0}
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
							bind:value={folderName}
							placeholder="Create folder"
							class="block w-full pl-3 pr-10 py-2 dark:bg-zinc-700 dark:border-zinc-800 dark:focus:ring-zinc-800 text-base border-zinc-500 dark:focus:border-ring-800 focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm rounded-sm dark:text-zinc-100 dark:placeholder:text-zinc-500"
						/>
					</div>
				{/if}

				<ButtonsGroup>
					<CancelButton bind:open />
					<ActionButton
						type="submit"
						class={'bg-blue-500 hover:bg-blue-400 focus-visible:outline-blue-600 flex items-center gap-1'}
					>
						Save
					</ActionButton>
				</ButtonsGroup>
			</form>
		</ModalWindow>
	{/if}
</div>

{#if !currentUser && open}
	<AuthModal bind:open type={$t('global.not_logged_in.bookmark')} />
{/if}
