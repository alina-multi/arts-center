import { get } from "$lib/server/repositories/user";
import { userMap } from "$lib/server/mappers/users";
import { userQuery } from "$lib/server/repositories/gallery";
import { worksPreviewMap } from "$lib/server/mappers/gallery";

export const load = (async ({ params }) => {
  const user = await userMap(await get(params.username))
  const gallery = await worksPreviewMap(await userQuery(user.id))
  return {
    user,
    gallery
  }
})