<script lang="ts">
	import { page } from '$app/stores';
	const includedFeatures = [
		'A premium account that will set you apart from other users',
		'Prioritization in the lists, which will provide more attention to your profile',
		'Access to artificial intelligence tools',
		' Opportunity to receive support and rewards from fans'
	];
</script>

<div class=" my-9">
	<div class="mx-auto max-w-7xl">
		<div class="mx-auto max-w-2xl sm:text-center">
			<h2 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-4xl">
				Make a profit from your creativity!
			</h2>
			<p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
				Get exclusive benefits that will give you the opportunity to be noticed, gather fans around
				your work, and convert your art into profit.
			</p>
		</div>
		<div
			class="mx-auto max-w-2xl rounded-md ring-1 ring-zinc-200 dark:ring-zinc-800 dark:bg-zinc-900 sm:mt-6 lg:mx-0 lg:flex lg:max-w-none overflow-hidden"
		>
			<div class="p-8 sm:p-10 lg:flex-auto">
				<h3 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
					Why subscribe and what are the benefits?
				</h3>
				<p class="mt-6 text-base leading-7 text-zinc-600 dark:text-zinc-400">
					We understand that creativity is a process that takes time and focus. We also understand
					that it takes patience, time, and skill to achieve success and financial growth.

					<br />That's why our platform offers assistance and provides tools to help you draw
					attention to your talent, showcase your work to the world, and turn it into profit <br />
				</p>
				<div class="mt-10 flex items-center gap-x-4">
					<h4 class="flex-none text-sm font-semibold leading-6 text-blue-600">What’s included</h4>
					<div class="h-px flex-auto bg-gray-100 dark:bg-zinc-800" />
				</div>
				<ul
					class="mt-8 grid grid-cols-1 gap-4 text-sm leading-6 text-zinc-600 dark:text-zinc-400 sm:grid-cols-2 sm:gap-6"
				>
					{#each includedFeatures as feature}
						<li class="flex items-start">
							<div class="flex-shrink-0">
								<svg
									class="h-6 w-6 text-green-500"
									stroke="currentColor"
									fill="none"
									viewBox="0 0 24 24"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M5 13l4 4L19 7"
									/>
								</svg>
							</div>
							<p class="ml-3">{feature}</p>
						</li>
					{/each}
				</ul>
			</div>
			<div class="  lg:mt-0 lg:w-1/3 lg:max-w-md lg:flex-shrink-0 flex justify-center items-center">
				<div
					class="lg:w-full bg-gray-50 dark:bg-gray-700 py-10 border-l border-gray-900/5 lg:flex lg:flex-col lg:justify-center h-full"
				>
					<div class="mx-auto max-w-xs px-8">
						<p
							class="text-xl leading-6 font-semibold text-zinc-600 dark:text-zinc-300 flex items-end gap-1"
						>
							<span>Annual membership</span>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="fill-amber-500 w-6 h-6"
								viewBox="0 -960 960 960"
								><path
									d="m385-412 36-115-95-74h116l38-119 37 119h117l-95 74 35 115-94-71-95 71ZM244-40v-304q-45-47-64.5-103T160-560q0-136 92-228t228-92q136 0 228 92t92 228q0 57-19.5 113T716-344v304l-236-79-236 79Zm236-260q109 0 184.5-75.5T740-560q0-109-75.5-184.5T480-820q-109 0-184.5 75.5T220-560q0 109 75.5 184.5T480-300ZM304-124l176-55 176 55v-171q-40 29-86 42t-90 13q-44 0-90-13t-86-42v171Zm176-86Z"
								/></svg
							>
						</p>
						<p class="mt-6 flex items-baseline justify-center gap-x-2">
							<span class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-zinc-200"
								>$80</span
							>
							<span
								class="text-sm font-semibold leading-6 tracking-wide text-zinc-600 dark:text-zinc-300"
								>USD</span
							>
						</p>

						<a
							href={$page.data.currentUser ? '/????' : '/login'}
							class="mt-10 block w-full rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
							>Get access</a
						>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
