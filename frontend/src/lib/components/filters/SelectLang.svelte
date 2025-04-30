<script lang="ts">
	import { onMount } from 'svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronUpDown, Check } from '@steeze-ui/heroicons';
	import { type AvailableLocales, switchLocalePath } from '$lib/translations';
	import { getContext } from 'svelte';
	import { page } from '$app/stores';

	const t = getContext('t');
	const locale = getContext('locale');

	const langs: AvailableLocales[] = ['en', 'uk'];
	let selectedLang: AvailableLocales = $locale;
	let isOpen = false;

	function toggleDropdown() {
		isOpen = !isOpen;
	}

	function closeDropdown() {
		isOpen = false;
	}

	// Close on outside click
	let dropdownRef: HTMLElement;
	onMount(() => {
		const handleClickOutside = (event: MouseEvent) => {
			if (dropdownRef && !dropdownRef.contains(event.target as Node)) {
				closeDropdown();
			}
		};
		document.addEventListener('click', handleClickOutside);
		return () => document.removeEventListener('click', handleClickOutside);
	});
</script>

<div class="relative w-full sm:max-w-[200px]" bind:this={dropdownRef}>
	<button
		class="inline-flex w-full justify-between items-center gap-2 rounded-xl border border-zinc-300 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-800 dark:text-white hover:bg-zinc-50 dark:hover:bg-zinc-900/50 shadow-sm transition"
		on:click={toggleDropdown}
		aria-haspopup="true"
		aria-expanded={isOpen}
	>
		<span>{$t(`global.lang.${selectedLang}`)}</span>
		<Icon src={ChevronUpDown} class="w-5 h-5" />
	</button>

	{#if isOpen}
		<div
			class="absolute left-0 bottom-full mb-2 w-full rounded-xl py-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 shadow-xl transition-all duration-200 animate-fadeIn z-50"
		>
			{#each langs as lang}
				<a
					on:click={() => {
						localStorage.setItem('lang', lang);
						closeDropdown();
					}}
					href={switchLocalePath($locale, lang, $page.url.pathname)}
					class="flex items-center justify-between px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
					data-sveltekit-reload
					data-sveltekit-preload-data="off"
				>
					<span>{$t(`global.lang.${lang}`)}</span>
					{#if lang === selectedLang}
						<Icon src={Check} class="w-4 h-4 text-amber-500 stroke-2" />
					{/if}
				</a>
			{/each}
		</div>
	{/if}
</div>

<style>
	@keyframes fadeIn {
		from {
			opacity: 0;
			transform: translateY(6px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	.animate-fadeIn {
		animation: fadeIn 0.15s ease-out;
	}
</style>
