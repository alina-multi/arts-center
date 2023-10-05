<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bookmark, BookmarkSlash, Folder, FolderPlus } from '@steeze-ui/heroicons';
	import toast from 'svelte-french-toast';
	import { fetchData } from '$lib/helpers/fetchData';
	import RadioButton from '$lib/components/input/RadioButton.svelte';
	import TextInput from '$lib/components/input/TextInput.svelte';
	import ModalWithForm from '$lib/components/my/ModalWithForm.svelte';
	import { t } from '$lib/translations';
	import { user } from '$lib/stores/auth';

	export let work;
	let url = '/api/favorite';
	let workID = Number(work.id);
	$: isBookmarked = $user?.favorites?.works.some((favorite: number) => favorite === workID);
	


	let open = false;
	let showInput = false;
	let error = '';
	let folderID = 0;
	$: folderName = showInput ? '' : 'All works';
	$: folders = $user?.favorites?.folders;

	function onChange(e: Event & { target: HTMLInputElement }) {
		folderID = Number(e.target.value);
		showInput = false;
		error = '';
	}
	

	async function saveInExistingFolder() {
		if (folderID === 0) {
			error = $t('global.bookmark.select_folder');
			return;
		}
		const response = await fetchData('POST', url, { work_id: workID, folder_id: folderID });
		const data = await response.json();

		if (!response.ok) {
			error = data.message;
			return;
		}
       
		toast.success($t('global.bookmark.work_saved'));
		open = false;
		isBookmarked = true;
	}

	async function createFolder() {
		folderName = folderName.trim();
		if (folderName === '') {
			error = $t('global.bookmark.enter_folder_name');
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

		toast.success($t('global.bookmark.saved_to', {folderName: `${folderName}`}));
		open = false;
		isBookmarked = true;
		showInput = false;
	}

	async function remove() {
		await fetchData('DELETE', url, { work_id: workID });
		isBookmarked = false;
	}
</script>

<div
	class="flex border border-l-transparent rounded-sm px-3 -ml-4 py-1 dark:border-zinc-700 dark:bg-zinc-800"
>
	<button
		type="button"
		on:click={isBookmarked ? remove : () => (open = true)}
		class=" text-sm dark:text-zinc-300 text-zinc-600 dark:border-zinc-700"
	>
		{#if isBookmarked}
		

			<Icon
				src={BookmarkSlash}
				class="h-6 w-6 text-gray-400 dark:text-zinc-600"
				aria-hidden="true"
			/>
		{:else}
		
			<Icon
				src={Bookmark}
				class="h-6 w-6   xl:hover:stroke-zinc-500 dark:hover:stroke-zinc-100 dark:hover:fill-zinc-100 fill-white dark:fill-zinc-300 "
				aria-hidden="true"
			/>
		{/if}
	</button>

	<ModalWithForm
		bind:open
		length={folders?.length}
		condition={showInput || folders?.length === 0}
		submitFromList={saveInExistingFolder}
		submiInput={createFolder}
	>
		<svelte:fragment slot="header">
			<h2 class="text-base font-semibold">{$t('global.bookmark.save_work_to')}</h2>

			{#if folders?.length > 0}
				<button
					on:click={() => ((showInput = true), (folderID = 0))}
					type="button"
					class="flex items-center text-sm hover:text-gray-700 text-gray-900 dark:text-white dark:hover:text-zinc-300 cursor-pointer focus-outline-none focus:ring-transparent"
				>
					<Icon src={FolderPlus} class="h-7 w-7 " aria-hidden="true" />
				</button>
			{/if}
		</svelte:fragment>

		<svelte:fragment  slot="list">
			{#if error && !showInput}
				<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
			{/if}
			{#each folders as folder (folder?.id)}
				<div class="relative flex items-center justify-between ">
					<RadioButton
						id={folder?.id}
						label={folder?.title}
						name={folder?.id}
						value={folder?.id}
						checked={folderID === folder?.id}
						{onChange}
					>
						<Icon src={Folder} class="h-6 w-6 " aria-hidden="true" />
					</RadioButton>
				</div>
			{/each}
		</svelte:fragment >

		<svelte:fragment slot="showInput">
			{#if error}
				<span class="text-red-500 text-xs absolute top-[42px] left-0">{error}</span>
			{/if}

			<TextInput
				id="folder"
				name="folder"
				bind:value={folderName}
				placeholder={$t('global.bookmark.create_folder')}
				bind:error
			/>
		</svelte:fragment>
	</ModalWithForm>


</div>


