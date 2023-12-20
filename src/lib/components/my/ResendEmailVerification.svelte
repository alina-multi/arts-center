<script lang="ts">
	import { magicFetch } from '$lib/helpers/fetchData';
	import toast from 'svelte-french-toast';
	import { getContext } from 'svelte';

	const t = getContext('t');
	let visible = true;

	async function resend() {
		magicFetch('post', '/api/verification-notification').then(() => {
			toast($t('my.edit_page.email_sent'));
			visible = false;
		});
	}
</script>

{#if visible}
	<button
		on:click={resend}
		class="cursor-pointer underline inline hover:text-red-500 dark:hover:text-gray-200"
	>
		{$t('my.edit_page.resend_email')}
	</button>
{/if}
