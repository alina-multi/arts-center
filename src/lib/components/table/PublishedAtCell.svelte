<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { CheckCircle, XCircle } from '@steeze-ui/heroicons';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';

	export let published_at: Date;
</script>

{#if published_at}
	<Icon src={CheckCircle} theme="solid" class="h-5 w-5 inline text-green-500" />
	<LocaleDate date={published_at} />
{:else}
	<Icon src={XCircle} theme="solid" class="h-5 w-5 inline text-orange-500" />
{/if}
