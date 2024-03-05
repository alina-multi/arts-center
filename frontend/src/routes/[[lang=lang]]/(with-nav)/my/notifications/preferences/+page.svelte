<script lang="ts">
	import FilteredTable from '$lib/components/table/FilteredTable.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import Switch from '$lib/components/forms/Switch.svelte';

	let data = {
		preferences: [
			{ type: 1, channel: 1 },
			{ type: 1, channel: 2 },
			{ type: 20, channel: 1 }
		]
	};

	const columns = [
		{
			title: 'Preferences',
			field: 'field'
		},
		{
			title: 'Email',
			component: Switch,
			additionalProps: (row) => {
				return {
					name: `${row.type}_1`,
					checked: row.channels.includes(1)
				};
			}
		},
		{
			title: 'Web',
			component: Switch,
			additionalProps: (row) => {
				return {
					name: `${row.type}_2`,
					checked: row.channels.includes(2)
				};
			}
		}
	];

	let preferencesList = [
		{ type: 1, field: 'Site News' },
		{ type: 20, field: 'Featured Posts' },
		{ type: 40, field: 'Feedback comments notifications' },
		{ type: 41, field: 'Votes notifications' },
		{ type: 60, field: 'Subscribed posts' },
		{ type: 61, field: 'Subscribed artworks' }
	];

	let tableData = preferencesList.map((pref) => {
		let channels: number[] = [];
		data.preferences.map((item) => {
			if (item.type === pref.type) {
				channels.push(item.channel);
			}
		});
		return {
			...pref,
			channels: channels
		};
	});
	console.log(tableData);
</script>

<form method="POST" class="space-y-6">
	<FilteredTable {columns} data={tableData} keyColumn="type" />

	<div class="text-end">
		<ActionButton class="bg-blue-500 ">Update Preferences</ActionButton>
	</div>
</form>
