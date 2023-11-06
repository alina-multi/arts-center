<script lang="ts">
	export let steps: { label: string; href?: string }[];
	export let currentStep = 1;
</script>

<nav aria-label="Progress">
	<ol
		class="divide-y divide-zinc-300 dark:divide-zinc-700  rounded-sm border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 md:flex md:divide-y-0 shadow"
	>
		{#each steps as { label, href }, i}
			<li class="relative md:flex md:flex-1">
				{#if i + 1 < currentStep}
					<!-- Completed Step -->
					<a {href} data-sveltekit-preload-data="off" class="group flex w-full items-center">
						<span class="flex items-center px-6 py-3 text-sm font-medium">
							<span
								class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-emerald-500 group-hover:bg-emerald-500"
							>
								<svg
									class="h-6 w-6 text-white"
									viewBox="0 0 24 24"
									fill="currentColor"
									aria-hidden="true"
								>
									<path
										fill-rule="evenodd"
										d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
										clip-rule="evenodd"
									/>
								</svg>
							</span>
							<span class="ml-4 text-sm font-medium text-zinc-900 dark:text-white">{label}</span>
						</span>
					</a>
				{/if}
				{#if i + 1 == currentStep}
					<!-- Current Step -->
					<a {href} class="flex items-center px-6 py-3 text-sm font-medium" aria-current="step">
						<span
							class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 font-semibold"
						>
							<span class="text-emerald-500 ">{i + 1}</span>
						</span>
						<span class="ml-4 text-sm font-semibold  text-emerald-500">{label}</span>
					</a>
				{/if}
				{#if i + 1 > currentStep}
					<a {href} class="group flex items-center hover:cursor-default">
						<span class="flex items-center px-6 py-3 text-sm font-medium">
							<span
								class="flex h-10 w-10 flex-shrink-0 items-center justify-center  rounded-full border-2 border-zinc-300 dark:border-zinc-400 "
							>
								<span class=" text-zinc-600 dark:text-zinc-400 "
									>{i + 1}</span
								>
							</span>
							<span
								class="ml-4 text-sm font-medium text-black dark:text-zinc-400"
								>{label}</span
							>
						</span>
					</a>
				{/if}
				{#if i + 1 < steps.length}
					<!-- Arrow separator for lg screens and up -->
					<div class="absolute right-0 top-0 hidden h-full w-5 md:block " aria-hidden="true">
						<svg
							class="h-full w-full text-zinc-300 dark:text-zinc-700"
							viewBox="0 0 22 80"
							fill="none"
							preserveAspectRatio="none"
						>
							<path
								d="M0 -2L20 40L0 82"
								vector-effect="non-scaling-stroke"
								stroke="currentcolor"
								stroke-linejoin="round"
							/>
						</svg>
					</div>
				{/if}
			</li>
		{/each}
	</ol>
</nav>
