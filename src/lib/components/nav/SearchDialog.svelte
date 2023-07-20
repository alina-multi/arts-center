<script>
	import { Dialog, DialogOverlay, DialogDescription } from '@rgossiaux/svelte-headlessui';
	import Button from '../atoms/Button.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MagnifyingGlass, XCircle } from '@steeze-ui/heroicons';
	import SearchInput from '$lib/components/input/SearchInput.svelte';

	let open = false;
</script>

<Dialog class="flex items-center justify-center " {open} on:close={() => (open = false)}>
	<DialogOverlay class="fixed z-30 inset-0 bg-zinc-900 opacity-50 dark:opacity-80" />

	<DialogDescription
		class="absolute  inset-x-0 top-0  z-50 flex items-center justify-center  h-20 bg-gray-100 dark:bg-zinc-900 border-b dark:border-zinc-800 shadow"
	>
		<div class="mx-3 w-full flex items-center">
			<SearchInput />
			<button class="text-zinc-400" on:click={() => (open = false)}>
				<Icon src={XCircle} theme="outline" class="h-8 w-8" />
			</button>
		</div>
	</DialogDescription>
</Dialog>

<Button on:open={() => (open = !open)} type={'button'}>
	<span class="sr-only">Search</span>
	<Icon src={MagnifyingGlass} theme="solid" class="h-7 w-7" />
</Button>
