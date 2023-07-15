<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import type { User } from '$lib/interfaces/User';

	export let user: User;
</script>


	<Avatar {user} withName={true} />

