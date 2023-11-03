<script>
	import StyledTabPanel from '$lib/components/layout/StyledTabPanel.svelte';
	import StyledTabList from '$lib/components/layout/StyledTabList.svelte';
	import { Tab, TabGroup, TabList, TabPanels } from '@rgossiaux/svelte-headlessui';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import SelectInput from '$lib/components/input/SelectInput.svelte';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import TextInput from '$lib/components/input/TextInput.svelte';
	import StyledTab from '$lib/components/layout/StyledTab.svelte';
	import ButtonsGroup from './ButtonsGroup.svelte';
	import { t } from '$lib/translations';

	export let form;
	export let categories;
	export let work;
	// To force redraw of form
	let version = 1;
	$: {
		if (form?.work) {
			work = {
				...work,
				...form.work
			};
			version++;
		}
	}

	function tagToOption({ title, id }) {
		return {
			label: title,
			value: id?.toString()
		};
	}

	let categoryOptions = categories.map(tagToOption)
</script>
<FormGroup h1={$t('my.add_work_page.main_info')}>
		{#if form?.message}
			<p class='text-red-600'>{form?.message}</p>
		{/if}
		<InputGroup label={$t('my.add_work_page.category')} error={form?.errors?.category}>
			{#key version}
				<SelectInput
					required
					options={categoryOptions}
					value={work.category}
					name='category'
					maxSelect={3}
				/>
			{/key}
		</InputGroup>

		<TabGroup>
			{#if work?.titles?.length > 1}
				<StyledTabList>
					{#each work.titles as title}
						<StyledTab>
							{title.language}
						</StyledTab>
					{/each}
				</StyledTabList>
				<!-- without this hack with empty element it doesn't draw panels -->
			{:else}
				<TabList class='h-0'>
					<Tab />
				</TabList>
			{/if}
			<TabPanels>
				{#each work.titles as title, i (i)}
					{#key version}
						<StyledTabPanel>
							<div class='space-y-3'>
								<InputGroup error={form?.errors?.[`titles.${i}.title`]} label={$t('my.add_work_page.title')}>
									<TextInput name={`titles.${i}.title`} value={title.title} />
								</InputGroup>
								<InputGroup error={form?.errors?.[`titles.${i}.description`]} label={$t('my.add_work_page.description')}>
									<TextAreaInput name={`titles.${i}.description`} value={title.description} rows={8} />
								</InputGroup>
								<input type='hidden' name={`titles.${i}.language`} value={title.language}>
							</div>
						</StyledTabPanel>
					{/key}
				{/each}
			</TabPanels>
		</TabGroup>
	<slot>
		<ButtonsGroup />
	</slot>
</FormGroup>
