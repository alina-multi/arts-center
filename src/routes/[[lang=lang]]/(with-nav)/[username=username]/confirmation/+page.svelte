<script lang='ts'>
	import type { PageData } from './';
	import { localePath, t } from '$lib/translations';
	import TagButton from '$lib/components/atoms/buttons/TagButton.svelte';

	export let data: PageData;
</script>
<div class='space-y-5 mt-2'>
	<TagButton title={$t('global.donation.confirmation.back')} href={localePath(`/${data.user.username}`)} />
	<h1 class='mt-3 font-bold text-2xl'>{$t('global.donation.confirmation.title')}</h1>
	<p class='mt-3'>
		{$t('global.donation.confirmation.confirmation', { email: data.customer_details.email })}
	</p>
	<p>
		{$t('global.donation.confirmation.support')}
	</p>
</div>