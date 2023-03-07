<script lang="ts">
  export let block: any
  
</script>

<div class='grid grid-cols-2 sm:grid-cols-3 gap-3 lg:flex'>
  {#each block.images as image}
<div>
    <img class='aspect-[4/3] object-cover object-center opacity-90 hover:opacity-100 cursor-pointer ' src={image.src} srcset={image.srcset} />
  </div>
    {/each}
</div>
