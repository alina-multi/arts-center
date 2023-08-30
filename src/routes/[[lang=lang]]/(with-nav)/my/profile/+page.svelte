<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import EmailInput from '$lib/components/input/EmailInput.svelte';
	import PasswordInput from '$lib/components/input/PasswordInput.svelte';
	import TextInput from '$lib/components/input/TextInput.svelte';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import { availableLocales } from '$lib/translations';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import AvatarInput from '$lib/components/user/AvatarInput.svelte';
	import ButtonsGroup from '$lib/components/forms/ButtonsGroup.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import {t} from '$lib/translations';

	export let data: PageData;
	export let form: ActionData;
	const profile = data.profile.data;
</script>

<form method="post" enctype="multipart/form-data" class="space-y-3">
	<FormGroup
		h1={$t('my.edit_page.personal_info')}
		h2={$t('my.edit_page.warning_personal_info')}
	>
		<InputGroup error={form?.errors?.avatar} let:elementId={id}>
			<AvatarInput {id} currentAvatar={profile?.photo} />
		</InputGroup>

		<InputGroup
			label={$t('my.edit_page.full_name')}
			error={form?.errors?.email}
			let:elementId={id}
			let:hasError={error}
		>
			<TextInput name="name" value={profile.name} {id} {error} />
		</InputGroup>

		<InputGroup
			label={$t('my.edit_page.username')}
			error={form?.errors?.username}
			let:elementId={id}
		>
			<div
				class=" flex rounded-full shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 dark:bg-zinc-900 dark:ring-0 dark:focus-within:ring-1"
			>
				<span class="flex select-none items-center pl-6 text-gray-500 sm:text-sm">arts.center/</span
				>
				<input
					type="text"
					name="username"
					{id}
					value={profile.username}
					class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 dark:text-white"
					placeholder="janesmith"
				/>
			</div>
		</InputGroup>

		<div class="col-span-full">
			<h3 class="font-semibold">{$t('my.edit_page.biography')}</h3>
			<p class=" text-sm text-gray-600 py-1 dark:text-zinc-400">
				{$t('my.edit_page.bio_tip')}
			</p>
			<div class="grid grid-cols-2 gap-3">
				{#each availableLocales as locale}
					<div class="col">
						<InputGroup
							label={locale}
							error={form?.errors?.country}
							let:elementId={id}
							let:hasError={error}
						>
							<TextAreaInput
								{id}
								{error}
								name="bios[{locale}]"
								value={profile?.bios?.[locale] ?? ''}
							/>
						</InputGroup>
					</div>
				{/each}
			</div>
		</div>

		<InputGroup
			label={$t('my.edit_page.country')}
			error={form?.errors?.country}
			let:elementId={id}
			let:hasError={error}
		>
			<TextInput {id} {error} name="country" value={profile.country} />
		</InputGroup>
	</FormGroup>

	<FormGroup h1={$t('my.edit_page.login_info')}>
		<InputGroup label={$t('my.edit_page.email')} error={form?.errors?.email} let:elementId={id} let:hasError={error}>
			{#if !profile?.email_verified_at}
				<p class="mt-1 text-sm leading-6 text-gray-600">{$t('my.edit_page.email_awaiting_confirmation')}</p>
			{/if}
			<EmailInput {id} {error} name="email" value={profile.email} />
		</InputGroup>

		<InputGroup
			label={$t('my.edit_page.password')}
			error={form?.errors?.password}
			let:elementId={id}
			let:hasError={error}
		>
			<PasswordInput {id} {error} name="password" autocomplete="off" />
		</InputGroup>

		<InputGroup label={$t('my.edit_page.confirm_password')} let:elementId={id}>
			<PasswordInput {id} name="password_confirmation" autocomplete="off" />
		</InputGroup>

		<InputGroup
			label={$t('my.edit_page.current_password')}
			error={form?.errors?.current_password}
			let:elementId={id}
			let:hasError={error}
		>
			<PasswordInput {id} {error} name="current_password" autocomplete="off"  />
		</InputGroup>
	</FormGroup>
	<slot><ButtonsGroup/>
	
	</slot>
</form>
