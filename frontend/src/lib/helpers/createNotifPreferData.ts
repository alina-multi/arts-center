export const types = [
	{ siteNews: 1 },
	{ featuredPosts: 20 },
	{ myContentComment: 40 },
	{ myContentVote: 41 },
	{ subscriptionPost: 60 },
	{ subscriptionWork: 61 }
];
export const channels = [1, 2];

export function createFullPreferencesData() {
	const preferences: { type: number; channel: number }[] = [];

	types.forEach((typeObj) => {
		const type = Object.values(typeObj)[0];

		channels.forEach((channel) => {
			preferences.push({ type, channel });
		});
	});

	return preferences;
}

export function createTablePreferencesData() {
	const preferences: { field: string; value: number }[] = types.map((typeObj) => {
		const [field, value] = Object.entries(typeObj)[0];
		return { field, value };
	});

	return preferences;
}
