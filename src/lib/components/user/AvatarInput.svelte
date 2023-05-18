<script lang="ts">
	import FileInput from '$lib/components/input/FileInput.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle } from '@steeze-ui/heroicons';
	import ImageCrop from '$lib/components/atoms/ImageCrop.svelte';
	export let currentAvatar, id;
	let image, input;

	function onFileSelected({ detail }) {
		input = detail;
		let reader = new FileReader();
		reader.onload = (e) => {
			image = e.target.result;
		};
		reader.readAsDataURL(detail.files[0]);
	}

	function onCropped({ detail }) {
		let container = new DataTransfer();
		container.items.add(detail);
		input.files = container.files;
	}
</script>

<div class="mt-2 flex items-center gap-x-3">
	{#if currentAvatar?.src}
		<img {...currentAvatar} class="h-12 w-12 rounded-full" />
	{:else}
		<Icon src={UserCircle} class="h-12 w-12 text-gray-300" aria-hidden="true" />
	{/if}
	<FileInput
		{id}
		name="photo"
		accept="image/png, image/jpeg, image/webp"
		on:change={onFileSelected}
	/>
</div>

<ImageCrop aspect={1} newWidth={300} cropShape="round" {image} on:cropped={onCropped} />
