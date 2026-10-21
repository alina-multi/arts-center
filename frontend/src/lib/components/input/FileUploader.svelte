<script lang="ts">
	import { Dashboard } from '@uppy/svelte';
	import Uppy from '@uppy/core';
	import Webcam from '@uppy/webcam';
	import type { ImageEditorOptions } from '@uppy/image-editor';
	import ImageEditor from '@uppy/image-editor';
	import { createEventDispatcher, getContext, onMount } from 'svelte';
	import Tus from '@uppy/tus';
	import XHRUpload from '@uppy/xhr-upload';
	import { page } from '$app/stores';
	import Ukrainian from '@uppy/locales/lib/uk_UA';
	// Remember the CSS: core and UI components + plugins you are using
	import '@uppy/core/dist/style.css';
	import '@uppy/dashboard/dist/style.css';
	import '@uppy/webcam/dist/style.css';
	import '@uppy/image-editor/dist/style.min.css';

	const t = getContext('t');
	const locale = getContext('locale');

	export let imageEditorOptions: ImageEditorOptions,
		maxNumberOfFiles = 10;

	const dispatch = createEventDispatcher();

	const previews = new Map();

	let uppy, props;
	onMount(async () => {
		const demo = Boolean($page.data.demo);
		const UppyOptions = {
			locale: locale.get() === 'uk' ? Ukrainian : undefined,
			onBeforeFileAdded: () => true,
			restrictions: {
				maxFileSize: demo ? 8 * 1024 * 1024 : 10485760,
				maxNumberOfFiles,
				allowedFileTypes: ['image/jpeg', 'image/png', 'image/webp']
			},
			thumbnailWidth: 600
		};
		props = {
			note: $t('my.add_work_page.allowed_files_hint'),
			theme: document.body.classList.contains('dark') ? 'dark' : 'light',
			proudlyDisplayPoweredByUppy: false,
			doneButtonHandler: null,
			autoOpenFileEditor: !!imageEditorOptions
		};
		uppy = new Uppy(UppyOptions).use(Webcam, { modes: 'picture' });
		if (demo) {
			uppy.use(XHRUpload, {
				endpoint: '/api/demo-upload',
				fieldName: 'file',
				formData: true,
				getResponseData(responseText) {
					const data = JSON.parse(responseText);
					return { url: `/demo-files/${data.id}` };
				}
			});
		} else {
			uppy.use(Tus, { endpoint: '/uploads' });
		}
		if (imageEditorOptions) {
			uppy.use(ImageEditor, imageEditorOptions);
		}
		uppy.on('thumbnail:generated', (file, preview) => {
			previews.set(file.name, preview);
		});
		uppy.on('complete', ({ successful }) => {
			dispatch(
				'complete',
				successful?.map(({ name, uploadURL }) => ({
					file: `${uploadURL.split('/').pop()}`,
					preview: previews.get(name)
				})) ?? []
			);
		});
	});
</script>

{#if uppy}
	<div class="xl:mx-auto">
		<Dashboard {props} {uppy} plugins={['Webcam', 'ImageEditor']} />
	</div>
{/if}
