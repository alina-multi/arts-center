<script>
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import SelectInput from '$lib/components/input/SelectInput.svelte';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import TextInput from '$lib/components/input/TextInput.svelte';
	import { getContext, onDestroy } from 'svelte';
	import { fade } from 'svelte/transition';
	import ButtonsGroup from './ButtonsGroup.svelte';

	const t = getContext('t');
	export let form;
	export let categories;
	export let work;

	let showMessage = false;
	let messageTimeout;

	$: if (form?.message) {
		showMessage = true;

		if (messageTimeout) {
			clearTimeout(messageTimeout);
		}

		messageTimeout = setTimeout(() => {
			showMessage = false;
		}, 3000);
	}

	onDestroy(() => {
		if (messageTimeout) {
			clearTimeout(messageTimeout);
		}
	});

	function tagToOption({ title, id }) {
		return {
			label: title,
			value: id?.toString()
		};
	}

	$: if (form?.work) {
		validTitles = form.work;
	}

	let categoryOptions = categories.map(tagToOption);

	// Custom tab functionality
	let activeTabIndex = 0;
	$: validTitles = (work?.titles || []).filter((title) => title && title.language);
</script>

<FormGroup h1={$t('my.add_work_page.main_info')}>
	{#if showMessage && form?.success && form?.message}
		<p class="text-green-600" transition:fade={{ duration: 300 }}>{form?.message}</p>
	{:else if showMessage && form?.message}
		<p class="text-red-600" transition:fade={{ duration: 300 }}>{form?.message}</p>
	{/if}
	<InputGroup label={$t('my.add_work_page.category')} error={form?.errors?.category}>
		<SelectInput
			required
			options={categoryOptions}
			value={work.category}
			name="category"
			maxSelect={3}
			placeholder=""
		/>
	</InputGroup>

	<!-- Custom Tab Implementation -->
	<div>
		{#if validTitles.length > 1}
			<div class="flex border-b border-gray-200 mb-4">
				{#each validTitles as title, index}
					<button
						type="button"
						class="bg-transparent border-0 px-4 py-3 cursor-pointer border-b-2 border-transparent transition-all duration-200 font-medium hover:text-gray-700 hover:bg-gray-50 {activeTabIndex ===
						index
							? 'text-zinc-900 border-blue-600'
							: 'text-zinc-500'}"
						on:click={() => (activeTabIndex = index)}
					>
						{title.language}
					</button>
				{/each}
			</div>
		{/if}

		<div>
			{#each validTitles as title, i}
				<div class={activeTabIndex === i ? 'block' : 'hidden'}>
					<div class="py-4">
						<div class="space-y-3">
							<InputGroup
								error={form?.errors?.[`titles.${i}.title`]}
								label={$t('my.add_work_page.title')}
							>
								<TextInput
									name={`titles.${i}.title`}
									value={title.title || ''}
									id={`titles.${i}.title`}
									class=""
								/>
							</InputGroup>
							<InputGroup
								error={form?.errors?.[`titles.${i}.description`]}
								label={$t('my.add_work_page.description')}
							>
								<TextAreaInput
									name={`titles.${i}.description`}
									value={title.description || ''}
									rows={8}
								/>
							</InputGroup>
							<input type="hidden" name={`titles.${i}.language`} value={title.language || ''} />
						</div>
					</div>
				</div>
			{/each}
		</div>
	</div>
	<slot>
		<ButtonsGroup />
	</slot>
</FormGroup>
