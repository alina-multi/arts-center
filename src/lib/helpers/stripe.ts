import type { Stripe } from '@stripe/stripe-js';
import { loadStripe } from '@stripe/stripe-js';
import { env } from '$env/dynamic/public';
let stripeClient: Stripe;

export async function getStripe(): Promise<Stripe> {
	if (!stripeClient) {
		stripeClient = (await loadStripe(env.PUBLIC_STIPE)) as Stripe;
	}
	return stripeClient;
}
