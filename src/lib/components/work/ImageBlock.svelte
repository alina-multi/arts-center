<script lang="ts">
  export let block: any
  $: src = block?.images[0]?.src
  $: srcset = block?.images[0]?.srcset
</script>
<h3>This is image block</h3>
<div>
  <img src={src} srcset={srcset} />
</div>

