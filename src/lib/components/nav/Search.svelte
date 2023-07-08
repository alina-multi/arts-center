
<script>
    import {
        Dialog,
		DialogOverlay,
		DialogDescription,
		Transition
    } from "@rgossiaux/svelte-headlessui";
    import Button from '../atoms/Button.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MagnifyingGlass, XCircle } from '@steeze-ui/heroicons';
    import SearchInput from '$lib/components/input/SearchInput.svelte';
  
    let open = false;
   
  </script>

<Button on:open={() => (open = !open)} type={'button'}>
    <span class="sr-only">Open main menu</span>
    <Icon src={MagnifyingGlass} theme="solid" class="h-7 w-7" aria-hidden="true" />
</Button>
  
  <Dialog class="flex items-center justify-center " {open} on:close={() => (open = false)}>
 
  <DialogOverlay class="fixed z-30 inset-0  bg-gray-900/50 " />
  
    <DialogDescription class="absolute  inset-x-0 top-0  z-50 flex items-center justify-center   h-20 bg-white border-b shadow-md">
        
         <div class="mx-3 w-full flex  items-center "> 
            <SearchInput />
            <button class="text-amber-700"
            on:click={() => (open = false)}
            >
                <Icon src={XCircle} theme="outline" class="h-9 w-9" aria-hidden="true" />
            </button>
        </div>  
  
    </DialogDescription>
   
  </Dialog>