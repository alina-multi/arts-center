<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Moon, Sun, ComputerDesktop } from '@steeze-ui/heroicons';
	import { onMount } from 'svelte';
	import { browser } from '$app/environment';

	const themes = [
		{ key: 'system', icon: ComputerDesktop, label: 'System theme' },
		{ key: 'light', icon: Sun, label: 'Light theme' },
		{ key: 'dark', icon: Moon, label: 'Dark theme' }
	];

	let theme = null;

	const getStoredTheme = () => localStorage.getItem('theme') || 'system';

	const isDarkTheme = (themeKey) =>
		themeKey === 'dark' ||
		(themeKey === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

	const applyTheme = (themeKey) => {
		if (!browser) return;

		const shouldBeDark = isDarkTheme(themeKey);
		document.documentElement.classList.toggle('dark', shouldBeDark);
		document.body?.classList.toggle('dark', shouldBeDark);
		localStorage.setItem('theme', themeKey);
	};

	const setTheme = (newTheme) => {
		theme = newTheme;
		applyTheme(newTheme);
	};

	onMount(() => {
		theme = getStoredTheme();
		applyTheme(theme);

		// Listen for system theme changes
		const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
		const handleSystemChange = () => {
			if (theme === 'system') applyTheme('system');
		};

		mediaQuery.addEventListener('change', handleSystemChange);
		return () => mediaQuery.removeEventListener('change', handleSystemChange);
	});
</script>

<div class="flex items-center gap-1 p-1 border border-zinc-600 rounded-full">
	{#each themes as { key, icon, label }}
		<button
			type="button"
			class="group h-8 w-8 rounded-full p-1 transition-all duration-200 hover:bg-zinc-700 {theme ===
			key
				? 'bg-zinc-600 shadow'
				: ''}"
			on:click={() => setTheme(key)}
			aria-label="Use {label.toLowerCase()}"
			title={label}
		>
			<Icon src={icon} class="h-full w-full p-0.5 transition-transform group-hover:scale-110" />
		</button>
	{/each}
</div>
