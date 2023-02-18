<script lang="ts">
	import { Disclosure, DisclosurePanel } from '@rgossiaux/svelte-headlessui';
	export let test;
</script>

<Disclosure as="nav" class="bg-white shadow text-gray-800 dark:bg-gray-800 dark:text-gray-100">
	<div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
		<div class="flex items-center h-16 justify-between ">
			<DisclosurePanel><slot /></DisclosurePanel>
			{test}
		</div>
	</div>
</Disclosure>
