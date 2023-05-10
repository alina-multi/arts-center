<script lang="ts">
  import Cropper from "svelte-easy-crop";
  import ModalWindow from "$lib/components/ModalWindow.svelte";
  export let image, aspect;
  export let cropShape= "rect";

  function previewCrop(e){
    console.log('preview',e.detail.pixels)
  }
  $: open = !!image
</script>

<ModalWindow {open}>
  <div class="relative h-96">
    <Cropper
      {image}
      {cropShape}
      {aspect}
      on:cropcomplete={previewCrop}
    />
  </div>
</ModalWindow>