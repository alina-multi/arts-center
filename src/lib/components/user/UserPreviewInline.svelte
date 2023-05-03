<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import type { User } from '$lib/interfaces/User';

	export let user: User;
</script>

<div
	class="group inline-flex items-center gap-3 text-gray-600 hover:text-gray-500 dark:hover:text-gray-400 dark:text-gray-300"
>
	<Avatar {user} withName={true} />
</div>
