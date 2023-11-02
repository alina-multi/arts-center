<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import EmailInput from '$lib/components/input/EmailInput.svelte';
	import PasswordInput from '$lib/components/input/PasswordInput.svelte';
	import TextInput from '$lib/components/input/TextInput.svelte';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import { availableLocales } from '$lib/translations';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import ButtonsGroup from '$lib/components/forms/ButtonsGroup.svelte';
	import { t } from '$lib/translations';
	import { MultiSelect } from 'svelte-multiselect';
	import countryList from 'country-list';
	import { onMount } from 'svelte';

	export let data: PageData;
	export let form: ActionData;

	let profile = {
		...data.profile.data,
		...(form?.data ?? {})
	};

	const countries = countryList.getData();

	const initialCountry = countries.find((country) => country.code === profile.country);

	let selected = [countryToOption(initialCountry)];

	$: hiddenValue = selected.map(({ value }) => value).join(',');

	let multiselectProps = {
		outerDivClass: 'rounded-sm border sm:text-sm h-10',
		ulSelectedClass: 'h-8',
		liSelectedClass: 'bg-amber-500',
		options: countries.map(countryToOption),
		maxSelect: 1,
		required: true,
		placeholder: 'Select Country'
	};

	function countryToOption(option) {
		return {
			label: option.name,
			value: option.code
		};
	}

	let isDark = false;
	onMount(() => {
		if (typeof window !== 'undefined') {
			isDark = document.documentElement.classList.contains('dark');
		}
	});
</script>

<form method="post" enctype="multipart/form-data" class="space-y-3">
	<FormGroup h1={$t('my.edit_page.personal_info')} h2={$t('my.edit_page.warning_personal_info')}>
		<InputGroup
			label={$t('my.edit_page.full_name')}
			error={form?.errors?.email}
			let:elementId={id}
			let:hasError={error}
		>
			<TextInput name="name" value={profile.name} {id} {error} />
		</InputGroup>

		<div class="col-span-full">
			<h3 class="font-semibold">{$t('my.edit_page.biography')}</h3>
			<p class=" text-sm text-gray-600 py-1 dark:text-zinc-400">
				{$t('my.edit_page.bio_tip')}
			</p>
			<div class=" space-y-6">
				{#each availableLocales as locale}
					<div class="col">
						<InputGroup label={locale} let:elementId={id}>
							<TextAreaInput
								{id}
								name="bios[{locale}]"
								value={profile?.bios?.[locale] ?? ''}
								rows={6}
							/>
						</InputGroup>
					</div>
				{/each}
			</div>
		</div>

		<InputGroup label={$t('my.edit_page.country')} error={form?.errors?.country}>
			<div class="border border-gray-300 rounded-sm dark:bg-zinc-900 dark:border-zinc-700">
				<MultiSelect
					bind:selected
					{...multiselectProps}
					--sms-options-bg={isDark ? 'gray' : 'white'}
					--sms-border={'transparent '}
					--sms-bg={isDark ? ' ' : ''}
					--sms-options-padding={'18px'}
				/>
			</div>

			<input type="hidden" name="country" value={hiddenValue} />
		</InputGroup>

		<!-- <InputGroup
			label={$t('my.edit_page.country')}
			error={form?.errors?.country}
			let:elementId={id}
			let:hasError={error}
		>
			<TextInput {id} {error} name="country" value={profile.country} />
		</InputGroup> -->
	</FormGroup>

	<FormGroup h1={$t('my.edit_page.login_info')}>
		<InputGroup
			label={$t('my.edit_page.email')}
			error={form?.errors?.email}
			let:elementId={id}
			let:hasError={error}
		>
			{#if !profile?.email_verified_at}
				<p class="mt-1 text-sm leading-6 text-gray-600">
					{$t('my.edit_page.email_awaiting_confirmation')}
				</p>
			{/if}
			<EmailInput {id} {error} name="email" value={profile.email} />
		</InputGroup>

		<InputGroup
			label={$t('my.edit_page.current_password')}
			error={form?.errors?.current_password}
			let:elementId={id}
			let:hasError={error}
		>
			<PasswordInput {id} {error} name="current_password" autocomplete="off" />
		</InputGroup>

		<InputGroup
			label={$t('my.edit_page.new_password')}
			error={form?.errors?.password}
			let:elementId={id}
			let:hasError={error}
		>
			<PasswordInput {id} {error} name="password" autocomplete="off" />
		</InputGroup>

		<InputGroup label={$t('my.edit_page.confirm_password')} let:elementId={id}>
			<PasswordInput {id} name="password_confirmation" autocomplete="off" />
		</InputGroup>
	</FormGroup>
	<slot><ButtonsGroup /></slot>
</form>
