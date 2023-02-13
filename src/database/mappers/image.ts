import type {Image} from "$lib/interfaces/Image";
import type {images} from "@prisma/client";

export function imageMap(image: images | null): Image | null {
    if (image === null) return null
    return {
        src: 'https://via.placeholder.com/300',
        srcset: 'https://via.placeholder.com/300 300w, https://via.placeholder.com/600 600w',
    }
}