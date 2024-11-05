<script lang="ts">
	import ChatList from '$lib/components/chat/ChatList.svelte';

	export let data;

	// console.log('threads', data.threads);

	let messages: Message[] = [];
	let currentThreadId: number | null = null;
	let newMessage = '';

	function sendMessage() {
		if (newMessage.trim() && currentThreadId) {
			messages = [
				...messages,
				{
					id: messages.length + 1,
					content: newMessage,
					sender: 'user',
					timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
				}
			];
			newMessage = '';
			// Here you would typically make an API call to send the message
		}
	}
</script>

<main class="  ">
	<div class=" w-full container mx-auto h-[calc(100vh-108px)] flex flex-col">
		<div class="py-4 border-b flex justify-between items-center">
			<div class="w-1/3 border-r overflow-y-auto">
				<h2 class="text-xl font-semibold">Messages</h2>
			</div>
		</div>

		<div class="flex-1 flex overflow-hidden">
			<div class="w-1/3 border-r overflow-y-auto">
				<ChatList threads={data.threads} {currentThreadId} />
			</div>
			<div class="flex-1 flex flex-col">
				<div class="flex-1 overflow-y-auto p-4 pr-0">
					<slot />
				</div>
				<div class="p-4 pr-0">
					<form on:submit|preventDefault={sendMessage} class="flex gap-4">
						<input
							bind:value={newMessage}
							placeholder="Type a message..."
							class="flex-1 p-3 pl-6 border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-transparent bg-gray-100"
						/>
						<button
							type="submit"
							class="bg-zinc-900 font-medium text-white px-6 py-2 hover:bg-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-2"
						>
							Send
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>
