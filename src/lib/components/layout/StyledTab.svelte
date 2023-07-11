<script>
  import { Tab } from "@rgossiaux/svelte-headlessui";
</script>

<Tab
  class={({selected}) => `hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium
              ${selected ? 'border-amber-500 text-gray-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'}
              `}
>
  <slot />
</Tab>