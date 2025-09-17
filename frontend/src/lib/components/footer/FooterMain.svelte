<script lang="ts">
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';
	import SocialButtons from '$lib/components/content/SocialButtons.svelte';
	import SelectLang from '$lib/components/filters/SelectLang.svelte';
	import SelectTheme from '$lib/components/footer/SelectTheme.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Envelope } from '@steeze-ui/heroicons';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<footer class="bg-zinc-900 text-white py-12 max-lg:px-6">
	<div
		class="container mx-auto flex flex-col lg:flex-row gap-12 items-start justify-between font-light tracking-wider"
	>
		<div class="space-y-6 max-w-lg">
			<h2 class="text-lg font-medium">{$t(`global.contact.h1`)}</h2>

			<div>
				<p>{$t(`global.contact.p1`)}</p>
				<p class=" hover:underline mt-6 flex items-center gap-2">
					<Icon src={Envelope} class="inline-block w-6 h-6 " />
					<a href="mailto:info@arts.center">info@arts.center</a>
				</p>
			</div>

			<SocialButtons listStyles={'flex items-center gap-6'} />
		</div>

		<div class="space-y-6">
			<a
				class="dark:hover:bg-zinc-700 hover:underline block text-lg font-medium"
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

		<div class="space-y-6">
			<div class=" flex gap-6 items-center">
				<span>{$t(`global.lang.language`)}</span>
				<SelectLang addClass={'border border-zinc-600   dark:bg-zinc-900 hover:bg-zinc-800'} />
			</div>
			<div class=" flex justify-between items-center">
				<span>{$t(`global.footer.theme`)}</span>
				<SelectTheme />
			</div>
		</div>
	</div>
</footer>
