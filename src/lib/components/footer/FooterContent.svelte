<script lang="ts">
	import { localePath, t } from '$lib/translations';
	import TopNavLangLink from '../nav/TopNavLangLink.svelte';
	export let media: string;
</script>

{#if media === 'desktop'}
	<div class="flex items-stretch gap-3 border-b dark:border-zinc-700 w-full px-9 h-12">
		<TopNavLangLink lang="en" />
		<TopNavLangLink lang="uk" />
	</div>
	<div class="flex items-start px-9 py-6 gap-12">
		<div>
			<ul class="space-y-2">
				<li>
					<a href={localePath('/s/about')}>{$t('global.footer.about')}</a>
				</li>
			</ul>
		</div>
		<div>
			<ul class="space-y-2">
				<li>
					<a href={localePath('/s/subscriptions')}>{$t('global.footer.subscriptions')}</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="flex items-center border-t dark:border-zinc-700 text-xs gap-9 px-6 py-3">
		<a href={localePath('/s/privacy')}>{$t('global.footer.privacy')}</a>
		<a href={localePath('/s/terms')}>{$t('global.footer.terms')}</a>
	</div>
{/if}

{#if media === 'mobile'}
	<div
		class="mt-auto mb-12 border-y dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 text-sm"
	>
		<ul class="flex items-start py-3 px-6 justify-between md:justify-around ">
			<li>
				<a href={localePath('/s/about')}>{$t('global.footer.about')}</a>
			</li>
			<li>
				<a href={localePath('/s/subscriptions')}>{$t('global.footer.subscriptions')}</a>
			</li>
		</ul>

		<div class="flex items-center justify-center border-t dark:border-zinc-700 gap-9 px-6 py-3">
			<a href={localePath('/privacy')}>{$t('global.footer.privacy')}</a>
			<a href={localePath('/terms')}>{$t('global.footer.terms')}</a>
		</div>
	</div>
{/if}
