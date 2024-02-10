<script lang="ts">
	import { Dashboard } from '@uppy/svelte';
	import Uppy from '@uppy/core';
	import Webcam from '@uppy/webcam';
	import type { ImageEditorOptions } from '@uppy/image-editor';
	import ImageEditor from '@uppy/image-editor';
	import { createEventDispatcher, getContext, onMount } from 'svelte';
	import Transloadit from '@uppy/transloadit';
	import Ukrainian from '@uppy/locales/lib/uk_UA';
	// Remember the CSS: core and UI components + plugins you are using
	import '@uppy/core/dist/style.css';
	import '@uppy/dashboard/dist/style.css';
	import '@uppy/webcam/dist/style.css';
	import '@uppy/image-editor/dist/style.min.css';

	const t = getContext('t');
	const locale = getContext('locale');

	export let key: string,
		signature: string,
		expires: string,
		template_id: string,
		imageEditorOptions: ImageEditorOptions,
		maxNumberOfFiles = 10;

	const dispatch = createEventDispatcher();

	const previews = new Map();

	let uppy, props;
	onMount(async () => {
		const UppyOptions = {
			locale: locale.get() === 'uk' ? Ukrainian : undefined,
			restrictions: {
				maxFileSize: 10485760,
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
		uppy = new Uppy(UppyOptions).use(Webcam, { modes: 'picture' }).use(Transloadit, {
			assemblyOptions: {
				params: {
					auth: { key, expires },
					template_id
				},
				signature
			},
			waitForEncoding: true
		});
		if (imageEditorOptions) {
			uppy.use(ImageEditor, imageEditorOptions);
		}
		uppy.on('thumbnail:generated', (file, preview) => {
			previews.set(file.name, preview);
		});
		uppy.on('transloadit:complete', (assembly) => {
			dispatch(
				'complete',
				assembly.uploads?.map((upload) => ({
					file: `${upload.original_id}.${upload.ext}`,
					preview: previews.get(upload.name)
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
