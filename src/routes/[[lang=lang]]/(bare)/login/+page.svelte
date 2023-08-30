<script lang="ts">
	import Logo from '$lib/components/atoms/Logo.svelte';
	import type { ActionData } from './$types';
	import EmailInput from '$lib/components/input/EmailInput.svelte';
	import PasswordInput from '$lib/components/input/PasswordInput.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import CheckBox from '$lib/components/input/CheckBox.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import Divider from '$lib/components/atoms/Divider.svelte';
	import SocialMediaButtons from '$lib/components/atoms/buttons/SocialMediaButtons.svelte';
	import {t} from '$lib/translations';

	export let form: ActionData;
</script>

<div class="flex min-h-full flex-col pt-12 sm:px-6 lg:px-8 bg:white sm:bg-gray-50 dark:bg-black">
	<div class="sm:mx-auto sm:w-full sm:max-w-md">
		<div class="flex items-center justify-center">
			<Logo />
		</div>

		<h2
			class=" mt-3 sm:mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900 dark:text-white"
		>
			{$t('global.login.page_title')}
		</h2>
	</div>

	<div class="mt-3 sm:mx-auto sm:w-full sm:max-w-md">
		<div class="bg-white dark:bg-zinc-900 px-3 py-6 sm:p-9 sm:shadow rounded-lg">
			<form class="space-y-6" method="POST">
				<InputGroup
					label={$t('global.login.email')}
					error={form?.errors?.email}
					let:elementId={id}
					let:hasError={error}
				>
					<EmailInput name="email" {id} {error} />
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
							href="/forgot-password"
							class="font-medium text-gray-400 hover:underline hover:text-gray-500 dark:hover:text-zinc-300 dark:text-zinc-500"
							>{$t('global.login.forgot_password')}</a
						>
					</div>
				</div>

				<ActionButton class="bg-blue-600 w-full rounded-md hover:bg-blue-500">{$t('global.login.sign_in')}</ActionButton>
			</form>

			<div class="mt-6"><Divider>{$t('global.common.continue_with')}</Divider></div>
				
				<div class="mt-6">
				<SocialMediaButtons />

				
			</div>
		</div>
	</div>
</div>
