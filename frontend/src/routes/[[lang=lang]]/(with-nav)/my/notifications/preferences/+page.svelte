<script lang="ts">
	import FilteredTable from '$lib/components/table/FilteredTable.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';

	export let data;

	const columns = [
		{
			title: 'Name',
			field: 'field'
		},
		{
			title: 'Email',
			valueFn: (row) => {
				return `<input type="checkbox" class="form-checkbox" name="${row.type}_1" ${
					row.channels.includes(1) ? 'checked' : ''
				}>`;
			}
		},
		{
			title: 'Web',
			valueFn: (row) => {
				return `<input type="checkbox" class="form-checkbox" name="${row.type}_2" ${
					row.channels.includes(2) ? 'checked' : ''
				}>`;
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
