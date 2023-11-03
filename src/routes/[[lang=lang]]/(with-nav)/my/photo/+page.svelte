<script lang='ts'>
	import { t } from '$lib/translations/index.js';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import FileUploader from '$lib/components/input/FileUploader.svelte';
	import { browser } from '$app/environment';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { invalidateAll } from '$app/navigation';
	import { checkAuth } from '$lib/stores/auth';
	export let data;
	const imageEditorOptions = {
		actions: {
			revert: true,
			rotate: true,
			granularRotate: false,
			flip: true,
			zoomIn: true,
			zoomOut: true,
			cropSquare: false,
			cropWidescreen: false,
			cropWidescreenVertical: false,
		},
		cropperOptions: {
			viewMode: 1,
			aspectRatio: 1
		}
	}

	async function uploadComplete({ detail }) {
		const image =  `temp/photos/${detail[0].file}`;
		await magicFetch('POST','/api/photo', {
			image
		});
		await invalidateAll()
		await checkAuth()
	}
</script>

<FormGroup h1={$t('my.edit_page.photo')}>
	{#if browser}
		<FileUploader {...data.transloadit} maxNumberOfFiles=1 {imageEditorOptions} on:complete={uploadComplete} />
	{/if}
</FormGroup>