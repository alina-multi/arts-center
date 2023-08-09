<script lang="ts">
  import BaseLink from "$lib/components/nav/BaseLink.svelte";

  export let href;
</script>
<li>
  <BaseLink {href} class="block flex gap-x-3 rounded-md py-2 pr-2 pl-8 text-sm leading-6 font-semibold" activeClass="bg-gray-50 text-indigo-600" inactiveClass="text-gray-700 hover:text-indigo-600 hover:bg-gray-50">
    <slot/>
  </BaseLink>
</li>