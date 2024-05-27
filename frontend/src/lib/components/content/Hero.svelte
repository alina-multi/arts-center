<script lang="ts">
	import { getContext } from 'svelte';
	import ColorLayout from '$lib/components/static_pages/ColorLayout.svelte';

	const t = getContext('t');
</script>

<ColorLayout details="bg-zinc-900 dark:border-t-transparent text-white xs:py-12 px-3">
	<section class="container tracking-widest mx-auto space-y-6 px-3 font-light">
		<div class="space-y-1 text-3xl sm:text-4xl">
			<h1 class=" font-normal">{$t(`global.main_page.hero.h1`)}</h1>
			<h2 class=" text-amber-500">{$t(`global.main_page.hero.h2`)}</h2>
		</div>

		<p class="lg:w-4/5 sm:text-lg">
			{$t(`global.main_page.hero.p1`)}
		</p>
		<p class="lg:w-4/5 sm:text-lg">
			{$t(`global.main_page.hero.p2`)}
		</p>
	</section>
</ColorLayout>
