<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronLeft, ChevronRight } from '@steeze-ui/heroicons';
	import { goto } from '$app/navigation';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';

	export let currentWorkIndex, gallery;

	const locale = getContext('locale');

	function changeWork(direction) {
		const newIndex = currentWorkIndex + direction;
		if (newIndex >= 0 && newIndex < gallery.length) {
			goto(localePath($locale, `/work/${gallery[newIndex].id}`), { replaceState: true });
		}
	}
</script>

<div
	class="fixed top-1/2 -translate-y-1/2 left-0 xs:px-3 z-40 cursor-pointer flex items-center justify-center"
>
	<button
		on:click={() => changeWork(-1)}
		class="bg-zinc-300/20 p-3 rounded-full"
		class:hidden={currentWorkIndex === 0}
		aria-label="Previous Work"
	>
		<Icon src={ChevronLeft} class="w-5 h-5 text-white stroke-2 pr-0.5" />
	</button>
</div>

<div
	class="fixed top-1/2 -translate-y-1/2 right-0 xs:px-3 z-40 cursor-pointer flex items-center justify-center"
>
	<button
		on:click={() => changeWork(1)}
		class="bg-zinc-300/20 p-3 rounded-full"
		class:hidden={currentWorkIndex === gallery.length - 1}
		aria-label="Next Work"
	>
		<Icon src={ChevronRight} class="w-5 h-5 text-white stroke-2 pl-0.5" />
	</button>
</div>
