<script lang="ts">
	export let user;
	let showBio = false;
</script>

{#if user?.bio}
	<div class="relative flex flex-col items-center md:items-end text-sm lg:text-base ">
		<div
			class="{showBio
				? ''
				: ' h-24  overflow-hidden text-transparent bg-clip-text bg-gradient-to-b from-gray-900  to-transparent'}  whitespace-pre-line"
		>
			{user.bio}
		</div>

		<div class="{showBio ? ' ' : ' absolute bottom-0'} ">
			<button
				on:click={() => (showBio = !showBio)}
				class=" pl-2  rounded-full  text-sky-800 bg-white underline hover:text-sky-700"
				>{showBio ? 'Show less' : '... read more ...'}</button
			>
		</div>
	</div>
{/if}
