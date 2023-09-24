<script lang="ts">
	import ModalWindow from './ModalWindow.svelte';
	import ButtonsGroup from '../forms/ButtonsGroup.svelte';
	import ActionButton from '../forms/ActionButton.svelte';
	import CancelButton from '../forms/CancelButton.svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import { page } from '$app/stores';
	import toast from 'svelte-french-toast';
	import { t } from '$lib/translations';
	import AuthModal from './AuthModal.svelte';

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

	function init(el: HTMLInputElement) {
		el.focus();
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

{#if $page.data.currentUser}
	<ModalWindow bind:open>
		<slot name="header">
			<div class="flex items-center justify-between mb-3">
				<h2 class="text-base font-semibold">{$t('global.report.title')}</h2>
			</div>
		</slot>

		<form on:submit={showInput ? onOtherCategory : onCategory} class="flex flex-col gap-6">
			<div
				class="relative divide-y divide-gray-200 dark:divide-zinc-800 border-b border-t border-gray-200 dark:border- dark:border-zinc-800"
			>
				{#if error && !showInput}
					<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
				{/if}
				{#each categories as category}
					<div class="relative flex items-center justify-between py-3">
						<label
							for={category}
							class="min-w-0 flex-1 text-sm flex gap-3 items-center select-none cursor-pointer"
						>
							{$t(`global.report.${category}`)}
						</label>

						<input
							id={category}
							name={category}
							type="radio"
							value={category}
							checked={checked === category}
							on:change={onChange}
							class="h-4 w-4 border-gray-300 dark:bg-zinc-300 text-blue-600 focus:ring-blue-600 cursor-pointer"
						/>
					</div>
				{/each}
			</div>

			{#if showInput}
				<div class="relative">
					{#if error}
						<span class="text-red-500 text-xs absolute -top-5 left-0">{error}</span>
					{/if}
					<input
						use:init
						on:focus={() => (error = '')}
						type="other"
						name="other"
						id="other"
						bind:value={valueOther}
						placeholder={$t(`global.report.other_placeholder`)}
						class="block w-full pl-3 pr-10 py-2 dark:bg-zinc-700 dark:border-zinc-800 dark:focus:ring-zinc-800 text-base border-zinc-500 dark:focus:border-ring-800 focus:outline-none focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm rounded-sm dark:text-zinc-100 dark:placeholder:text-zinc-500"
					/>
				</div>
			{/if}

			<ButtonsGroup>
				<CancelButton bind:open />
				<ActionButton
					type="submit"
					class={'bg-blue-500 hover:bg-blue-400 focus-visible:outline-blue-600 flex items-center gap-1'}
				>
					{$t('global.buttons.send')}
				</ActionButton>
			</ButtonsGroup>
		</form>
	</ModalWindow>
{:else}
	<AuthModal bind:open type={$t('global.report.title').toLowerCase()} />
{/if}
