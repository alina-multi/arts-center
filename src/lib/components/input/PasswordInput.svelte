<script lang="ts">
  import { Icon } from "@steeze-ui/svelte-icon";
  import { Eye, EyeSlash } from "@steeze-ui/heroicons";

  export let
    id: string,
    value: string,
    error: boolean,
    name: string,
    autocomplete: string;
  let type = "password";

  let show_password = false;
  $: type = show_password ? "text" : "password";
  $: inputAttrs = {
    name,
    id,
    type,
    autocomplete,
    value
  };
</script>

<div class="relative">
  <input
    {...inputAttrs}
    on:input={(e) => (value = e.target.value)}
    class="block w-full rounded-md border sm:text-sm pr-10 {error
					? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200'
					: 'border-zinc-300 focus:border-indigo-300 focus:ring-indigo-200'}"
  />
  <a
    class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer"
    on:click={() => (show_password = !show_password)}
  >
    {#if show_password}
      <Icon src={Eye} class="h-6 text-gray-700" />
    {:else}
      <Icon src={EyeSlash} class="h-6 text-gray-700" />
    {/if}
  </a>
</div>
