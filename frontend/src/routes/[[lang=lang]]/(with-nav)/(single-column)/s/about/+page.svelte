<script lang="ts">
	import { getContext } from 'svelte';
	import type { PageData } from './$types';
	import DonateFormCustom from '$lib/components/atoms/DonateFormCustom.svelte';
	import Icon1 from '$lib/components/static_pages/icons/Icon1.svelte';
	import Icon2 from '$lib/components/static_pages/icons/Icon2.svelte';
	import Icon3 from '$lib/components/static_pages/icons/Icon3.svelte';
	import Icon4 from '$lib/components/static_pages/icons/Icon4.svelte';
	import Icon5 from '$lib/components/static_pages/icons/Icon5.svelte';
	import SectionLayout from '$lib/components/static_pages/SectionLayout.svelte';
	import H1 from '$lib/components/static_pages/H1.svelte';
	import H2 from '$lib/components/static_pages/H2.svelte';
	import H3 from '$lib/components/static_pages/H3.svelte';
	import LoginLink from '$lib/components/nav/LoginLink.svelte';
	import ColorLayout from '$lib/components/static_pages/ColorLayout.svelte';

	const t = getContext('t');

	export let data: PageData;
</script>

<div class=" text-lg font-light leading-7 xs:leading-9 tracking-wider">
	<ColorLayout details="bg-zinc-900 dark:border-t-transparent text-white xs:py-12">
		<SectionLayout>
			<H1 text="static.about.hero_h1" />

			<p class="tracking-widest">
				{$t(`static.about.hero_text`)}
			</p>

			<Icon1 class="w-32 h-32 fill-amber-600" />
		</SectionLayout>
	</ColorLayout>

	<div class="pt-12 space-y-9">
		<SectionLayout>
			<H2 text="МЕТА ARTS.CENTER" />

			<p>
				{$t(`static.about.mission.p1`)}
			</p>
		</SectionLayout>

		<SectionLayout>
			<dl
				class=" max-md:flex max-md:flex-col grid grid-cols-3 justify-around gap-6 lg:gap-12 w-full"
			>
				{#each ['artists', 'artworks', 'comments'] as stat}
					<div
						class=" max-md:bg-zinc-100 shadow max-md:w-full relative max-sm:pl-6 max-md:pl-9 md:p-6 flex md:flex-col justify-between md:justify-center items-center xs:gap-6 overflow-hidden md:border border-black dark:border dark:bg-zinc-900 dark:border-zinc-800"
					>
						<dt class=" tracking-widest text-xl sm:max-md:text-2xl font-medium">
							{$t(`static.about.stats.${stat}`)}
						</dt>

						<dd
							class=" text-2xl rounded-sm xs:text-3xl tracking-widest bg-zinc-900/95 dark:bg-teal-700 text-white w-32 xs:w-36 sm:w-44 md:w-36 py-9 flex justify-center items-center"
						>
							<span>{data[stat]}</span>
						</dd>
					</div>
				{/each}
			</dl>

			<p class="pt-3 pb-9">
				{@html $t(`static.about.mission.p2`)}
			</p>
		</SectionLayout>
	</div>
	<ColorLayout details="bg-zinc-100">
		<SectionLayout>
			<p>
				{$t(`static.about.mission.p3`)}
			</p>
		</SectionLayout>
	</ColorLayout>

	<div class="py-9 space-y-3">
		<Icon4 class="w-28 h-28 fill-amber-600" />
		<SectionLayout>
			{#each ['4', '5'] as number}
				<p>{$t(`static.about.mission.p${number}`)}</p>
			{/each}
		</SectionLayout>
	</div>

	<ColorLayout details="bg-zinc-100">
		<SectionLayout>
			<p class="font-normal">
				{@html $t(`static.about.mission.p6`)}
			</p>
		</SectionLayout>
	</ColorLayout>

	<div class="py-12 space-y-9">
		<SectionLayout>
			<Icon2 class="h-28 w-28 fill-amber-600" />

			<H2 text="static.about.history.h1" />
			<H3 text="static.about.history.h2" />
		</SectionLayout>

		<SectionLayout>
			<div class="space-y-3 tracking-normal leading-7">
				{#each ['1', '2', '3', '4', '5', '6', '7'] as number}
					<p>{$t(`static.about.history.p${number}`)}</p>
				{/each}

				<div class="space-y-6 pt-6 lg:pt-12">
					<div class="flex justify-center flex-col">
						<div class="">
							<div class="flex justify-center gap-48 lg:gap-52">
								<div class="h-12 w-12 border border-black dark:border-zinc-400" />
								<div class="h-12 w-12 border border-black dark:border-zinc-400" />
							</div>

							<img
								src="/Stepan_Orda.jpg"
								class="mx-auto h-48 w-48 lg:h-52 lg:w-52 object-cover"
								alt={$t('static.about.team.stepan.alt')}
							/>
							<div class="flex justify-center gap-48 lg:gap-52">
								<div class="h-12 w-12 border border-black dark:border-zinc-400" />
								<div class="h-12 w-12 border border-black dark:border-zinc-400" />
							</div>
						</div>
					</div>

					<div class="flex justify-center">
						<div
							class="gap-2 p-6 w-full sm:w-2/3 lg:w-7/12 xl:w-1/2 border border-black dark:border-zinc-400 flex flex-col items-center justify-center max-xs:w-full tracking-widest"
						>
							<p class="text-xl font-medium">{$t('static.about.team.stepan.name')}</p>
							<p class="text-lg">{$t('static.about.team.stepan.title')}</p>
						</div>
					</div>
				</div>
			</div>
		</SectionLayout>
	</div>

	<ColorLayout details="bg-zinc-900 text-white xl:py-12">
		<SectionLayout>
			<Icon3 class="w-28 h-28 fill-amber-600" />

			<H2 text="static.about.support.h1" />
			<p class="tracking-widest">
				{$t(`static.about.support.p1`)}
			</p>
		</SectionLayout>
	</ColorLayout>
	<ColorLayout details="bg-zinc-100 lg:py-12 shadow">
		<SectionLayout>
			<div class="space-y-9">
				<p class="font-medium sm:text-center">
					{$t(`static.about.support.p2`)}
				</p>

				<div class="md:w-2/3 xl:w-1/2 mx-auto">
					<DonateFormCustom />
				</div>

				<p class="font-medium text-center">{$t(`static.about.support.p3`)}</p>
			</div>
		</SectionLayout>
	</ColorLayout>

	<div class=" py-9">
		<SectionLayout>
			<Icon5 class="w-28 h-28 dark:fill-zinc-700" />
			<H2 text="static.about.join_us.h1" />

			<p class=" xl:w-2/3 mx-auto">
				{$t(`static.about.join_us.p1`)}
			</p>

			<div
				class="mx-auto sm:grid sm:grid-cols-2 xl:w-2/3 flex max-sm:flex-col gap-6 sm:gap-9 justify-center items-center font-medium"
			>
				<LoginLink styles="py-4 tracking-widest text-lg  w-full" />
				<a
					href="/"
					class="tracking-widest w-full text-lg text-center px-3 py-4 border border-zinc-900 dark:border-zinc-500 dark:bg-zinc-800 shadow-sm hover:bg-amber-600 hover:border-amber-600 dark:text-zinc-100 hover:text-white cursor-pointer"
					>{$t(`global.menu.register`)}</a
				>
			</div>
		</SectionLayout>
	</div>
	<ColorLayout details="bg-zinc-100 xl:py-12">
		<SectionLayout>
			<H2 text={`global.contact.h1`} />

			<div class="text-center space-y-3">
				<p class="font-medium">
					{$t(`global.contact.p3`)}
				</p>
				<p>{$t(`global.contact.p1`)}</p>
				<p class="font-medium">
					{$t(`global.contact.email`)} <a href="mailto:info@arts.center">info@arts.center</a>
				</p>
				<p>{$t(`global.contact.legal_name`)}</p>
			</div>
		</SectionLayout>
	</ColorLayout>
</div>
