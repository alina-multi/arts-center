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
	import countryList from 'country-list';
	import SelectInput from '$lib/components/input/SelectInput.svelte';
	import ResendEmailVerification from '$lib/components/my/ResendEmailVerification.svelte';

	export let data: PageData;
	export let form: ActionData;

	let profile = {
		...data.profile.data,
		...(form?.data ?? {})
	};

	let countryOptions = countryList.getData().map(countryToOption);

	function countryToOption(option) {
		return {
			label: option.name,
			value: option.code
		};
	}
</script>

<form method="post" enctype="multipart/form-data" class="space-y-3">
	<FormGroup h1={$t('my.edit_page.personal_info')} h2={$t('my.edit_page.warning_personal_info')}>
		<InputGroup
			label={$t('my.edit_page.full_name')}
			error={form?.errors?.name}
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
			<SelectInput
				required
				options={countryOptions}
				value={[profile.country]}
				name="country"
				maxSelect={1}
				placeholder="Select Country"
			/>
		</InputGroup>
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
					<ResendEmailVerification/>
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
