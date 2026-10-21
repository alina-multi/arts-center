import { createHmac } from 'node:crypto';
import { useMockData } from '$lib/server/mock/mode';

export function generateSignature(template_id: string) {
	if (useMockData()) {
		return { key: '', signature: '', expires: '', template_id: template_id || '' };
	}
	const utcDateString = (ms: number) => {
		return new Date(ms)
			.toISOString()
			.replace(/-/g, '/')
			.replace(/T/, ' ')
			.replace(/\.\d+Z$/, '+00:00');
	};

	// expire 1 hour from now (this must be milliseconds)
	const expires = utcDateString(Date.now() + 1 * 60 * 60 * 1000);
	const key = process.env.TRANSLOADIT_KEY;
	const authSecret = process.env.TRANSLOADIT_SECRET;

	const params = JSON.stringify({
		auth: {
			key,
			expires
		},
		template_id
		// your other params like template_id, notify_url, etc.
	});
	const signatureBytes = createHmac('sha384', authSecret).update(Buffer.from(params, 'utf-8'));
	// The final signature needs the hash name in front, so
	// the hashing algorithm can be updated in a backwards-compatible
	// way when old algorithms become insecure.
	const signature = `sha384:${signatureBytes.digest('hex')}`;
	return {
		key,
		signature,
		expires,
		template_id
	};
}
