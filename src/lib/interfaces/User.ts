import type {Image} from "$lib/interfaces/Image";

export interface UserPreview {
    id: bigint;
    username: string;
    avatar: Image;
    name: string;
}

export interface User extends UserPreview {

}