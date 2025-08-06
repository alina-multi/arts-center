<script lang="ts">
	import type { ActionData } from './$types';
	import Logo from '$lib/components/atoms/Logo.svelte';
	import EmailInput from '$lib/components/input/EmailInput.svelte';
	import PasswordInput from '$lib/components/input/PasswordInput.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import CheckBox from '$lib/components/input/CheckBox.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import SocialMediaButtons from '$lib/components/atoms/buttons/SocialMediaButtons.svelte';
	import Divider from '$lib/components/atoms/Divider.svelte';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';
	import { showAuthModal } from '$lib/stores/auth';
	import { deserialize } from '$app/forms';
	import { checkAuth } from '$lib/stores/auth';
	import { enhance } from '$app/forms';
	import { goto } from '$app/navigation';

	const t = getContext('t');
	const locale = getContext('locale');

	export let form: ActionData | undefined;

	async function onSubmit({ formData, cancel }) {
		if ($showAuthModal) {
			cancel();

			const response = await fetch('/login', {
				method: 'POST',
				body: formData
			});
			const result = deserialize(await response.text());
			form = result?.data;

			if (result.type === 'redirect') {
				checkAuth();
				showAuthModal.set(false);
			}
		}

		return async ({ result }) => {
			form = result.data;
			if (result.type === 'redirect') {
				goto(result.location);
			}
		};
	}
</script>

<div class="flex min-h-full flex-col pt-12 sm:px-6 lg:px-8 bg:white sm:bg-gray-50 dark:bg-black">
	<div class="sm:mx-auto sm:w-full sm:max-w-md">
		<div class="flex items-center justify-center">
			<Logo size="w-64 h-28" />
		</div>

		<h2
			class="my-3 sm:my-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-black dark:text-white"
		>
			{$t('global.login.page_title')}
		</h2>
	</div>

	<div class=" sm:mx-auto sm:w-full sm:max-w-md">
		<div class="bg-white dark:bg-zinc-900 px-3 py-6 sm:p-9 sm:shadow rounded-sm">
			<form class="space-y-6" method="POST" use:enhance={onSubmit}>
				{#if form?.message}
					<p class="text-red-600">{form?.message}</p>
				{/if}
				<InputGroup
					label={$t('global.login.email')}
					error={form?.errors?.email}
					let:elementId={id}
					let:hasError={error}
				>
					<EmailInput name="email" value={form?.email} {id} {error} />
				</InputGroup>
				<InputGroup
					label={$t('global.login.password')}
					error={form?.errors?.password}
					let:elementId={id}
					let:hasError={error}
				>
					<PasswordInput name="password" {id} {error} />
				</InputGroup>

				<div class="flex items-center justify-between">
					<CheckBox name="remember-me">{$t('global.login.remember_me')}</CheckBox>

					<div class="text-sm">
						<a
							href={localePath($locale, '/forgot-password')}
							class="font-medium text-gray-400 hover:underline hover:text-gray-500 dark:hover:text-zinc-300 dark:text-zinc-500"
							>{$t('global.login.forgot_password')}</a
						>
					</div>
				</div>

				<ActionButton class="bg-blue-600 w-full rounded-sm hover:bg-blue-500"
					>{$t('global.login.sign_in')}</ActionButton
				>
			</form>
			<a
				href={localePath($locale, '/register')}
				class="block mt-3 text-center bg-amber-500 rounded-sm hover:bg-amber-400 px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
				>{$t('global.buttons.register')}</a
			>

			<div class="mt-6"><Divider>{$t('global.common.continue_with')}</Divider></div>
			<div class="mt-6">
				<SocialMediaButtons />
			</div>
		</div>
	</div>
</div>
