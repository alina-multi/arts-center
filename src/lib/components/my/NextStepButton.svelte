<script lang='ts'>
	import { t } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowRight } from '@steeze-ui/heroicons';
	export let href;
</script>

<a {href} class="block text-center bg-green-600 hover:bg-green-500 focus-visible:outline-green-600 rounded-sm px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
	{$t('my.buttons.next')}
	<Icon src={ArrowRight} class='w-4 h-4 inline-block'/>
</a>