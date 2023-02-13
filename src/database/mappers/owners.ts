import type {ownables, users} from "@prisma/client";
import type {User} from "$lib/interfaces/User";
import {imageMap} from "./image";


export function ownersMap(owners: {user: users}[]): User[] {
    return owners.map(({user}) => {
        return {
            id: user.id,
            username: user.username,
            name: user.name,
            avatar: imageMap(user.avatar)
        }
    });
}