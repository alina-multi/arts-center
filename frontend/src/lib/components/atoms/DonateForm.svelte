<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { XMark } from '@steeze-ui/heroicons';
	import DonateIcon from './DonateIcon.svelte';
	import { localePath } from '$lib/translations';
	import type { UserBasic } from '$lib/interfaces/User';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import newUniqueId from 'locally-unique-id-generator';
	import { getContext, tick } from 'svelte';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { getStripe } from '$lib/helpers/stripe';

	const t = getContext('t');
	const locale = getContext('locale');
	export let user: UserBasic;
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

	const options = [1, 3, 5];
	let invalidChars = ['-', '+', 'e'];
	$: value = quantity === 1 ? '' : quantity;
	$: disabled = quantity === 0;
</script>

<div class=" shadow p-6 xs:p-9 bg-zinc-100 dark:bg-zinc-800 dark:border-zinc-700">
	<div class="text-center space-y-6">
		<div class="text-xl font-semibold dark:text-white">
			<h3>{$t('global.donation.title1')}</h3>
			<h4>{$t('global.donation.title2')}</h4>
		</div>
		<p>
			{$t('global.donation.p1')}
		</p>

		<div
			class=" flex items-center justify-between sm:justify-center sm:gap-6 sm:w-full xl:justify-around"
		>
			<DonateIcon />

			<Icon src={XMark} class="w-6 h-6  dark:text-white" />

			<fieldset class=" gap-6 flex xl:justify-around text-[16px] font-semibold">
				{#each options as option (option)}
					<div class="flex relative max-sm:last-of-type:hidden xl:last-of-type:hidden">
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
							class="py-2 px-4 rounded-full dark:bg-zinc-600 dark:border-zinc-500 flex cursor-pointer border border-zinc-900 peer-checked:hover:border-amber-500 hover:border-amber-600 justify-center items-center peer-checked:bg-amber-500 peer-checked:border-amber-500 peer-checked:text-white"
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
					class="block text-center py-2 px-1 border-0 text-zinc-900 dark:text-white hover:ring-amber-600 dark:hover:ring-amber-600 dark:focus:ring-amber-600 dark:focus:bg-zinc-500 ring-1 ring-inset ring-zinc-200 placeholder:text-zinc-400 dark:bg-zinc-600 dark:placeholder:text-zinc-200 dark:ring-zinc-500 focus:ring-inset focus:ring-1 focus:ring-zinc-600"
					placeholder="10"
				/>
			</fieldset>
		</div>
		<p>
			<b>{$t('global.donation.be_patron')}</b>, {$t('global.donation.p2')}
		</p>
		<div class="w-full xl:px-6">
			<button
				on:click={checkout}
				{disabled}
				class="{disabled
					? 'bg-zinc-400 dark:bg-zinc-500 dark:text-zinc-700 cursor-not-allowed '
					: 'bg-zinc-800  cursor-pointer  hover:scale-[1.02] transform transition-transform'}  sm:max-lg:w-2/3 lg:max-xl:w-1/2 text-white w-full text-lg font-semibold py-3 gap-3 mb-3"
			>
				<span>{$t('global.donation.support')}</span>
				<span>{quantity * 5} €</span>
			</button>
		</div>
		<p>
			{$t('global.donation.p3')}
		</p>
	</div>
</div>

<ModalWindow
	bind:open
	on:close={onClose}
	class="md:w-[70%] md:mx-auto rounded-[12px]  mx-6 my-6 sm:my-20 sm:mx-20 "
>
	<div class="xl:py-12 xl:bg-zinc-900 rounded-[12px] overflow-hidden" {id} />
</ModalWindow>
