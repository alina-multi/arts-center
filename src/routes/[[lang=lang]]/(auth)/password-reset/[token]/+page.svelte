<script lang='ts'>
	import Logo from '$lib/components/atoms/Logo.svelte';
	import type { ActionData } from './$types';
	import PasswordInput from '$lib/components/input/PasswordInput.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import { t } from '$lib/translations';

	export let form: ActionData;
</script>

<div class='flex min-h-full flex-col pt-12 sm:px-6 lg:px-8 bg:white sm:bg-gray-50 dark:bg-black'>
	<div class='sm:mx-auto sm:w-full sm:max-w-md'>
		<div class='flex items-center justify-center'>
			<Logo />
		</div>

		<h2
			class=' mt-3 sm:mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900 dark:text-white'
		>
			{$t('global.login.new_password')}
		</h2>
	</div>

	<div class='mt-3 sm:mx-auto sm:w-full sm:max-w-md'>

		<div class='bg-white dark:bg-zinc-900 px-3 py-6 sm:p-9 sm:shadow rounded-lg'>
			<form class='space-y-6' method='POST'>
				{#if form?.message}
					<p class='text-red-600'>{form?.message}</p>
				{/if}
				<InputGroup
					label={$t('global.login.password')}
					error={form?.errors?.password}
					let:elementId={id}
					let:hasError={error}
				>
					<PasswordInput name='password' {id} {error} />
				</InputGroup>
				<InputGroup
					label={$t('global.login.password_confirmation')}
					error={form?.errors?.password_confirmation}
					let:elementId={id}
					let:hasError={error}
				>
					<PasswordInput name='password_confirmation' {id} {error} />
				</InputGroup>

				<ActionButton class='bg-blue-600 w-full rounded-sm hover:bg-blue-500'>{$t('global.buttons.save')}</ActionButton>
			</form>
		</div>
	</div>
</div>
