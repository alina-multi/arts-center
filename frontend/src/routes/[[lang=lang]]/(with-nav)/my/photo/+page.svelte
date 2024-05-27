<script lang="ts">
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import FileUploader from '$lib/components/input/FileUploader.svelte';
	import { browser } from '$app/environment';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { invalidateAll } from '$app/navigation';
	import { checkAuth } from '$lib/stores/auth';
	import { getContext } from 'svelte';
	import { imageEditorOptions } from '$lib/helpers/transloadit';

	const t = getContext('t');
	export let data;

	async function uploadComplete({ detail }) {
		const image = `temp/${detail[0].file}`;
		await magicFetch('POST', '/api/photo', {
			image
		});
		await invalidateAll();
		await checkAuth();
	}
</script>

<FormGroup h1={$t('my.edit_page.photo')}>
	{#if browser}
		<FileUploader
			{...data.transloadit}
			maxNumberOfFiles="1"
			{imageEditorOptions}
			on:complete={uploadComplete}
		/>
	{/if}
</FormGroup>
