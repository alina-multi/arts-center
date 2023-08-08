<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Calendar, MapPin, Star, UserCircle } from '@steeze-ui/heroicons';
	import type { User } from '$lib/interfaces/User.ts';

	export let user: User;
</script>

<div
	class="flex flex-col justify-center lg:flex-row sm:col-span-2 p-3 sm:p-6 gap-3 sm:gap-6 border border-amber-500 rounded-md shadow-xl"
>
	<div class="flex gap-3 sm:gap-6 items-center sm:items-start">
		<div class="flex items-start w-32 h-32 sm:h-44 sm:w-44 shrink-0">
			<a href="/"
				><img
					class="shadow-lg rounded-full object-cover"
					src={user.avatar.src}
					alt="Avatar: {user.name}"
				/></a
			>
		</div>
		<div class="gap-1 flex flex-col">
			<div
				class="flex flex-wrap sm:flex-nowrap gap-1 sm:gap-3 text-zinc-900 dark:text-zinc-100 items-start text-sm sm:text-base lg:text-lg"
			>
				<a href="/" class="hover:text-zinc-700 dark:hover:text-zinc-300 font-semibold mr-2"
					><h3>{user.name}</h3></a
				>
				<span class="text-xs sm:text-sm lg:text-lg border border-amber-500 rounded-full px-3"
					>Pro</span
				>
			</div>

			<div
				class="text-xs text-zinc-500 dark:text-zinc-300 sm:text-sm md:text-base flex flex-col gap-1"
			>
				{#if user.rating > 0}
					<div class="inline-flex gap-1 items-center">
						<Icon src={Star} class=" h-4 w-4 sm:h-6 sm:w-6 fill-amber-500 stroke-amber-500" />
						<span class="text-zinc-900 dark:text-zinc-300">
							{user.rating.toLocaleString('ru-RU')}</span
						>
					</div>
				{/if}
				<div class="inline-flex gap-1 items-center">
					<Icon
						src={UserCircle}
						class=" h-4 w-4 sm:h-6 sm:w-6 stroke-zinc-500 dark:stroke-zinc-300"
					/>
					<span>{user.username}</span>
				</div>
				{#if user.country}
					<div class="inline-flex gap-1 items-center">
						<Icon
							src={MapPin}
							class=" h-4 w-4 sm:h-6 sm:w-6 stroke-zinc-500 dark:stroke-zinc-300"
						/>
						<span>{user.country}</span>
					</div>
				{/if}

				<div class="inline-flex gap-1 items-center">
					<Icon src={Calendar} class="h-4 w-4 sm:h-6 sm:w-6 stroke-zinc-500 dark:stroke-zinc-300" />
					<span>Since {new Date(user.created_at).getFullYear()}</span>
				</div>
			</div>

			{#if user.tags.length > 0}
				<div
					class="text-zinc-900 dark:text-zinc-300 hidden flex-wrap gap-2 text-xs sm:flex md:text-sm mt-2 grow-0"
				>
					{#each user.tags as tag (tag.id)}
						<a
							href={tag.url}
							class=" rounded-full border border-zinc-300 px-3 py-1 shadow-sm hover:border-amber-500 hover:text-zinc-100"
							>{tag.name}
							<span class="ml-1">+{tag.rating}</span>
						</a>
					{/each}
				</div>
			{/if}
		</div>
	</div>

	<!----- Work List ----->
	<div class="flex justify-center lg:w-1/2 max-w-3xl flex-col shrink-0">
		<div class="flex gap-3">
			{#each user.works as work}
				<a href="/">
					<img class="rounded-md" src={work.image.url} alt="{name} work: {work.title}" /></a
				>
			{/each}
		</div>
	</div>
</div>
