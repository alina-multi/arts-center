import type { WorkPage } from '$lib/interfaces/Work';
import type { works, work_blocks, work_details, work_titles, users } from '@prisma/client';
import type { WorkBlock } from "$lib/interfaces/Work";
import { ownersMap } from "./owners";

interface worksWithRelations extends works {
  blocks: work_blocks[];
  titles: work_titles[];
  details: work_details;
  owners: users[];
}
export function workMap(data:worksWithRelations):WorkPage {
  return {
    ...data,
    blocks: blocksMap(data.blocks),
    owners: ownersMap(data.owners),
  }
}

function blocksMap(blocks:work_blocks[]):WorkBlock[] {
  if (!blocks) return []
  return blocks.map((row ) => {
    return {
      id: row.id,
      language: row.language,
      type: row.type,
      data: JSON.parse(row.data)
    }
  })
}