<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { XMark } from '@steeze-ui/heroicons';
	import TubeIcon from './TubeIcon.svelte';
	import {t} from '$lib/translations';

	const options = [1, 3, 5];
	let invalidChars = ['-', '+', 'e'];
	$: selected = 1;
	$: value = selected === 1 ? '' : selected;
	$: disabled = selected === 0;
</script>

<div
	class="px-6 w-full xs:px-9 sm:w-3/4 md:px-6 sm:max-md:mx-auto md:w-1/2 py-6 xl:w-full border rounded-sm shadow bg-gray-50 dark:bg-gray-800 dark:border-gray-700"
>
	<div class=" space-y-6">
		<div class="text-lg font-semibold text-center">{$t('global.donation.title')}</div>
		<div class=" flex items-center justify-between sm:justify-around sm:max-md:gap-6">
			<TubeIcon />

			<Icon src={XMark} class="w-6  text-gray-600 " />

			<fieldset class=" font-semibold flex gap-4 xs:gap-6 md:gap-3 items-center text-[16px]">
				{#each options as option (option)}
					<div class="flex relative">
						<input
							on:focus={() => {
								(value = selected), console.log(value);
							}}
							bind:group={selected}
							id="price-{option}"
							type="radio"
							value={option}
							name="price-{option}"
							class="absolute peer opacity-0 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
						/>
						<label
							for="price-{option}"
							class="py-2 px-4 rounded-full shadow flex cursor-pointer border border-amber-500 justify-center items-center peer-checked:bg-amber-500 peer-checked:text-white"
							>{option}</label
						>
					</div>
				{/each}

				<input
					min="1"
					max="5000"
					bind:value
					on:input={() => {
						selected = value;
					}}
					on:keydown={(e) => {
						if (invalidChars.includes(e.key)) {
							e.preventDefault();
						}
					}}
					type="number"
					name="price-custom"
					id="price-custom"
					class="block text-center shadow py-2 px-1 rounded-sm border-0 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-inset focus:ring-1 focus:ring-gray-300"
					placeholder="10"
				/>
			</fieldset>
		</div>

		<button
			{disabled}
			on:click={() => console.log('hello')}
			class="{disabled
				? 'bg-gray-400 cursor-not-allowed'
				: 'bg-gray-600 cursor-pointer'}  text-white w-full rounded-sm text-[16px] font-semibold py-2 shadow flex items-center justify-center gap-3 mb-3"
		>
			<span>{$t('global.donation.support')}</span>
			<span>{selected * 5} &#36;</span>
		</button>
	</div>
</div>
