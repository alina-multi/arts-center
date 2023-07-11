<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle } from '@steeze-ui/heroicons';
	import { localePath, t } from '$lib/translations';
	import { page } from '$app/stores';
	let href;
	if ($page.data.currentUser) {
		href = localePath(`/addwork`);
	} else {
		href = localePath(`/login?redirect=${$page.url.pathname}`);
	}
</script>

<a
	{href}
	class=" inline-flex items-center shrink-0 text-sm hover:bg-amber-600 hover:border-amber-600 dark:hover:bg-amber-700 dark:hover:border-amber-700 border border-amber-700 rounded-full pl-2 pr-3 py-1 bg-amber-700 dark:bg-amber-900 dark:border-amber-900 text-white shadow-md hover:shadow-xl "
>
	<span class="sr-only">Add Work</span>
	<Icon src={PlusCircle} theme="solid" class="h-5 w-5" aria-hidden="true" />
	<span class="ml-1">ADD WORK</span>
</a>
