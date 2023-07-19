<script lang="ts">
	import Cropper from 'svelte-easy-crop';
	import ModalWindow from '$lib/components/ModalWindow.svelte';
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();
	export let image, aspect, newWidth;
	export let cropShape = 'rect';
	let open: boolean,
		canvas: HTMLCanvasElement,
		pixels: { width: number; height: number; x: number; y: number };

	// I hat that we take file, convert to data url, create a lot of temp elements like this one
	// todo: Maybe there is a better way to do it?
	let tmpImage;
	$: if (image) {
		if (!tmpImage) tmpImage = new Image();
		tmpImage.src = image;
	}

	function cropComplete(e) {
		pixels = e.detail.pixels;
	}
	function doCrop() {
		let { x, y, width, height } = pixels;
		// Todo create element dynamically
		if (!canvas) canvas = document.createElement('CANVAS') as HTMLCanvasElement;
		const newHeight = newWidth && aspect ? Math.round(newWidth / aspect) : height;
		newWidth = newWidth || width;
		canvas.width = newWidth;
		canvas.height = newHeight;
		let ctx = canvas.getContext('2d');
		ctx.imageSmoothingEnabled = true;
		ctx.imageSmoothingQuality = 'high';
		ctx.drawImage(tmpImage, x, y, width, height, 0, 0, newWidth, newHeight);
	}

	function saveCrop() {
		doCrop();
		canvas.toBlob(
			(blob) => {
				dispatch('cropped', new File([blob], 'cropped.jpg'));
			},
			'image/jpeg',
			0.95
		);
	}

	$: open = !!image;
</script>

<ModalWindow {open} on:close={saveCrop}>
	<div class="relative h-96">
		<Cropper {image} {cropShape} {aspect} on:cropcomplete={cropComplete} />
	</div>
	<div class="grid grid-rows-1 justify-center">
		<canvas id="myCanvas" class="object-center rounded-full w-12 h-12"
			>Your browser does not support the HTML5 canvas tag.
		</canvas>
		<button class="w-full"> Save</button>
	</div>
</ModalWindow>
