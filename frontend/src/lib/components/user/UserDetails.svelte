<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import Country from '$lib/components/user/UserCountry.svelte';

	export let user: User;
</script>

<div class="flex flex-wrap text-sm gap-1 md:gap-2 items-center">
	<span>@{user?.username}</span>
	<Country {user} />
</div>
