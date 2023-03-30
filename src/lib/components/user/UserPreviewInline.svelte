<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import type { User } from '$lib/interfaces/User';
	import { localePath } from '$lib/translations';
	$: href = localePath(`/${user.username}`);
	export let user: User;
</script>

<a
	{href}
	class="group inline-flex  text-gray-600 hover:text-gray-500 dark:hover:text-gray-400 dark:text-gray-300"
>
	<div class="inline-flex items-center gap-2">
		<Avatar {...user} />
		<p>{user.name}</p>
	</div>
</a>
