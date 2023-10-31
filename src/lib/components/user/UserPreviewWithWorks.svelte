<script lang="ts">
import UserPreview from '$lib/components/user/UserPreview.svelte';
import LastWorks from '$lib/components/atoms/LastWorks.svelte';
export let user;
</script>
<div
	class="flex flex-col items-center sm:flex-row sm;gap-3  shadow-sm border  rounded-sm w-full dark:bg-zinc-900 dark:border-zinc-800 {user.subscribed
					? 'bg-zinc-50 dark:bg-blue-900 shadow-2xl'
					: 'bg-white'}"
>
	<div
		class=" flex items-center grow w-full sm:w-1/2 text-lg px-3 sm:max-lg:pt-3 py-3 gap-3 overflow-hidden"
	>
		<UserPreview {user} />
	</div>
	<div
		class=" sm:p-3 lg:p-0 lg:-my-[1px] flex justify-end sm:w-1/2 dark:border-gray-700 gap-3 overflow-hidden w-full"
	>
		<LastWorks works={user.works} />
	</div>
</div>