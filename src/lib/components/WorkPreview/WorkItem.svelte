<script lang="ts"> 
export let title, price, src, srcset;

</script>

<a href="#" class="grid  gap-2">
    <img class="rounded-md" src={src} alt="User" />
    <div
        class=" inline-flex items-start justify-between font-medium text-gray-900 dark:text-zinc-100"
    >
        <h3 class=" text-lg lg:text-sm"> {title}</h3>
      {#if price}  <p class="ml-2 bg-green-600 px-2 py-1 rounded-md text-white">${price}</p>{/if}
    </div>
</a>
