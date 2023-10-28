<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { XMark } from '@steeze-ui/heroicons';
	import TubeIcon from './TubeIcon.svelte';
	import { localePath, t } from '$lib/translations';
	import type { User } from '$lib/interfaces/User';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import newUniqueId from 'locally-unique-id-generator';
	import { tick } from 'svelte';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { getStripe } from '$lib/helpers/stripe';

	export let user: User;
	let open = false, quantity = 1;

	let id;

	let stripeCheckout;

	async function checkout() {
		open = true;
		id = newUniqueId();
		await tick();
		try {
			const { clientSecret } = await magicFetch('POST', localePath('/api/checkout'), {
				user_id: user.id.toString(),
				username: user.username,
				type: 1, // Donation
				quantity
			});
			const stripe = await getStripe();
			stripeCheckout = await stripe.initEmbeddedCheckout({
				clientSecret
			});
			stripeCheckout.mount(`#${id}`);
			gtag('event', 'donate_modal_opened', {
				quantity,
				username: user.username
			});
		} catch (e) {
			open = false;
			await tick();
			onClose();
			throw e;
		}
	}

	function onClose() {
		if (stripeCheckout) {
			stripeCheckout.destroy();
		}
	}
	
	const options = [1, 3, 5];
	let invalidChars = ['-', '+', 'e'];
	$: value = quantity === 1 ? '' : quantity;
	$: disabled = quantity === 0;
</script>

<div
	class="px-6 w-full xs:px-9 sm:w-3/4 md:px-6 sm:max-md:mx-auto md:w-1/2 py-6 xl:w-full border rounded-sm shadow bg-gray-50 dark:bg-gray-800 dark:border-gray-700"
>
	<div class=" space-y-6">
		<div class="text-lg font-semibold text-center">{$t('global.donation.title')}</div>
		<div class=" flex items-center justify-between sm:justify-around sm:max-md:gap-6">
			<TubeIcon />

			<Icon src={XMark} class="w-6  text-gray-600  dark:text-white" />

			<fieldset class=" font-semibold flex gap-4 xs:gap-6 md:gap-3 items-center text-[16px]">
				{#each options as option (option)}
					<div class="flex relative">
						<input
							on:focus={() => {
								(value = quantity);
							}}
							bind:group={quantity}
							id="price-{option}"
							type="radio"
							value={option}
							name="price-{option}"
							class="absolute peer opacity-0  "
						/>
						<label
							for="price-{option}"
							class="py-2 px-4 rounded-full shadow flex cursor-pointer border border-amber-500  peer-checked:hover:border-amber-500 hover:border-amber-600 justify-center items-center peer-checked:bg-amber-500 peer-checked:text-white "
							>{option}</label
						>
					</div>
				{/each}

				<input
					min="1"
					max="5000"
					bind:value
					on:input={() => {
						quantity = value;
					}}
					on:keydown={(e) => {
						if (invalidChars.includes(e.key)) {
							e.preventDefault();
						}
					}}
					type="number"
					name="price-custom"
					id="price-custom"
					class="block text-center shadow py-2 px-1 rounded-sm border-0 text-gray-900 dark:text-white hover:ring-amber-600 dark:hover:ring-amber-600 dark:focus:ring-amber-600 dark:focus:bg-gray-500 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 dark:bg-gray-600 dark:placeholder:text-gray-200 dark:ring-gray-500  focus:ring-inset focus:ring-1 focus:ring-gray-600"
					placeholder="10"
				/>
			</fieldset>
		</div>

		<button
			on:click={checkout}
			{disabled}
			class="{disabled
				? 'bg-gray-400 dark:bg-zinc-500 dark:text-zinc-700 cursor-not-allowed '
				: 'bg-gray-600  cursor-pointer  hover:scale-[1.02] transform transition-transform'}  text-white w-full rounded-sm text-[16px] font-semibold py-2 shadow flex items-center justify-center gap-3 mb-3 "
		>
			<span>{$t('global.donation.support')}</span>
			<span>{quantity * 5} €</span>
		</button>
	</div>
</div>

<ModalWindow bind:open={open} on:close={onClose}>
	<div {id} />
</ModalWindow>
