import type { PageServerLoad, Actions } from "./$types";
import { api } from "$lib/server/api";
import { error, redirect } from "@sveltejs/kit";
import { getCategories } from "$lib/server/repositories/tag";
import { tagsMap } from "$lib/server/mappers/tag";


export const load = (async (event) => {
  const [data, categories] = await Promise.all([
    api({
      method: "GET",
      path: `/api2/draft/${event.params.id}`,
      event
    }).then(async (response) => response.json()),
    getCategories().then((categories) => tagsMap(categories))
  ]);
  return {
    ...data,
    categories
  };
}) satisfies PageServerLoad;

export const actions = {
  default: async (event) => {
    const form = await event.request.formData();
  }
} satisfies Actions;