<script lang='ts'>
	import type { PageData } from './$types';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { t, locale } from '$lib/translations';
	import FilteredTable from '$lib/components/table/FilteredTable.svelte';
	import Hint from '$lib/components/atoms/Hint.svelte';
	import {user} from '$lib/stores/auth';

	export let data: PageData;
	let total = 0;
	$: total = data?.transactions?.reduce((accumulator, row) => {
		return accumulator + row.amount_net;
	}, 0);


	const columns = [
		{
			title: 'id',
			field: 'id'
		},
		{
			title: $t('my.transactions.amount'),
			valueFn(row) {
				let dollars = (row.amount_net / 100).toFixed(2);
				return `${dollars}$`;
			}
		},
		{
			title: $t('my.transactions.type'),
			valueFn(row) {
				return $t('my.transactions.types.' + row.type);
			}
		},
		{
			title: $t('my.transactions.message'),
			field: 'message'
		},
		{
			title: $t('my.transactions.date'),
			valueFn(row): string {
				return row.created_at.toLocaleString(locale.get());
			}
		}
	];
</script>

<HeaderLayout title={$t('my.transactions.header')}>
	<div slot='details' class='flex gap-3 items-center leading-3'>
		<div class='h-1 w-1 bg-gray-500 dark:bg-zinc-300 rounded-full' />
		<span>
			{$t('my.transactions.balance', { 'total': (total / 100).toFixed(2) })}
		</span>
	</div>
</HeaderLayout>
<Hint type='info'>
	{$t('my.transactions.commissions_and_payout')}
</Hint>
{#if !$user.verified_at}
	<Hint type='warning'>
		{$t('my.transactions.need_verification')}
	</Hint>
{/if}

<FilteredTable {columns} data={data.transactions}>

</FilteredTable>

