<script lang="ts">
	import { localePath } from '$lib/translations';
	import type { UserBasic } from '$lib/interfaces/User';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import newUniqueId from 'locally-unique-id-generator';
	import { getContext, tick } from 'svelte';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { getStripe } from '$lib/helpers/stripe';

	const t = getContext('t');
	const locale = getContext('locale');
	export let user: UserBasic; // user will be always arts.center
	let open = false,
		quantity = 1;

	let id;

	let stripeCheckout;

	async function checkout() {
		open = true;
		id = newUniqueId();
		await tick();
		try {
			const { clientSecret } = await magicFetch('POST', localePath($locale, '/api/checkout'), {
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
			window.gtag('event', 'donate_modal_opened', {
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

	const options = [1, 3, 5, 10];
	let invalidChars = ['-', '+', 'e'];
	$: value = quantity === 1 ? '' : quantity;
	$: disabled = quantity === 0;
</script>

<div class=" space-y-9">
	<fieldset class="  flex items-center justify-around sm:max-lg:justify-center sm:max-lg:gap-9">
		{#each options as option (option)}
			<div class="flex items-center relative max-sm:last-of-type:hidden">
				<input
					on:focus={() => {
						value = quantity;
					}}
					bind:group={quantity}
					id="price-{option}"
					type="radio"
					value={option}
					name="price-{option}"
					class="absolute peer opacity-0"
				/>
				<label
					for="price-{option}"
					class="h-14 w-14 dark:bg-zinc-600 dark:border-zinc-500 flex cursor-pointer border border-zinc-900 peer-checked:hover:border-amber-500 hover:border-amber-600 justify-center items-center peer-checked:border-amber-600 peer-checked:bg-amber-600 peer-checked:text-white"
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
			class="block text-center bg-zinc-50 h-14 w-14 border border-zinc-400 border-transparent focus:border-amber-600 focus:outline-none text-zinc-900 dark:text-white hover:border-amber-600 dark:hover:ring-amber-600 dark:focus:ring-amber-600 dark:focus:bg-zinc-500 ring-0 focus:ring-0 focus:ring-transparent placeholder:text-zinc-400 dark:bg-zinc-600 dark:placeholder:text-zinc-200 dark:ring-zinc-500"
			placeholder="20"
		/>
	</fieldset>

	<button
		on:click={checkout}
		{disabled}
		class="{disabled
			? 'bg-zinc-400 dark:bg-zinc-500 dark:text-zinc-700 cursor-not-allowed '
			: 'bg-zinc-900 dark:bg-teal-600  cursor-pointer  hover:scale-[1.02] transform transition-transform'}   text-white w-full text-xl font-medium py-4 gap-3 tracking-widest"
	>
		<span>{$t('global.donation.support').toUpperCase()}</span>
		<span>{quantity * 5} €</span>
	</button>
</div>

<ModalWindow
	bind:open
	on:close={onClose}
	class="md:w-[70%] md:mx-auto rounded-[12px]  mx-6 my-6 sm:my-20 sm:mx-20 "
>
	<div class="xl:py-12 xl:bg-zinc-900 rounded-[12px] overflow-hidden" {id} />
</ModalWindow>
