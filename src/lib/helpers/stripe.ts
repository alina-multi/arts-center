import type { Stripe } from '@stripe/stripe-js';
import { loadStripe } from '@stripe/stripe-js';
import { PUBLIC_STIPE } from '$env/static/public';
let stripeClient: Stripe;

export async function getStripe(): Promise<Stripe> {
	if (!stripeClient) {
		stripeClient = (await loadStripe(PUBLIC_STIPE)) as Stripe;
	}
	return stripeClient;
}
