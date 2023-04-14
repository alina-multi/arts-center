// See https://kit.svelte.dev/docs/types#app
// for information about these interfaces
// and what to do when importing types
import type { User } from "./lib/interfaces/User";

declare namespace App {
	// interface Error {}
	 interface Locals {
     user?: User
   }
	// interface PageData {}
	// interface Platform {}
}
