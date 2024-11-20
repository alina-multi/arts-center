<script lang="ts">
	import cat from '$lib/images/cat-icons.svg';
	import { getContext } from 'svelte';
	const t = getContext('t');
</script>

<div class="h-full md:flex items-center justify-center hidden">
	<div class="flex flex-col items-center justify-center gap-6">
		<svg class="h-32 w-full text-gray-400 dark:fill-zinc-400">
			<use href="{cat}#icon-cat-with-ball" />
		</svg>

		<h1 class="text-xl font-semibold">{$t(`my.messages.welcome`)}</h1>
		<div></div>
	</div>
</div>
