<script lang="ts">
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';
	import SocialButtons from '$lib/components/content/SocialButtons.svelte';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<footer class="bg-zinc-900 text-white py-12 max-lg:px-6">
	<div class="container mx-auto md:flex font-light tracking-widest max-md:space-y-12">
		<div class="space-y-6 md:w-2/3 xl:w-3/4 md:pr-12 xl:pr-40 text-base">
			<h2 class="text-2xl">{$t(`global.contact.h1`)}</h2>

			<div>
				<p>{$t(`global.contact.p1`)}</p>
				<p class="text-amber-500 hover:underline">
					{$t(`global.contact.email`)} <a href="mailto:info@arts.center">info@arts.center</a>
				</p>
				<p class="mt-6">
					{$t(`global.contact.p3`)}
				</p>
			</div>

			<!-- <p>
				{$t(`global.contact.legal_name`)}
			</p> -->
		</div>

		<div class="flex flex-col justify-between">
			<div class="space-y-6">
				<div class="text-2xl">{$t(`global.footer.folow_us`)}</div>
				<SocialButtons />
			</div>

			<div class="space-y-3 pt-9 font-medium tracking-widest">
				<a
					class="dark:hover:bg-zinc-700 hover:underline block text-lg"
					href={localePath($locale, '/s/about')}>{$t('global.footer.about')}</a
				>
				<a
					class=" dark:hover:bg-zinc-700 hover:underline block"
					href={localePath($locale, '/s/privacy')}>{$t('global.footer.privacy')}</a
				>
				<a
					class=" dark:hover:bg-zinc-700 hover:underline block"
					href={localePath($locale, '/s/terms')}>{$t('global.footer.terms')}</a
				>
			</div>
		</div>
	</div>
</footer>
