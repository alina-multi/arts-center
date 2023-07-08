<script lang="ts">
import { createEventDispatcher } from 'svelte';

export let type:'button' | 'submit' | 'reset' = 'button', 
customClass = '';
const dispatch = createEventDispatcher();
let open = false;

function handleClick() {
  dispatch('open'),
  dispatch('close');
}

</script>

<button 
{type}
on:click={handleClick}
class="{customClass} inline-flex items-center justify-center text-gray-700 dark:text-gray-100"
>
<slot />
</button>
