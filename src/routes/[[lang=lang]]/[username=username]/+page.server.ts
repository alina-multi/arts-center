import { get } from "$lib/server/repositories/user";
import { userMap } from "$lib/server/mappers/users";

export const load = (async ({ params }) => {
  return {
    user: await userMap(await get(params.username))
  };
})