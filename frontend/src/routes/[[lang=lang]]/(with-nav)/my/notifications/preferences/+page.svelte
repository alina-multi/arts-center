<script lang="ts">
	import FilteredTable from '$lib/components/table/FilteredTable.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import Switch from '$lib/components/forms/Switch.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { getContext } from 'svelte';
	import { enhance } from '$app/forms';
	import toast from 'svelte-french-toast';
	import { NotificationChannels, NotificationTypes } from '$lib/interfaces/Notification';

	export let data, form;
	const t = getContext('t');
	$: if (form?.success) toast.success($t(`my.notifications_pref.success_updated`));

	const columns = [
		{ title: '', field: 'title' },
		...Array.from(NotificationChannels, ([channel, title]) => ({
			title,
			component: Switch,
			propsFn: (row) => ({
				name: `${row.type}_${channel}`,
				checked: row.channels.includes(channel),
				// This prop flips the logic of checkbox, we actually store opt out in DB but display as opt-in
				flipValue: true
			})
		}))
	];

	$: tableData = Array.from(NotificationTypes, ([type, title]) => ({
		title,
		type,
		// In channels, we would have an array of actually unchecked notification channels ids
		channels:
			data.preferences?.filter((item) => item.type === type)?.map((item) => item.channel) || []
	}));
</script>

<form method="POST" use:enhance>
	<fieldset>
		<legend class="w-full">
			<HeaderLayout title={$t('my.notifications_pref.title')}>
				<!--
todo: make convenience buttons to to toggle all and/or group
<button
					slot="buttons"
					on:click|preventDefault={() => (toggle++)}
					class="flex items-center gap-3 group hover:underline pl-3 transition-all text-zinc-500"
				>
					<span class="text-sm">{$t(`my.notifications_pref.disable`)}</span>
					<Icon
						src={Check}
						class="w-4 h-4 active:border-green-500 border stroke-1 border-zinc-400 "
					/>
				</button>

				-->
			</HeaderLayout>
		</legend>

		<FilteredTable {columns} data={tableData} keyColumn="type" />

		<div class="text-end mt-6">
			<ActionButton class="bg-zinc-600">{$t(`my.notifications_pref.update_btn`)}</ActionButton>
		</div>
	</fieldset>
</form>
