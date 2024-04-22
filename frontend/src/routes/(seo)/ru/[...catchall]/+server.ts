import { redirect } from '@sveltejs/kit';

export async function GET({ url }) {
	redirect(301, url.pathname.replace('/ru', '/uk'));
}
