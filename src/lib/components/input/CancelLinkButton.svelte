<script lang="ts">
  let clazz = '';
  export { clazz as class };
  export let href;
</script>
<a {href} on:click
        class="{clazz} cursor-pointer rounded-full bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
>
  <slot>Cancel</slot>
</a>