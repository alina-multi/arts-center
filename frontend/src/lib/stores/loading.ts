import { writable } from 'svelte/store';
import type { Writable } from 'svelte/store';

const loading: Writable<boolean> = writable(false);
export default loading;
