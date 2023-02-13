import type {Image} from "$lib/interfaces/Image";

export interface UserPreview {
    id: bigint;
    username: string;
    avatar: Image | null;
    name: string;
}

export interface User extends UserPreview {

}