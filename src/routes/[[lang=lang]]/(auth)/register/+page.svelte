<script lang='ts'>
	import Logo from '$lib/components/atoms/Logo.svelte';
	import type { ActionData } from './$types';
	import EmailInput from '$lib/components/input/EmailInput.svelte';
	import PasswordInput from '$lib/components/input/PasswordInput.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import { t } from '$lib/translations';
	import { enhance } from '$app/forms';
	import PrefixedInput from '$lib/components/input/PrefixedInput.svelte';

	export let form: ActionData;
</script>
<div class='flex min-h-full flex-col pt-12 sm:px-6 lg:px-8 bg:white sm:bg-gray-50 dark:bg-black'>
	<div class='sm:mx-auto sm:w-full sm:max-w-md'>
		<div class='flex items-center justify-center'>
			<Logo size='w-64 h-28' />
		</div>

		<h2
			class=' my-3 sm:my-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900 dark:text-white'
		>
			{$t('global.register.page_title')}
		</h2>
	</div>

	<div class=' sm:mx-auto sm:w-full sm:max-w-md'>
		<div class='bg-white dark:bg-zinc-900 px-3 py-6 sm:p-9 sm:shadow rounded-sm'>
			<form class='space-y-6' method='POST' use:enhance>
				{#if form?.message}
					<p class='text-red-600'>{form?.message}</p>
				{/if}
				<InputGroup
					label={$t('global.register.username')}
					error={form?.errors?.username}
					let:elementId={id}
					let:hasError={error}
				>
					<PrefixedInput name='username' value={form?.username} {id} {error}>arts.center/</PrefixedInput>
				</InputGroup>
				<InputGroup
					label={$t('global.login.email')}
					error={form?.errors?.email}
					let:elementId={id}
					let:hasError={error}
				>
					<EmailInput name='email' value={form?.email} {id} {error} />
				</InputGroup>
				<InputGroup
					label={$t('global.login.password')}
					error={form?.errors?.password}
					let:elementId={id}
					let:hasError={error}
				>
					<PasswordInput name='password' {id} {error} />
				</InputGroup>
				<InputGroup
					label={$t('global.register.password_confirmation')}
					error={form?.errors?.password_confirmation}
					let:elementId={id}
					let:hasError={error}
				>
					<PasswordInput name='password_confirmation' {id} {error} />
				</InputGroup>

				<ActionButton
					class='bg-blue-600 w-full rounded-sm hover:bg-blue-500'>{$t('global.login.register')}</ActionButton>
			</form>
		</div>
	</div>
</div>
