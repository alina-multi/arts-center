<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle, Star, MapPin } from '@steeze-ui/heroicons';
	export let name, photo, totalRating, username, country, tags, lastWorks;
</script>

<div
	class="flex flex-col border border-zinc-300 dark:border-zinc-700 gap-3 lg:gap-1 p-3 sm:p-6 rounded-md shadow-sm max-w-2xl "
>
	<div class="flex gap-6">
		<div class="flex items-start w-28 h-28 sm:h-36 sm:w-36 2xl:h-40 2xl:w-40  shrink-0 ">
			<a href="/"
				><img class="shadow-lg rounded-full object-cover" src={photo.url} alt="{name} Avatar" /></a
			>
		</div>
		<div class="gap-2 flex flex-col">
			<div
				class="flex gap-3  text-zinc-900 dark:text-zinc-100 items-start text-sm sm:text-base lg:text-lg "
			>
				<a href="" class="dark:hover:text-zinc-300 hover:text-zinc-700"
					><h3 class="font-semibold">{name}</h3></a
				>
			</div>

			<div
				class="flex flex-col lg:flex-row text-xs text-zinc-500 dark:text-zinc-300 md:text-sm gap-1 lg:gap-2"
			>
				{#if totalRating > 0}
					<div class="inline-flex gap-1 items-center">
						<Icon src={Star} class=" h-5 w-5 stroke-zinc-500 dark:stroke-zinc-300" />
						<span> {totalRating}</span>
					</div>
				{/if}
				<div class="inline-flex gap-1 items-center">
					<Icon src={UserCircle} class=" h-5 w-5 stroke-zinc-500 dark:stroke-zinc-300" />
					<span>{username}</span>
				</div>
				{#if country}
					<div class="inline-flex gap-1 items-center">
						<Icon src={MapPin} class=" h-5 w-5 stroke-zinc-500 dark:stroke-zinc-300" />
						<span>{country}</span>
					</div>
				{/if}
			</div>
			<!----- Work List Desktop----->
			<div class="hidden  mt-2 lg:flex ">
				<div class="flex gap-3 2xl:w-3/4">
					{#each lastWorks as work}
						<a href="#">
							<img class="rounded-md" src={work.image.url} alt="{name} work: {work.title}" /></a
						>
					{/each}
				</div>
			</div>
		</div>
	</div>
	<!----- Work List Mobile----->
	<div class="flex justify-center lg:hidden">
		<div class="flex gap-3">
			{#each lastWorks as work}
				<a href="#">
					<img class="rounded-md" src={work.image.url} alt="{name} work: {work.title}" /></a
				>
			{/each}
		</div>
	</div>
</div>
