import type { PostRaw } from '$lib/interfaces/PostRaw';
import type { Post } from '$lib/interfaces/Post';
import { pictureMap } from '$lib/server/mappers/pictures';
import { ownerMap } from '$lib/server/mappers/owners';

export function postMap(data: PostRaw): Post {
	return {
		...data,
		user: ownerMap(data.user),
		images: new Map(
			data.images
				?.filter((image) => image.image?.variants?.length > 0)
				?.map(({ image }) => [image.id.toString(), pictureMap(image)])
		)
	};
}

export function postsMap(data: PostRaw[]): Post[] {
  return data.map((post) => postMap(post));
}
