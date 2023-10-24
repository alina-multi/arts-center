<script lang='ts'>
	import newUniqueId from 'locally-unique-id-generator';
	import { getStripe } from '$lib/helpers/stripe';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import { magicFetch } from '$lib/helpers/fetchData';
	import { tick } from 'svelte';
	import type { User } from '$lib/interfaces/User';
	import { localePath } from '$lib/translations';
	import * as SentrySvelte from '@sentry/svelte';

	export let user: User;
	let clientSecret, open = false, quantity = 10;

	let id;

	let stripeCheckout;

	async function checkout() {
		open = true;
		id = newUniqueId();
		await tick();
		try {
			const { clientSecret } = await magicFetch('POST', localePath('/api/checkout'), {
				user_id: user.id.toString(),
				quantity
			});
			const stripe = await getStripe();
			stripeCheckout = await stripe.initEmbeddedCheckout({
				clientSecret
			});
			stripeCheckout.mount(`#${id}`);
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
</script>
{#if user.verified_at}
	<div class='inline-block border-zinc-100 bg-amber-600 rounded-sm p-3 cursor-pointer' on:click={checkout}>
		Donate something idk :D
	</div>

	<ModalWindow bind:open={open} on:close={onClose}>
		<div {id} />
	</ModalWindow>
{/if}
