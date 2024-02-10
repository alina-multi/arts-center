<script lang="ts">
	import type { PageData } from './';
	import { localePath } from '$lib/translations';
	import TagButton from '$lib/components/atoms/buttons/TagButton.svelte';
	import { browser } from '$app/environment';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let data: PageData;

	if (browser) {
		window.gtag('event', 'donate_confirmed', {
			username: data.user.username
		});
	}
</script>

<div class="space-y-5 mt-2">
	<TagButton
		title={$t('global.donation.confirmation.back')}
		href={localePath($locale, `/${data.user.username}`)}
	/>
	<h1 class="mt-3 font-bold text-2xl">{$t('global.donation.confirmation.title')}</h1>
	<p class="mt-3">
		{$t('global.donation.confirmation.confirmation', { email: data.customer_details.email })}
	</p>
	<p>
		{$t('global.donation.confirmation.support')}
	</p>
</div>
