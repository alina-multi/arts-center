<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { user } from '$lib/stores/auth';
	import Time from '$lib/components/chat/Time.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Check } from '@steeze-ui/heroicons';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';

	export let messages;

	console.log(messages);
</script>

<div class="flex py-4"></div>

{#each messages as message}
	<div class="mb-4 flex {$user.id === message.user_id ? 'justify-end' : 'justify-start'}">
		<div class="flex items-start gap-2.5">
			{#if $user.id != message.user_id}
				<Avatar user={$user} size="w-8 h-8 " />
			{/if}

			<div>
				<div
					class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 {$user.id === message.user_id
						? 'border-gray-200 bg-blue-600 text-white'
						: ' border-gray-200 bg-gray-100 '} rounded-e-xl rounded-es-xl dark:bg-gray-700"
				>
					<p class="text-sm font-normal pb-2.5">
						{message.message} That's awesome. I think our users will really appreciate the improvements.
					</p>
				</div>
				<div class="flex justify-end items-center gap-3">
					<div class="text-xs text-gray-500 mt-1">
						<Time date={message.created_at} />
						<!-- <LocaleDate date={message.created_at} /> -->
					</div>
					{#if $user.id === message.user_id}
						<Icon src={Check} theme="solid" class="h-4 w-4" />
					{/if}
				</div>
			</div>

			<!-- <button
				id="dropdownMenuIconButton"
				data-dropdown-toggle="dropdownDots"
				data-dropdown-placement="bottom-start"
				class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
				type="button"
			>
				<svg
					class="w-4 h-4 text-gray-500 dark:text-gray-400"
					aria-hidden="true"
					xmlns="http://www.w3.org/2000/svg"
					fill="currentColor"
					viewBox="0 0 4 15"
				>
					<path
						d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
					/>
				</svg>
			</button>
			<div
				id="dropdownDots"
				class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600"
			>
				<ul
					class="py-2 text-sm text-gray-700 dark:text-gray-200"
					aria-labelledby="dropdownMenuIconButton"
				>
					<li>
						<a
							href="#"
							class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
							>Reply</a
						>
					</li>
					<li>
						<a
							href="#"
							class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
							>Forward</a
						>
					</li>
					<li>
						<a
							href="#"
							class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
							>Copy</a
						>
					</li>
					<li>
						<a
							href="#"
							class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
							>Report</a
						>
					</li>
					<li>
						<a
							href="#"
							class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
							>Delete</a
						>
					</li>
				</ul>
			</div> -->
		</div>
	</div>
{/each}
