<script lang="ts">
  import {createEventDispatcher} from 'svelte';
  const dispatch = createEventDispatcher();
  export let id: string,
    placeholder: string,
    value: string,
    error: boolean,
    name: string,
    accept: string
  ;

</script>
<input
  bind:value
  type="file"
  {name}
  {id}
  {placeholder}
  {accept}
  on:change={(e)=>dispatch('change', {files: e.target.files})}
  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
/>