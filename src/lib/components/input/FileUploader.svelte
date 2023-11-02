<script lang='ts'>
	import { Dashboard } from '@uppy/svelte';
	import Uppy from '@uppy/core';
	import Webcam from '@uppy/webcam';
	import ImageEditor from '@uppy/image-editor';
	import { onMount } from 'svelte';
	import Transloadit from '@uppy/transloadit';
	import { locale } from '$lib/translations';
	import Ukrainian from '@uppy/locales/lib/uk_UA';
	import { createEventDispatcher } from 'svelte';
	import type { ImageEditorOptions } from '@uppy/image-editor';

	// Remember the CSS: core and UI components + plugins you are using
	import '@uppy/core/dist/style.css';
	import '@uppy/dashboard/dist/style.css';
	import '@uppy/webcam/dist/style.css';
	import '@uppy/image-editor/dist/style.min.css';

	export let key: string,
		signature: string,
		expires: string,
		template_id: string,
		imageEditorOptions: ImageEditorOptions,
		maxNumberOfFiles = 10
	;

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
			note: 'Minimum 1600px width recommended. Max 10MB each. Only upload media you own the rights to.',
			theme: document.body.classList.contains('dark') ? 'dark' : 'light',
			proudlyDisplayPoweredByUppy: false,
			doneButtonHandler: null,
			autoOpenFileEditor: !!imageEditorOptions
		};
		uppy = new Uppy(UppyOptions).use(Webcam, { modes: 'picture' })
			.use(Transloadit, {
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
					url: upload.ssl_url,
					preview: previews.get(upload.name)
				})) ?? []
			);
		});
	});
</script>

{#if uppy}
	<div class='xl:mx-auto'>
		<Dashboard {props} {uppy} plugins={['Webcam', 'ImageEditor']} />
	</div>
{/if}
