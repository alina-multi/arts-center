<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle, Star } from '@steeze-ui/heroicons';
	export let work;

	const regionNames = new Intl.DisplayNames(['en'], { type: 'region' });
</script>

<div class="flex items-center ">
	{#each work.owners as user}
		<a href={user.username} class="inline-flex pr-3 ">
			<div class="bg-gray-300 rounded-full">
				{#if user.avatar}
					<img
						src={user.avatar.src}
						alt={user.name}
						class="flex-none h-12 w-12 rounded-full object-cover"
					/>
				{:else}
					<Icon
						src={UserCircle}
						class="h-14 w-14 rounded-full stroke-gray-600 dark:stroke-gray-400"
					/>
				{/if}
			</div>
		</a>

		<div class="flex flex-col gap-1 dark:text-gray-300 text-gray-700  ">
			<div class="flex items-center gap-3 ">
				<a
					href={user.username}
					class=" hover:text-gray-500 dark:hover:text-gray-400 dark:text-gray-300">{user.name}</a
				>

				<butoon
					class="  dark:bg-gray-900 dark:border-sky-700 dark:border rounded-full px-3 py-1 text-xs text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
					>Follow</butoon
				>
			</div>

			<div class="flex gap-2 items-center text-gray-600 dark:text-gray-400 text-sm ">
				<Icon src={Star} theme="solid" class="w-4 h-4 md:w-5 md:h-5 fill-amber-500" />
				<span> 23456</span>

				{#if user.country}
					<div class="w-1 h-1 rounded-full bg-gray-400 " />
					<span>{regionNames.of(user.country)}</span>
				{/if}

				<div class="w-1 h-1 rounded-full bg-gray-400 hidden min-[500px]:block" />
				<span class="hidden min-[500px]:block">Since: 11.10.2022</span>
			</div>
		</div>
	{/each}
</div>
