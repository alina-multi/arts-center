<script lang='ts'>
	import type { PageData } from './$types';
	import BlogEditRow from '$lib/components/input/BlogEditRow.svelte';
	import BlogEditText from '$lib/components/input/BlogEditText.svelte';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import FileUploader from '$lib/components/input/FileUploader.svelte';
	import { fetchData, magicFetch } from '$lib/helpers/fetchData';
	import { invalidateAll } from '$app/navigation';
	import { checkAuth } from '$lib/stores/auth';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';

	export let data: PageData;
	const defaultBlock = {
		type: 'text',
		text: ''
	};
	let body = [
		...data?.post?.body ?? [{ ...defaultBlock }]
	];

	let images = data?.post?.images ?? new Map();
	let title = data?.post?.title ?? '';
	let focus: number | undefined = undefined;
	let titleElement: HTMLInputElement;
	let uploadImage: number | undefined;
	let errors, message;
	$:if (focus === -1) {
		titleElement?.focus();
	}

	function addBlock(index: number | undefined) {
		index ??= body.length;
		body = body.toSpliced(index + 1, 0, { ...defaultBlock });
		moveFocus(index + 1);
	}

	function removeBlock(index: number) {
		body = body.toSpliced(index, 1);
		moveFocus(index - 1);
	}

	function moveFocus(index: number | undefined) {
		index ??= body.length - 1;
		focus = index;
	}

	function titleKeyDown(e: KeyboardEvent) {
		if (e.key === 'Enter') {
			e.preventDefault();
			addBlock(-1);
		}
		if (e.key === 'ArrowDown') {
			if (body.length) {
				moveFocus(0);
			} else {
				addBlock(-1);
			}
		}
	}

	async function uploadComplete({ detail }) {
		const image = `temp/images/${detail[0].file}`;
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
			images.set(result[0].id, result[0]);
			// Trigger svelte update
			images = images;
			body = body;
		}
		uploadImage = undefined;
	}

	async function save() {
		const response = await fetchData('PUT', `/api/post/${data.post.id}`, {
			title,
			body
		});
		const json = await response.json();
		errors = json?.errors;
		message = json?.message;
	}
</script>
<InputGroup let:hasError error={errors?.title} class='pl-16 {focus===-1?"ring-1 ring-gray-300":""}'>
<input tabindex=1 on:focusin={()=>focus = -1} bind:this={titleElement} on:keydown={titleKeyDown} class='border-0 focus:ring-0 p-0 text-xl' type='text' name='title'
			 placeholder='Title' bind:value={title}>
</InputGroup>
{#each body as row, index}
	<BlogEditRow on:moveUp={()=>moveFocus(index-1)}
							 on:moveDown={()=>moveFocus(index+1)}
							 on:addBlock={()=>addBlock(index)}
							 on:removeBlock={()=>removeBlock(index)}
							 on:uploadImage={()=>uploadImage = index}
							 {index}
							 bind:row={row}
							 {images}
							 bind:focus
	/>
{/each}

<ActionButton class={'bg-green-600 hover:bg-green-500 focus-visible:outline-green-600'} on:click={save}>
	Save
</ActionButton>

<ModalWindow open={uploadImage!== undefined} on:close={()=>uploadImage=undefined} class='w-auto'>
	<FileUploader {...data.transloadit} maxNumberOfFiles={1} on:complete={uploadComplete} />
</ModalWindow>