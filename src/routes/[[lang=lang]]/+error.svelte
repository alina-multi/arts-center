<script lang="ts">
	import { page } from '$app/stores';
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import cat from '$lib/images/cat-icons.svg';
</script>

<MainNav />
<main class="container mx-auto xs:px-3 min-h-screen">
	<div
		class="flex max-sm:flex-col items-center justify-center py-12 px-9 text-zinc-800 lg:gap-12 dark:text-zinc-100 bg-zinc-50 dark:bg-zinc-900 xs:mt-6 xs:rounded-sm"
	>
		<svg class="sm:h-96 sm:w-96 fill-zinc-800 dark:fill-zinc-100">
			<use href="{cat}#icon-cat-not-found" />
		</svg>
		<div class="p-6 text-center max-sm:space-y-3">
			<h1 class="text-5xl sm:text-9xl">{$page.status}</h1>
			<h2 class="text-4xl">{$page.error.message}</h2>
		</div>
	</div>
</main>
