export function formToObject(form: FormData): object {
	const output = {};
	for (const [key, value] of form.entries()) {
		fill(output, key, value);
	}
	return output;
}

function fill(output: object, key: string, value: FormDataEntryValue) {
	const segments = key.split('.');
	let currentObjectDepth: object = output;
	for (let i = 0; i < segments.length; i++) {
		const segment = segments[i];
		const nextSegment = segments[i + 1];
		// If this is last step, just assing the value
		if (!nextSegment) {
			currentObjectDepth[segment] = value;
			return;
		}
		// Create object or array depending on what next segment is
		if (currentObjectDepth[segment] === undefined) {
			if (isNaN(nextSegment)) {
				currentObjectDepth[segment] = {};
			} else {
				currentObjectDepth[segment] = [];
			}
		}
		currentObjectDepth = currentObjectDepth[segment];
	}
}
