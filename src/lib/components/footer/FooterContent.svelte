<script lang="ts">
	import { localePath, t } from '$lib/translations';
	import TopNavLangLink from '../nav/TopNavLangLink.svelte';
	export let media: string;
</script>

{#if media === 'desktop'}
	<div
		class="flex items-stretch gap-3 border-b dark:border-zinc-700 w-full px-6 h-12 text-black dark:text-white"
	>
		<TopNavLangLink lang="en" />
		<TopNavLangLink lang="uk" />
	</div>

	<ul class="flex flex-col items-start py-3 text-black dark:text-white">
		<li class="w-full">
			<a class="hover:bg-gray-100 dark:hover:bg-zinc-700 px-6 block py-1.5" href={localePath('/s/about')}
				>{$t('global.footer.about')}</a
			>
		</li>
		<li class="w-full">
			<a class=" dark:hover:bg-zinc-700 hover:bg-gray-100 py-1.5 px-6 block" href={localePath('/s/subscriptions')}
				>{$t('global.footer.subscriptions')}</a
			>
		</li>
	</ul>

	<div class="flex flex-col border-t dark:border-zinc-700 text-xs py-1.5">
		<a  class=" dark:hover:bg-zinc-700 hover:bg-gray-100 py-1.5 px-6 block" 
		href={localePath('/s/privacy')}>{$t('global.footer.privacy')}</a>
		<a class=" dark:hover:bg-zinc-700 hover:bg-gray-100 py-1.5 px-6 block" 
		 href={localePath('/s/terms')}>{$t('global.footer.terms')}</a>
	</div>
{/if}

{#if media === 'mobile'}
	<div class="mt-auto mb-12 border-y dark:border-zinc-700 text-zinc-600 dark:text-zinc-100 text-">
		<ul class="flex flex-col justify-center gap-3 py-3 pl-6">
			<li>
				<a href={localePath('/s/about')}>{$t('global.footer.about')}</a>
			</li>
			<li>
				<a href={localePath('/s/subscriptions')}>{$t('global.footer.subscriptions')}</a>
			</li>
			<li>
				<a href={localePath('/s/privacy')}>{$t('global.footer.privacy')}</a></li>
			<li><a href={localePath('/s/terms')}>{$t('global.footer.terms')}</a></li>
		
		</ul>

		
			
		
	</div>
{/if}
