<script lang="ts">
	import { localePath } from '$lib/translations';
	import TopNavLangLink from '../nav/TopNavLangLink.svelte';
	import { getContext } from 'svelte';
	import SocialButtons from '../content/SocialButtons.svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let media: string;
</script>

{#if media === 'desktop'}
	<div
		class="flex items-stretch gap-3 shadow dark:border-zinc-700 w-full px-6 h-12 text-black dark:text-white"
	>
		<TopNavLangLink lang="en" />
		<TopNavLangLink lang="uk" />
	</div>

	<ul class="flex flex-col items-start py-3 text-black dark:text-white">
		<li class="w-full">
			<a
				class="hover:bg-gray-100 dark:hover:bg-zinc-700 px-6 block py-1.5 font-medium text-base"
				href={localePath($locale, '/s/about')}>{$t('global.footer.about')}</a
			>
		</li>
	</ul>

	<div class="flex flex-col dark:border-zinc-700 text-xs pb-6 border-b">
		<a
			class=" dark:hover:bg-zinc-700 hover:bg-gray-100 py-1.5 px-6 block"
			href={localePath($locale, '/s/privacy')}>{$t('global.footer.privacy')}</a
		>
		<a
			class=" dark:hover:bg-zinc-700 hover:bg-gray-100 py-1.5 px-6 block"
			href={localePath($locale, '/s/terms')}>{$t('global.footer.terms')}</a
		>
	</div>
{/if}

<div class="space-y-3 p-6">
	<p class=" text-black dark:text-white font-medium text-base">{$t(`global.contact.h1`)}</p>
	<p>{$t(`global.contact.p1`)}</p>
	<p>{$t(`global.contact.p2`)}</p>
	<p class=" text-black dark:text-white font-medium">
		<a href="mailto:info@arts.center">info@arts.center</a>
	</p>
</div>

<SocialButtons
	listStyles={'border-t dark:border-zinc-700 px-6 xs:gap-9 text-zinc-800 dark:text-white py-2'}
/>

{#if media === 'mobile'}
	<div
		class="mt-auto pt-6 border-t dark:border-zinc-700 font-medium text-zinc-600 dark:text-zinc-100"
	>
		<ul class="flex flex-col justify-center text-xs gap-3 pl-6">
			<li>
				<a href={localePath($locale, '/s/about')}>{$t('global.footer.about')}</a>
			</li>
			<li>
				<a href={localePath($locale, '/s/privacy')}>{$t('global.footer.privacy')}</a>
			</li>
			<li><a href={localePath($locale, '/s/terms')}>{$t('global.footer.terms')}</a></li>
		</ul>
	</div>
{/if}
