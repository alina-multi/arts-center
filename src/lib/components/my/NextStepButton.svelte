<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowRight } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let href;
</script>

<a
	{href}
	class="block text-center bg-emerald-500 hover:bg-emerald-400 focus-visible:outline-green-600 rounded-sm px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
>
	{$t('my.buttons.next')}
	<Icon src={ArrowRight} class="w-4 h-4 inline-block" />
</a>
