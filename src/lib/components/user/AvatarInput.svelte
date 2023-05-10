<script lang="ts">
  import FileInput from "$lib/components/input/FileInput.svelte";
  import { Icon } from "@steeze-ui/svelte-icon";
  import { UserCircle } from "@steeze-ui/heroicons";
  import ImageCrop from "$lib/components/atoms/ImageCrop.svelte";
  export let profile, id;
  let image;

  function onFileSelected(e) {
    let imageFile = e.detail.files[0];
    let reader = new FileReader();
    reader.onload = e => {
      image = e.target.result;
    };
    reader.readAsDataURL(imageFile);
  }
</script>

<div class="mt-2 flex items-center gap-x-3">
  {#if profile?.avatar?.src}
    <img
      src={profile.avatar.src}
      srcset={profile.avatar.srcset}
      class="h-12 w-12 rounded-full"
    />
  {:else}
    <Icon src={UserCircle} class="h-12 w-12 text-gray-300" aria-hidden="true" />
  {/if}
  <FileInput {id} name="avatar" accept="image/png, image/jpeg, image/webp" on:change={onFileSelected}/>
</div>

<ImageCrop aspect={1} cropShape="round" {image} />