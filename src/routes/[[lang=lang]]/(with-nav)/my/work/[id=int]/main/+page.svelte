<script lang='ts'>
	import type { PageData } from './';
	import { t, localePath } from '$lib/translations';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Trash, InformationCircle } from '@steeze-ui/heroicons';
	import Cropper from 'svelte-easy-crop';
	import ActionModal from '$lib/components/my/ActionModal.svelte';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { goto, invalidateAll } from '$app/navigation';
	import NextStepButton from '$lib/components/my/NextStepButton.svelte';

	export let data: PageData;
	let cropImage;
	let crop;
	let imageToDelete;

	if (data.work?.images?.length === 1) {
		cropImage = data.work?.images[0];
	}

	async function saveMain() {
		await magicFetch('PUT', `/api/work/${data.work.id}/images/${cropImage.id}`, { crop });
		cropImage = undefined;
		crop = undefined;
		await invalidateAll();
		// If there is no additional images after save, just redirect to next page, nothing to do here
		if (!data.work?.images?.length) {
			await goto(localePath(`/my/work/${data.work.id}/form`));
		}
	}

	function cropComplete({ detail }) {
		crop = detail.pixels;
	}

	async function deleteImage() {
		await magicFetch('DELETE', `/api/work/${data.work.id}/images/${imageToDelete.id}`);
		await invalidateAll();
		imageToDelete=undefined;
	}
</script>
{#if data.work?.full}
	<NextStepButton href={localePath(`/my/work/${data.work.id}/from`)}/>
	<FormGroup h1={$t('my.add_work_page.main_image')}>
		<div class='grid grid-cols-1 sm:grid-cols-2'>
			<div>
				<h3 class='text-center font-bold'>{$t('my.add_work_page.main_preview')}</h3>
				<Picture class='inline-block' photo={data.work.preview} />
			</div>
			<div>
				<h3 class='text-center font-bold'>{$t('my.add_work_page.main_full')}</h3>
				<Picture class='inline-block w-full h-auto' photo={data.work.full} />
			</div>
		</div>
	</FormGroup>
{:else}
	{$t('my.add_work_page.please_select_main')}
{/if}

{#if data.work?.images?.length}
	<FormGroup h1={$t('my.add_work_page.additional_images')}>
		<div class='mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-3 lg:grid-cols-6 xl:gap-x-8'>
			{#each data.work.images as image}
				<div>
					<button on:click={()=>cropImage=image}
									class='border-2 border-zinc-100 hover:border-green-500 cursor-pointer rounded-sm'>
						<Picture photo={image} />
						{$t('my.buttons.set_main')}
					</button>
					<button on:click={()=>imageToDelete=image} class='text-center w-full bg-zinc-100 hover:bg-red-100'>
						{$t('my.buttons.delete_image')}
						<Icon src={Trash} class='h-4 w-4 inline-block' />
					</button>
				</div>
			{/each}
		</div>
	</FormGroup>
{/if}

<ActionModal
	open={!!cropImage}
	action={saveMain}
	className='bg-green-500 hover:bg-green-400 focus-visible:outline-green-600 '
	actionName={$t('my.buttons.crop')}
>
	{#if cropImage}
		<div class='relative h-96 w-full mx-auto'>
			<Cropper image={cropImage.src} aspect={4 / 3} on:cropcomplete={cropComplete} />
		</div>
		<div class='text-gray-500 text-sm'>
			<Icon src={InformationCircle} class='inline-block h-4 w-4' />
			{$t('my.add_work_page.crop_hint')}
		</div>
	{/if}
</ActionModal>

<ActionModal
	open={!!imageToDelete}
	action={deleteImage}
	actionName={$t('my.buttons.delete_image')}
>
	{$t('my.confirmation.delete')}
</ActionModal>