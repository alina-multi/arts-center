<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import type { User } from '$lib/interfaces/User';

	export let user: User;
</script>

<AvatarLink {user} withName={true} />
