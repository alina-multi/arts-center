<script lang="ts">
	import Logo from '$lib/components/atoms/Logo.svelte';
	import { getContext } from 'svelte';
	import RadioButton from '$lib/components/input/RadioButton.svelte';
	import { goto } from '$app/navigation';
	import { enhance } from '$app/forms';

	const intents = ['buy', 'sell', 'explore', 'network'];

	const t = getContext('t');

	let checked = '';

	export let form: { redirect?: string } = {};

	$: if (form?.redirect) {
		goto(form.redirect);
	}
</script>

<div class="text-center min-h-screen py-12 bg:white sm:bg-gray-50 dark:bg-black">
	<Logo size="w-64 h-28" />

	<h1 class=" text-2xl font-medium tracking-wide text-black dark:text-white mt-3 mb-9">
		{$t(`global.intent.title`)}
	</h1>

	<form method="POST" use:enhance class=" space-y-6 sm:mx-auto sm:max-w-3xl lg:max-w-3xl">
		<fieldset class="   max-sm:space-y-4 sm:grid grid-cols-2 gap-6 items-stretch">
			{#each intents as intent (intent)}
				<label
					for={intent}
					class=" max-sm:bg-zinc-50 text-start shadow p-6 bg-white dark:bg-zinc-900 flex flex-col transition-all group lg:hover:scale-105"
				>
					<div class=" font-semibold flex justify-between items-center gap-1 w-full mb-3 pb-3">
						<span>{$t(`global.intent.${intent}.title`).toUpperCase()}</span>

						<RadioButton
							id={intent}
							value={intent}
							name={'intent'}
							checked={checked === intent}
							onChange={(e) => {
								checked = e.target.value;
							}}
						/>
					</div>

					<p class="text-sm text-zinc-600 dark:text-zinc-400">
						{$t(`global.intent.${intent}.description`)}
					</p>
				</label>
			{/each}
		</fieldset>

		<button
			disabled={!checked}
			class=" 
               {!checked
				? 'cursor-not-allowed opacity-75'
				: 'opacity-100 animate-gradient'} w-full lg:w-5/12 py-3 rounded-full text-white font-bold bg-gradient-to-r from-amber-500 via-pink-500 to-orange-400 text-transparent"
		>
			{$t(`global.buttons.continue`)}</button
		>
	</form>
</div>
