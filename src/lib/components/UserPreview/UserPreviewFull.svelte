<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle, Calendar, Star, MapPin } from '@steeze-ui/heroicons';
	export let users, tags, lastWorks;

</script>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 ">
	{#each users as user}
		{#if user.subscribed}
			<!-- VIP User Preview -->
			<div
				class="flex flex-col justify-center lg:flex-row sm:col-span-2 p-3 sm:p-6 gap-3 sm:gap-6 border border-amber-500 rounded-md shadow-xl "
			>
				<div class="flex gap-3 sm:gap-6 items-center sm:items-start">
					<!-- User Avatar -->
					<div class="flex items-start w-32 h-32 sm:h-44 sm:w-44 shrink-0 ">
						<a href="/" class=""
							><img
								class="shadow-lg rounded-full object-cover"
								src={user.photo.url}
								alt="Avatar: {user.name}"
							/></a
						>
					</div>

					<!-- Meta Body -->
					<div class="gap-1 flex flex-col">
						<div
							class="flex flex-wrap sm:flex-nowrap gap-1 sm:gap-3 text-zinc-900 dark:text-zinc-100 items-start text-sm sm:text-base lg:text-lg "
						>
							<a href="" class="hover:text-zinc-700 dark:hover:text-zinc-300 font-semibold mr-2"
								><h3>{user.name}</h3></a
							>
							<span class="text-xs sm:text-sm lg:text-lg border border-amber-500 rounded-md px-3 "
								>Pro</span
							>
						</div>

						<div
							class="text-xs text-zinc-500 dark:text-zinc-300 sm:text-sm md:text-base flex flex-col gap-1"
						>
							<div class="inline-flex gap-1 items-center ">
								<Icon src={Star} class=" h-4 w-4 sm:h-6 sm:w-6 fill-amber-500 stroke-amber-500" />
								<span class="text-zinc-900 dark:text-zinc-300">
									{user.totalRating.toLocaleString('ru-RU')}</span
								>
							</div>
							<div class="inline-flex gap-1 items-center">
								<Icon
									src={UserCircle}
									class=" h-4 w-4 sm:h-6 sm:w-6 stroke-zinc-500 dark:stroke-zinc-300"
								/>
								<span class="">{user.username}</span>
							</div>
							{#if user.location}
								<div class="inline-flex gap-1 items-center">
									<Icon
										src={MapPin}
										class=" h-4 w-4 sm:h-6 sm:w-6 stroke-zinc-500 dark:stroke-zinc-300"
									/>
									<span>{user.location}</span>
								</div>
							{/if}

							<div class="inline-flex gap-1 items-center">
								<Icon
									src={Calendar}
									class="h-4 w-4 sm:h-6 sm:w-6 stroke-zinc-500 dark:stroke-zinc-300"
								/>
								<span>Since {new Date(user.created_at).getFullYear()}</span>
							</div>
						</div>
						<!--------------- Tags -------------------->
						{#if tags.length > 0}
							<div
								class="text-zinc-900 dark:text-zinc-300 hidden flex-wrap gap-1 text-xs sm:flex md:text-sm mt-2 grow-0"
							>
								{#each tags as tag (tag.id)}
									<a
										href={tag.url}
										class=" rounded-md border border-amber-500 px-2 py-1 shadow-sm hover:bg-amber-500 hover:text-zinc-100 "
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
						{#each lastWorks as work}
							<a href="#">
								<img
									class="rounded-md"
									src={work.image.url}
									alt="{user.name} work: {work.title}"
								/></a
							>
						{/each}
					</div>
				</div>
			</div>
		{:else}
			<!-- Simple User Preview -->
			<div
				class="flex flex-col border border-zinc-300 dark:border-zinc-700 gap-3 lg:gap-1 p-3 sm:p-6 rounded-md shadow-sm "
			>
				<div class="flex gap-6">
					<!-- User Avatar -->
					<div class="flex items-start w-28 h-28 sm:h-36 sm:w-36 2xl:h-40 2xl:w-40  shrink-0 ">
						<a href="/" class=""
							><img
								class="shadow-lg rounded-full object-cover"
								src={user.photo.url}
								alt="{user.name} Avatar"
							/></a
						>
					</div>
					<!-- Meta Body -->
					<div class="gap-2 flex flex-col">
						<div
							class="flex gap-3  text-zinc-900 dark:text-zinc-100 items-start text-sm sm:text-base lg:text-lg "
						>
							<a href="" class="dark:hover:text-zinc-300 hover:text-zinc-700"
								><h3 class="font-semibold">{user.name}</h3></a
							>
						</div>

						<div
							class="flex flex-col lg:flex-row text-xs text-zinc-500 dark:text-zinc-300 md:text-sm gap-1 lg:gap-2"
						>
							<div class="inline-flex gap-1 items-center">
								<Icon src={Star} class=" h-5 w-5 stroke-zinc-500 dark:stroke-zinc-300" />
								<span class=""> 15567</span>
							</div>
							<div class="inline-flex gap-1 items-center">
								<Icon src={UserCircle} class=" h-5 w-5 stroke-zinc-500 dark:stroke-zinc-300" />
								<span class="">Username</span>
							</div>
							<div class="inline-flex gap-1 items-center">
								<Icon src={MapPin} class=" h-5 w-5 stroke-zinc-500 dark:stroke-zinc-300" />
								<span>Ukraine</span>
							</div>
						</div>
						<!----- Work List Desktop----->
						<div class="hidden  mt-2 lg:flex ">
							<div class="flex gap-3 2xl:w-3/4">
								{#each lastWorks as work}
									<a href="#">
										<img
											class="rounded-md"
											src={work.image.url}
											alt="{user.name} work: {work.title}"
										/></a
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
								<img
									class="rounded-md"
									src={work.image.url}
									alt="{user.name} work: {work.title}"
								/></a
							>
						{/each}
					</div>
				</div>
			</div>
		{/if}
	{/each}
</div>


