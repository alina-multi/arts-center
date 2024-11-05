<script lang="ts">
	import ChatList from '$lib/components/chat/ChatList.svelte';
	import { user } from '$lib/stores/auth';
	export let data;
</script>

{#if $user}
	<main>
		<div class=" w-full container mx-auto h-[calc(100vh-108px)] flex flex-col">
			<div class="py-4 border-b flex justify-between items-center">
				<div class="w-1/3 border-r overflow-y-auto">
					<h2 class="text-xl font-semibold">Messages</h2>
				</div>
			</div>

			<div class="flex-1 flex overflow-hidden">
				<div class="w-1/3 border-r overflow-y-auto">
					<ChatList threads={data.threads} />
				</div>
				<div class="flex-1 flex flex-col">
					<slot />
				</div>
			</div>
		</div>
	</main>
{/if}
