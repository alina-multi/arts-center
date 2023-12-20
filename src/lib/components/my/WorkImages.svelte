<script lang="ts">
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import FileUploader from '$lib/components/input/FileUploader.svelte';
	import { localePath } from '$lib/translations';
	import { goto } from '$app/navigation';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let transloadit;
	export let work;

	async function uploadComplete({ detail }) {
		const images = detail.map(({ file }) => `temp/works/${file}`);
		// Depending on how we use this, for new work or adding images we have 2 backend endpoints
		const json = await magicFetch('POST', work?.id ? `/api/work/${work.id}/images` : '/api/work', {
			images
		});
		const url = localePath($locale, `/my/work/${json.id}/main`);
		await goto(url, { invalidateAll: true });
	}
</script>

<FormGroup h1={$t('my.add_work_page.label_step_1')}>
	<FileUploader {...transloadit} on:complete={uploadComplete} />
</FormGroup>
