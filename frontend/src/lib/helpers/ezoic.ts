import { browser } from '$app/environment';

/**
 * Refresh all Ezoic ad placements on the page.
 * Call this on SPA navigation to ensure ads are updated for the new page.
 */
export function refreshEzoicAds(): void {
	if (browser && window.ezstandalone?.cmd) {
		window.ezstandalone.cmd.push(function () {
			window.ezstandalone.showAds();
		});
	}
}

/**
 * Show specific ad placements by their IDs.
 * Use this when new content with ads is dynamically loaded.
 */
export function showEzoicAds(...placeholderIds: number[]): void {
	if (browser && window.ezstandalone?.cmd) {
		window.ezstandalone.cmd.push(function () {
			window.ezstandalone.showAds(...placeholderIds);
		});
	}
}

/**
 * Destroy specific ad placements by their IDs.
 * Use this when content with ads is removed from the page.
 */
export function destroyEzoicAds(...placeholderIds: number[]): void {
	if (browser && window.ezstandalone?.cmd) {
		window.ezstandalone.cmd.push(function () {
			window.ezstandalone.destroyPlaceholders(...placeholderIds);
		});
	}
}

/**
 * Destroy all ad placements on the page.
 * Use this before a full content refresh or page transition.
 */
export function destroyAllEzoicAds(): void {
	if (browser && window.ezstandalone?.cmd) {
		window.ezstandalone.cmd.push(function () {
			window.ezstandalone.destroyAll();
		});
	}
}
