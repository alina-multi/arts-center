import image_not_found from '$lib/images/image_not_found.svg';
import { browser } from '$app/environment';
import avatar_not_found from '$lib/images/avatar_not_found.svg';

export const handleImgError = (event) => {
	if (browser) {
		event.target.onerror = null;
		event.target.srcset = image_not_found;
		event.target.src = image_not_found;
		event.target.style =
			'object-fit: contain; object-position: center; width: 100%; height: 100%; stroke: #ffffff; fill: black';
	}
};

export const handleAvatarError = (event) => {
	if (browser) {
		event.target.onerror = null;
		event.target.srcset = avatar_not_found;
		event.target.src = avatar_not_found;
		event.target.style = ' object-position: center;';
	}
};
