<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronLeft, ChevronRight } from '@steeze-ui/heroicons';
	import { goto } from '$app/navigation';

	export let currentWorkIndex;
	export let gallery;

	function changeWork(direction) {
		const newIndex = currentWorkIndex + direction;
		if (newIndex >= 0 && newIndex < gallery.length) {
			goto(`/work/${gallery[newIndex].id}`);
		}
	}
</script>

<button
	on:click={() => changeWork(-1)}
	class="fixed h-screen top-0 left-0 xs:px-3  z-40 cursor-pointer"
	class:hidden={currentWorkIndex === 0}
	aria-label="Previous Work"
>
	<Icon src={ChevronLeft} class="w-8 h-8 text-white" />
</button>
<button
	on:click={() => changeWork(1)}
	class=" fixed h-screen top-0 right-0 xs:px-3 z-40 cursor-pointer"
	class:hidden={currentWorkIndex === gallery.length - 1}
	aria-label="Next Work"
>
	<Icon src={ChevronRight} class="w-8 h-8 text-white" />
</button>
