<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { CheckBadge } from '@steeze-ui/heroicons';
	export let user_verified,
		size = 'w-5 h-5';
</script>

{#if user_verified}
	<Icon src={CheckBadge} theme="solid" class=" fill-emerald-500 {size}" />
{/if}
