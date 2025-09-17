<script lang="ts">
	import MyProfileLinksGroup from '$lib/components/nav/MyProfileLinksGroup.svelte';
	import LogoutButton from '$lib/components/atoms/buttons/LogoutButton.svelte';
	import Dropdown from '$lib/components/atoms/Dropdown.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import MyPageLink from '$lib/components/atoms/MyPageLink.svelte';
	import { user } from '$lib/stores/auth';
</script>

<Dropdown style="-right-[60px]  z-40 w-60  text-sm mt-2" z={30}>
	<slot:fragment slot="button">
		<Avatar user={$user} size="h-10 w-10" />
	</slot:fragment>

	<slot:fragment slot="panel">
		<ul>
			{#if $user?.approved_at}
				<MyPageLink href={'/' + $user?.username} />
			{/if}
			<MyProfileLinksGroup user={$user} />
			<li>
				<LogoutButton />
			</li>
		</ul>
	</slot:fragment>
</Dropdown>
