<script lang="ts">
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import { getContext } from 'svelte';
	import { user as currentUser, isUserLoading, showAuthModal } from '$lib/stores/auth';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { RocketLaunch } from '@steeze-ui/heroicons';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { fetchData } from '$lib/helpers/fetchData';

	let isMy = false;
	$: isMy = handleIsMy($currentUser, user.id);

	const t = getContext('t');

	export let user;
	let open = false;
	let message = '';
	$: message_sent = false;

	async function onSendMessage() {
		let threadId = $currentUser?.threads?.[user.id];
		if (!threadId) {
			const response = await fetchData('POST', '/api/thread', {
				title: 'empty', // temporary fix!!!!!!!!!
				participants: [user.id.toString()]
			});
			let data = await response.json();
			threadId = data.id;
			$currentUser.threads[user.id] = threadId;
		}

		await fetchData('POST', `/api/thread/${threadId}/message`, {
			message
		});

		message_sent = true;
		message = '';
	}

	const handleGetInTouch = () => {
		if ($currentUser) {
			open = true;
		} else {
			showAuthModal.set(true);
		}
	};
</script>

{#if !$isUserLoading}
	{#if !isMy}
		<button
			on:click={handleGetInTouch}
			class=" w-full py-2 px-4 border text-center hover:border-zinc-800 bg-white dark:bg-zinc-800 dark:border-zinc-700 font-semibold"
			>{$t('global.buttons.get_in_touch')}</button
		>
	{/if}
{/if}

<ModalWindow bind:open on:close class=" max-w-[484px] md:mx-auto rounded-[12px] sm:m-20 p-12 ">
	{#if message_sent}
		<div class="flex flex-col text-center items-center gap-3">
			<Icon src={RocketLaunch} class="w-28 h-28 stroke-1" />
			<div class="font-semibold text-xl">{$t(`global.connect_artist.message_sent_1`)}</div>
			<div>{$t(`global.connect_artist.message_sent_2`)}</div>
			<button
				on:click={() => {
					open = false;
					message_sent = false;
				}}
				class="bg-zinc-900 dark:bg-teal-600 w-full px-4 py-4 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
			>
				{$t(`global.connect_artist.got_it`)}
			</button>
		</div>
	{:else}
		<div class="space-y-9">
			<div class="flex items-center gap-3">
				<AvatarLink {user} size="w-14 h-14" />

				<h3 class="text-xl font-semibold">{$t(`global.connect_artist.connect`)} {user?.name}</h3>
			</div>

			<form on:submit|preventDefault={onSendMessage} class="space-y-9">
				<div class="space-y-3">
					<p
						class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-sm dark:text-zinc-400"
					>
						{$t('global.connect_artist.your_message')}
					</p>

					<TextAreaInput name="message" bind:value={message} rows={5} />
				</div>

				<button
					class="bg-zinc-900 w-full dark:bg-teal-600 rounded-full px-4 py-4 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 dark:bg-emerald"
				>
					{$t(`global.buttons.send_message`)}
				</button>
			</form>
		</div>
	{/if}
</ModalWindow>
