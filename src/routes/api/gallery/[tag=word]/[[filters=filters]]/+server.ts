import { json } from '@sveltejs/kit';
import type { RouteParams } from './$types'

export function GET(data: RouteParams) {
  return json(data);
}