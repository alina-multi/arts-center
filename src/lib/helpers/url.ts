export function slug(text: string) {
	return text
		.toLowerCase()
		.replace(/\s/g, '_')
		.replace(/[^\p{L}_]+/ug,'');
}

export function unslug(text: string) {
	return text.replaceAll('_', ' ');
}
