<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle, Star, MapPin } from '@steeze-ui/heroicons';
	export let name, avatar, country, totalRating, username, works;
	totalRating = 1234;
	const regionNames = new Intl.DisplayNames(['en'], { type: 'region' });
</script>

<div
	class=" flex flex-col border border-gray-200 dark:border-gray-700 gap-3 p-3 rounded-md shadow-sm"
>
	<div class="flex items-center gap-3">
		<div class="flex items-start shrink-0 ">
			<a href="/" class="border border-gray-100 rounded-full shadow-sm"
				><img
					class=" w-14 h-14  rounded-full object-cover"
					src={avatar.src}
					alt="{name} Avatar"
				/></a
			>
		</div>

		<div class="gap-1 flex flex-col items-start ">
			<div class="flex  items-start gap-3">
				<a href="/" class="dark:hover:text-gray-300 hover:text-gray-700"
					><h4 class="text-lg">{name}</h4></a
				>

				<butoon
					class="  dark:bg-gray-900 dark:border-sky-700 dark:border rounded-full px-3 py-1 text-xs text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
					>Follow</butoon
				>
			</div>

			<div class="flex flex-wrap text-xs text-gray-500 dark:text-gray-300 gap-1 items-end">
				{#if totalRating > 0}
					<div class="flex items-end ">
						<Icon src={Star} theme="solid" class=" h-4 w-4 fill-amber-600 " />
						<span class="leading-3"> {totalRating}</span>
					</div>
				{/if}

				<span class="leading-3">@{username}</span>

				{#if country}
					<div class="inline-flex  items-end">
						<Icon
							src={MapPin}
							theme="solid"
							class=" h-4 w-4 fill-green-900/80 dark:stroke-gray-300"
						/>
						<span class="leading-3">{regionNames.of(country)}</span>
					</div>
				{/if}
			</div>
		</div>
	</div>

	<!----- Work List ----->
	<div class="flex justify-center ">
		<div class="grid grid-cols-3 gap-1 rounded-md overflow-hidden ">
			{#each works as work}
				<a href="#">
					<div class="bg-zinc-300  aspect-[4/3] w-full rounded-md">
						<img
							class="rounded-md  aspect-[4/3] w-full object-cover "
							src={work.image.src}
							srcset={work.image.srcset}
						/>
					</div>
				</a>
			{/each}
		</div>
	</div>
</div>
