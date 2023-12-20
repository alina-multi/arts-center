<script lang="ts">
	import { localePath } from '$lib/translations';
	import logo from '$lib/images/logo.svg';
	import { getContext } from 'svelte';

	export let size = 'h-20 w-[10rem]';
	const locale = getContext('locale');
</script>

<a
	href={localePath($locale, '/')}
	class="text-amber-700 inline-flex items-center pt-1 focus-visible:outline-none"
>
	<svg class="{size} dark:fill-white dark:stroke-white">
		<use href="{logo}#logo" />
	</svg>
</a>
