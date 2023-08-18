<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Home } from '@steeze-ui/heroicons';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import MyProfileLinksGroup from './MyProfileLinksGroup.svelte';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import LogoutButton from '../atoms/Buttons/LogoutButton.svelte';
	import Dropdown from '../atoms/Dropdown.svelte';
	export let user: User;
</script>

<Dropdown style="-right-[60px]  z-40 w-60  text-sm mt-2" z={30}>
	<slot:fragment slot="button">
		{#if user.photo}
			<div class=" w-10 h-10 bg-zinc-300 dark:bg-gray-800 rounded-full overflow-hidden shadow-sm">
				<Picture photo={user.photo} alt={user?.username} style={'w-10 h-10 object-cover '} />
			</div>
		{:else}
			<Icon
				theme="solid"
				src={User}
				class=" w-10 h-10 bg-gray-50 dark:bg-zinc-800 rounded-full fill-zinc-300 dark:fill-zinc-400  p-[4px] border border-zinc-100 dark:border-zinc-700 shadow-sm"
			/>
		{/if}
	</slot:fragment>

	<slot:fragment slot="panel">
		<ul>
			<SideNavLink href="/{user?.username}"
				><Icon src={Home} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />My Page</SideNavLink
			>
			<MyProfileLinksGroup />

			<li>
				<LogoutButton />
			</li>
		</ul></slot:fragment
	>
</Dropdown>
