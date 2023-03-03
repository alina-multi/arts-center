import type { PageLoad } from "./$types";
import { get } from "$lib/server/repositories/work";
import { workMap } from "$lib/server/mappers/work";

export const load = (async ({ params }) => {
  return Promise.all([
    get(BigInt(params.id))
  ]).then((values) => {
    return {
      work: workMap(values[0])
    };
  });
}) satisfies PageLoad;
