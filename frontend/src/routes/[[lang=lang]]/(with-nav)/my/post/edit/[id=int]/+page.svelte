<script lang="ts">
	import type { PageData } from './$types';
	import BlogEditRow from '$lib/components/input/BlogEditRow.svelte';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import FileUploader from '$lib/components/input/FileUploader.svelte';
	import { magicFetch } from '$lib/helpers/fetchData';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import { afterNavigate } from '$app/navigation';
	import type { Picture as PictureType } from '$lib/interfaces/Picture';
	import DateInput from '$lib/components/input/DateInput.svelte';
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import LanguageSelect from '$lib/components/input/LanguageSelect.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Photo } from '@steeze-ui/heroicons';
	import { imageEditorOptions } from '$lib/helpers/transloadit';
	import Picture from '$lib/components/atoms/Picture.svelte';

	let t = getContext('t');
	let locale = getContext('locale');

	export let data: PageData;
	const maxDate = new Date(Date.now() + 60 * 60 * 24 * 60 * 1000).toISOString().split('T')[0];
	const defaultBlock = {
		type: 'text',
		text: ''
	};
	let images: Map<string, PictureType>,
		body = [],
		title: string,
		published_at: Date,
		language: availableLocales,
		image: PictureType | null;

	({ body, images, title, published_at, language, image } = data.post);
	published_at = published_at?.toISOString().split('T')[0];
	afterNavigate(() => {
		({ body, images, title, published_at, language, image } = data.post);
		published_at = published_at?.toISOString().split('T')[0];
	});

	let focus: number | undefined = undefined;
	let titleElement: HTMLInputElement;
	let uploadImage: number | undefined;
	let mainImageUploadModal = false;
	let errors;
	$: if (focus === -1) {
		titleElement?.focus();
	}

	function splitBlock(e: CustomEvent, curIndex: number, nextIndex: number) {
		const { before, after } = e.detail;

		body[curIndex].text = before;

		body = body.toSpliced(nextIndex, 0, { type: 'text', text: after });

		moveFocus(nextIndex);
	}

	function addBlock(index: number | undefined) {
		index ??= body.length;
		body = body.toSpliced(index, 0, { ...defaultBlock });
		moveFocus(index + 1);
	}

	function removeBlock(index: number) {
		body = body.toSpliced(index, 1);
		moveFocus(index || -1);
	}

	function moveFocus(index: number | undefined) {
		index ??= body.length - 1;
		focus = index || -1;
	}

	function titleKeyDown(e: KeyboardEvent) {
		if (e.key === 'Enter') {
			e.preventDefault();
			addBlock(0);
		}
		if (e.key === 'ArrowDown') {
			if (body.length) {
				moveFocus(1);
			} else {
				addBlock(0);
			}
		}
	}

	async function uploadComplete({ detail }) {
		const image = `temp/${detail[0].file}`;
		const result = await magicFetch('POST', '/api/image', {
			imageable_id: data.post.id.toString(),
			imageable_type: 'post',
			folder: 'posts',
			images: [image]
		});
		if (Array.isArray(result) && uploadImage !== undefined) {
			body[uploadImage] = {
				type: 'image',
				image_id: result[0].id
			};
			images.set(result[0].id.toString(), result[0]);
			// Trigger svelte update
			images = images;
			body = body;
			addBlock(undefined);
		}
		uploadImage = undefined;
	}

	async function save() {
		const json = await magicFetch('PUT', localePath($locale, `/api/post/${data.post.id}`), {
			title,
			body,
			published_at,
			language,
			image_id: image?.id || undefined // It will have id only for newly uploaded
		});
		errors = json?.errors;
	}

	async function mainImageUploaded({ detail }) {
		const tmpImage = `temp/images/${detail[0].file}`;
		const result = await magicFetch('POST', '/api/image', {
			imageable_id: data.post.id.toString(),
			imageable_type: 'post',
			folder: 'posts',
			images: [tmpImage]
		});
		image = result[0];
		mainImageUploadModal = false;
	}
</script>

<div class=" lg:mt-3 min-h-screen flex flex-col lg:mx-12 xl:ml-6 xl:mr-0">
	<InputGroup
		error={errors?.title}
		class="relative lg:pr-3 md:px-16 lg:px-12 lg:pl-16 pt-3 max-md:ml-9  mb-9   {focus === -1
			? ' border-y-0 border-l-0 border-black  border-2 ring-gray-300'
			: ''}"
	>
		<!-- svelte-ignore a11y-positive-tabindex -->
		<textarea
			tabindex="1"
			on:focusin={() => (focus = -1)}
			bind:this={titleElement}
			on:keydown={titleKeyDown}
			class="border-0 focus:ring-0 p-0 text-xl sm:text-2xl lg:text-3xl w-full font-semibold font-serif placeholder:font-normal sm:max-xl:placeholder:text-center dark:bg-black dark:placeholder:text-zinc-400"
			name="title"
			placeholder={$t('my.blog.create_title')}
			bind:value={title}
		/>
		<div class="absolute left-0 top-3">
			<button on:click={() => (mainImageUploadModal = true)}>
				{#if image}
					<Picture photo={image} class="w-10 h-10" />
				{:else}
					<Icon src={Photo} class="w-10 h-10" />
				{/if}
			</button>
		</div>
	</InputGroup>

	<div class="space-y-9 mb-9 md:max-lg:mr-16 max-md:ml-2">
		{#each body as row, index}
			{@const tabindex = index + 1}
			<BlogEditRow
				on:moveUp={() => moveFocus(tabindex - 1)}
				on:moveDown={() => moveFocus(tabindex + 1)}
				on:addBlock={() => addBlock(tabindex)}
				on:splitBlock={(e) => splitBlock(e, index, tabindex)}
				on:removeBlock={() => removeBlock(index)}
				on:uploadImage={() => (uploadImage = index)}
				{tabindex}
				bind:row
				{images}
				bind:focus
			/>
		{/each}
	</div>

	<FormGroup h1={$t('my.add_work_page.ready_to_publish')} class="mt-auto  xl:ml-16">
		<div class=" max-sm:space-y-6 max-md:flex max-md:flex-col md:columns-3">
			<DateInput bind:value={published_at} min={published_at} max={maxDate} name="published_at" />
			<LanguageSelect bind:value={language} />
			<ActionButton class="block w-full bg-blue-600 hover:bg-blue-500" on:click={save}>
				{$t('global.buttons.save')}
			</ActionButton>
		</div>
	</FormGroup>
</div>

<ModalWindow
	open={uploadImage !== undefined}
	on:close={() => (uploadImage = undefined)}
	class="w-auto"
>
	<FileUploader {...data.transloadit} maxNumberOfFiles={1} on:complete={uploadComplete} />
</ModalWindow>

<ModalWindow
	open={mainImageUploadModal}
	on:close={() => (mainImageUploadModal = false)}
	class="w-auto"
>
	<FileUploader
		{...data.transloadit}
		maxNumberOfFiles={1}
		{imageEditorOptions}
		on:complete={mainImageUploaded}
	/>
</ModalWindow>
