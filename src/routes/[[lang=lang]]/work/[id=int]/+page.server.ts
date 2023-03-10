import type { PageLoad } from "./$types";
import { get } from "$lib/server/repositories/work";
import { workMap } from "$lib/server/mappers/work";
import { get as getComments } from "$lib/server/repositories/comment";
import { commentsMap } from "$lib/server/mappers/comments";

export const load = (async ({ params }) => {
  return Promise.all([
    get(BigInt(params.id)).then((work) => workMap(work)),
    getComments(BigInt(params.id), 'work').then((comments) => commentsMap(comments))
  ]).then((values) => {
    return {
      work: values[0],
      comments: values[1]
    };
  });
}) satisfies PageLoad;
