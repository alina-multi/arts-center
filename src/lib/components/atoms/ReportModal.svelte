<script lang="ts">
	import { fetchData } from '$lib/helpers/fetchData';
	import { page } from '$app/stores';
	import toast from 'svelte-french-toast';
	import { t } from '$lib/translations';
	import RadioButton from '../input/RadioButton.svelte';
	import TextAreaInput from '../input/TextAreaInput.svelte';
	import ModalWithForm from '../my/ModalWithForm.svelte';


	export let open: boolean, feedbackable_type: string, feedbackable_id: number;

	const categories = [
		'porn',
		'insult',
		'fraud',
		'spam',
		'politics',
		'copyright',
		'violence',
		'other'
	];

	let showInput = false;
	let valueOther = '';
	let error = '';
	$: checked = '';
	let language = $page.params?.lang || 'en';

	function onChange(e) {
		checked = e.target.value;
		if (checked === 'other') {
			showInput = true;
			return;
		}
		showInput = false;
		error = '';
	}

	async function onCategory() {
		const response = await fetchData('POST', '/api/feedback', {
			language,
			type: 'complaint',
			category: checked,
			feedbackable_type,
			feedbackable_id
		});

		const data = await response.json();

		if (!response.ok) {
			error = data.message;
			return;
		}

		toast.success('Report has been sent');
		open = false;
	}

	async function onOtherCategory() {
		valueOther = valueOther.trim();
		if (valueOther === '') {
			error = 'Please describe problem';
			return;
		}

		const response = await fetchData('POST', '/api/feedback', {
			language,
			type: 'complaint',
			category: checked,
			feedbackable_type,
			feedbackable_id,
			body: valueOther
		});
		const data = await response.json();
		if (!response.ok) {
			error = data.message;
			return;
		}

		toast.success('Report has been sent');
		open = false;
	}
</script>



<ModalWithForm
	bind:open
	condition={showInput}
	length={categories.length}
	submitFromList={onCategory}
	submiInput={onOtherCategory}
	not_logged_in_messsage={$t('global.buttons.report').toLowerCase()}
>
	<h2 slot="header" class="text-base font-semibold">{$t('global.report.title')}</h2>
	<svelte:fragment slot="list">
		{#if error && !showInput}
			<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
		{/if}
		{#each categories as category}
			<div class="relative flex items-center justify-between">
				<RadioButton
					id={category}
					value={category}
					label={$t(`global.report.${category}`)}
					name={category}
					checked={checked === category}
					{onChange}
				/>
			</div>
		{/each}
	</svelte:fragment>

	<div slot="showInput" class="relative">
		<TextAreaInput
			id="other"
			name="other"
			bind:value={valueOther}
			placeholder={$t(`global.report.other_placeholder`)}
			bind:error
		/>
	</div>
</ModalWithForm>

