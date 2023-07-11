<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { EllipsisVertical, PencilSquare } from '@steeze-ui/heroicons';
	import { Popover, PopoverButton, PopoverPanel, Transition } from '@rgossiaux/svelte-headlessui';
	import { page } from '$app/stores';
	import { handleIsMy } from '$lib/helpers/handleIsMy';

	export let work,
		options = [
			{
				label: 'Something',
				href: '#'
			},
			{
				label: 'Something',
				href: '#'
			}
		];

	let myWork = work.owners.some((owner) => handleIsMy($page.data.currentUser, owner.id));
</script>

{#if myWork}
	<a href={`/work/${work.id}/edit`} class=" hidden md:flex gap-3">
		<span class="sr-only">Edit work</span>
		<Icon src={PencilSquare} class="w-6 h-6 text-gray-700 hover:text-gray-500" />
	</a>
{:else}
	<div class="relative inline-block text-base">
		<Popover let:open>
			<PopoverButton
				class="hover:bg-gray-100 cursor-pointer dark:hover:bg-gray-900 rounded-md py-1"
			>
				<Icon src={EllipsisVertical} class="w-8 h-8 stroke-gray-00 dark:stroke-gray-100 " />
			</PopoverButton>

			{#if open}
				<Transition
					enter="transition duration-100 ease-out"
					enterFrom="transform scale-95 opacity-0"
					enterTo="transform scale-100 opacity-100"
					leave="transition duration-75 ease-out"
					leaveFrom="transform scale-100 opacity-100"
					leaveTo="transform scale-95 opacity-0"
				>
					<PopoverPanel
						class="absolute right-0 z-10 w-40 mt-2 origin-top-right rounded-md  bg-white text-gray-700 dark:text-gray-100  dark:bg-gray-900 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none p-4 "
					>
						<div class="flex flex-col space-y-2">
							{#each options as option}
								<a
									href={option.href}
									class="hover:text-gray-900 hover:bg-gray-100 dark:bg-gray-700 dark:hover:text-gray-200 dark:hover:bg-gray-600 px-3 py-1 rounded-md"
									>{option.label}</a
								>
							{/each}
						</div>
					</PopoverPanel>
				</Transition>
			{/if}
		</Popover>
	</div>
{/if}
