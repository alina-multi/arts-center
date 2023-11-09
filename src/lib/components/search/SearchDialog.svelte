<script>
	import { Dialog, DialogOverlay, DialogDescription } from '@rgossiaux/svelte-headlessui';
	import Button from '../atoms/buttons/Button.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MagnifyingGlass, XCircle } from '@steeze-ui/heroicons';
	import SearchInput from '$lib/components/search/SearchInput.svelte';

	let open = false;
</script>

{#if open}

<Dialog class="flex items-center justify-center " {open} on:close={() => (open = false)}>
	<DialogOverlay class="fixed z-30 inset-0 bg-zinc-900 opacity-50 dark:opacity-80" />

	<DialogDescription
		class="absolute  inset-x-0 top-0  z-50 flex items-center justify-center  py-6 bg-gray-100 dark:bg-zinc-900 border-b dark:border-zinc-800 shadow"
	>
		<div class="mx-3 w-full flex items-center">
			<SearchInput />
			<button class="text-zinc-400 ml-3" on:click={() => (open = false)}>
				<Icon src={XCircle} theme="outline" class="h-9 w-9" />
			</button>
		</div>
	</DialogDescription>
</Dialog>

{/if}

<Button on:click={() => (open = !open)} type={'button'}>
	<span class="sr-only">Search</span>
	<Icon src={MagnifyingGlass} theme="solid" class="h-8 w-8" />
</Button>
