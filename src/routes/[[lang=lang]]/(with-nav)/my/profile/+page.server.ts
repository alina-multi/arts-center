import type { PageServerLoad } from "./$types";
import { api } from "$lib/server/api";

export const load = (async (event) => {
  return {
    profile: await api({
      method: "GET",
      path: "/api2/profile",
      event
    }).then(async (response) => await response.json())
  };
}) satisfies PageServerLoad;