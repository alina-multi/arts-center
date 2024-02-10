<script lang="ts">
	import Logo from '$lib/components/atoms/Logo.svelte';
	import type { ActionData } from './$types';
	import { enhance } from '$app/forms';
	import EmailInput from '$lib/components/input/EmailInput.svelte';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let form: ActionData;
</script>

<div class="flex min-h-full flex-col pt-12 sm:px-6 lg:px-8 bg:white sm:bg-gray-50 dark:bg-black">
	<div class="sm:mx-auto sm:w-full sm:max-w-md">
		<div class="flex items-center justify-center">
			<Logo />
		</div>

		<h2
			class=" mt-3 sm:mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-black dark:text-white"
		>
			{$t('global.login.forgot_password')}
		</h2>
	</div>

	<div class="mt-3 sm:mx-auto sm:w-full sm:max-w-md">
		{#if form?.status}
			<div class="bg-white shadow sm:rounded-lg">
				<div class="px-4 py-5 sm:p-6">
					<div class="mt-2 max-w-xl text-sm text-gray-500">
						<p>{form.status}</p>
					</div>
				</div>
			</div>
		{:else}
			<div class="bg-white dark:bg-zinc-900 px-3 py-6 sm:p-9 sm:shadow rounded-lg">
				<form class="space-y-6" method="POST" use:enhance>
					{#if form?.message}
						<p class="text-red-600">{form?.message}</p>
					{/if}
					<InputGroup
						label={$t('global.login.email')}
						error={form?.errors?.email}
						let:elementId={id}
						let:hasError={error}
					>
						<EmailInput name="email" {id} {error} />
					</InputGroup>

					<ActionButton class="bg-blue-600 w-full rounded-sm hover:bg-blue-500"
						>{$t('global.login.recover')}</ActionButton
					>
					<p class="mt-10 text-center text-sm text-gray-500">
						{$t('global.login.lost_email')}
						<a
							href="mailto:info@arts.center"
							class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
							>{$t('global.login.contact_us')}</a
						>
					</p>
				</form>
			</div>
		{/if}
	</div>
</div>
