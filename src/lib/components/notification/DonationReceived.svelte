<script lang="ts">
	import type { DonationReceived } from '$lib/interfaces/Notification';
	import { localePath } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { CurrencyDollar } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let notification: DonationReceived;
	let { message, total } = notification;
</script>

<a
	href={localePath($locale, '/my/transactions')}
	class="flex gap-3 items-center text-sm w-full py-3"
>
	<span class="p-1.5 rounded-full bg-amber-500">
		<Icon src={CurrencyDollar} theme="solid" class="w-5 h-5 text-white" />
	</span>
	<div class="flex flex-wrap items-center">
		<span class="mr-1"> {$t(`global.notifications.donation_received`)}: </span>
		<span class="mr-3 font-semibold text-sm">${total}</span>
		{#if message}
			<span class=" mr-1">{$t(`global.notifications.donation_received_message`)}: </span>
			<span>"{message}"</span>
		{/if}
	</div>
</a>
