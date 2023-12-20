<script lang="ts">
	import type { ActionData, PageData } from './$types';
	import WorkForm from '$lib/components/forms/WorkForm.svelte';
	import { enhance } from '$app/forms';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import ButtonsGroup from '$lib/components/forms/ButtonsGroup.svelte';
	import { localePath } from '$lib/translations';
	import { Trash } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import ActionModal from '$lib/components/my/ActionModal.svelte';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { goto } from '$app/navigation';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let data: PageData;
	export let form: ActionData;
	const isPublished = data?.work?.status > 5 || data?.work?.published_at;
	let deleteModal = false;
	// If we don't have title yet, add :)
	$: {
		if (!data?.work?.titles?.length) {
			data.work.titles = [
				{
					language: locale.get(),
					title: '',
					description: ''
				}
			];
		}
	}

	async function deleteWork() {
		const url = `/api/work/${data.work.id}${isPublished ? '/draft' : ''}`;
		await magicFetch('DELETE', url);
		await goto(localePath($locale, '/my/work'), { invalidateAll: true });
	}
</script>

<form method="POST" action="?/post" use:enhance>
	<div class="columns-2 flex flex-col gap-3">
		<WorkForm work={data?.work} categories={data?.categories} {form}>
			<ButtonsGroup>
				{#if isPublished}
					<ActionButton
						on:click={() => (deleteModal = true)}
						type="button"
						class="bg-red-500 hover:bg-red-400 focus-visible:outline-red-600 flex items-center gap-1"
					>
						<span>{$t('my.buttons.move_to_drafts')}</span>
					</ActionButton>
				{:else}
					<ActionButton
						on:click={() => (deleteModal = true)}
						type="button"
						class="bg-gray-300 dark:bg-zinc-700 dark:text-zinc-500 hover:bg-red-500 focus-visible:outline-red-600 flex items-center gap-1"
					>
						<span>{$t('my.buttons.delete_draft')}</span>
						<Icon src={Trash} theme="solid" class="h-4 w-4" />
					</ActionButton>
				{/if}
				<ActionButton class={'bg-blue-600 hover:bg-blue-500 focus-visible:outline-blue-600'} />
			</ButtonsGroup>
		</WorkForm>
	</div>
</form>
<ActionModal
	bind:open={deleteModal}
	action={deleteWork}
	actionName={$t(isPublished ? 'my.buttons.move_to_drafts' : 'my.buttons.delete_draft')}
>
	{$t(isPublished ? 'my.confirmation.move_to_drafts' : 'my.confirmation.delete_warning')}
</ActionModal>
