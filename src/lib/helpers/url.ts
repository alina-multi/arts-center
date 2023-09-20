export function slug(text: string) {
	return text
		.toLowerCase()
		.replace(/\s/g, '_')
		.replace(/[^\w-]+/g, '');
}

export function unslug(text: string) {
	return text.replaceAll('_', ' ');
}
