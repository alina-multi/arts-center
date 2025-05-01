<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import LastWorks from '$lib/components/atoms/LastWorks.svelte';
	export let user;
</script>

<div
	class="flex flex-col max-md:mb-3 items-center md:flex-row xs:shadow-sm xs:border rounded-sm w-full dark:bg-zinc-900 dark:border-zinc-800"
>
	<div
		class=" flex items-center grow w-full lg:w-1/2 text-base font-medium py-6 max-xs:border-t max-xs:dark:border-zinc-800 max-xs:dark:px-3 xs:pl-6 gap-3 overflow-hidden xs:pr-6 xl:pr-6"
	>
		<UserPreview {user} />
	</div>
	<div
		class=" md:px-3 lg:p-0 lg:-my-[1px] flex justify-end md:w-1/2 dark:border-gray-700 gap-3 overflow-hidden w-full"
	>
		<LastWorks works={user.works} />
	</div>
</div>
