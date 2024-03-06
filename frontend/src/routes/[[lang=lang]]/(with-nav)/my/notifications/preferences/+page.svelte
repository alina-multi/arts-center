<script lang="ts">
	import FilteredTable from '$lib/components/table/FilteredTable.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import Switch from '$lib/components/forms/Switch.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Check } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';
	import { createTablePreferencesData } from '$lib/helpers/createNotifPreferData';
	import { enhance } from '$app/forms';
	import toast from 'svelte-french-toast';

	export let data, form;

	const t = getContext('t');
	if (form?.success) toast.success(form.message);

	const columns = [
		{ title: 'Preferences', field: 'field' },
		{
			title: 'Email',
			component: Switch,
			additionalProps: (row) => ({ name: 1, checked: !row.channels.includes(1) })
		},
		{
			title: 'Web',
			component: Switch,
			additionalProps: (row) => ({ name: 2, checked: !row.channels.includes(2) })
		}
	];

	let disableTrigger = false;
	let preferencesList = createTablePreferencesData();

	$: tableData = preferencesList.map((pref) => ({
		...pref,
		field: $t(`my.notifications.${pref.field}`),
		channels: disableTrigger
			? [1, 2]
			: data.preferences.filter((item) => item.type === pref.value).map((item) => item.channel)
	}));
</script>

<form method="POST" use:enhance>
	<fieldset>
		<legend class="w-full">
			<HeaderLayout title={$t('my.notifications.notifications')}>
				<div slot="buttons">
					<button
						on:click|preventDefault={() => (disableTrigger = true)}
						class="flex items-center gap-3 group hover:underline pl-3 transition-all"
					>
						<span class="text-sm">{$t(`global.notifications.mark_all_as_read`)}</span>
						<Icon src={Check} class="w-4 h-4 active:border-green-500" />
					</button>
				</div>
			</HeaderLayout>
		</legend>

		<FilteredTable {columns} data={tableData} keyColumn="value" />

		<div class="text-end mt-6">
			<ActionButton class="bg-zinc-600">Update Preferences</ActionButton>
		</div>
	</fieldset>
</form>
