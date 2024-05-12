<script lang="ts">
	import { getContext } from 'svelte';
	import ColorLayout from '$lib/components/static_pages/ColorLayout.svelte';

	const t = getContext('t');
</script>

<ColorLayout details="bg-zinc-900 dark:border-t-transparent text-white xs:py-12 px-3">
	<section class="container tracking-widest mx-auto space-y-6 px-3">
		<div class="space-y-1 text-3xl sm:text-4xl">
			<h1 class=" font-extralight">{$t(`global.main_page.hero.h1`)}</h1>
			<h2 class=" text-amber-500 font-light">{$t(`global.main_page.hero.h2`)}</h2>
		</div>
		<p class="lg:w-2/3 sm:text-lg font-light">
			{$t(`global.main_page.hero.p`)}
		</p>
	</section>
</ColorLayout>
