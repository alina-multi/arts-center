<script lang="ts">
	import Divider from '$lib/components/atoms/Divider.svelte';
	import SocialMediaButtons from '$lib/components//atoms/Buttons/SocialMediaButtons.svelte';
</script>

<div
	class="flex flex-col gap-3 border p-6 rounded-sm dark:border-zinc-800 dark:bg-zinc-900 "
>
	
		<p class="text-lg leading-4 font-semibold xl:text-center dark:text-zinc-100">Sign in to comment this work</p>
	<p class= " text-gray-500 dark:text-zinc-400 text-sm xl:text-center">
	Join the community of people who love this work.  Sign in with your email address to follow this work. 
	</p>


	<div class="flex flex-col  sm:max-lg:flex-row  sm:max-lg:items-center md:max-lg:gap-9 max-md:justify-between">

		<div class="flex  max-sm:w-full  justify-center items-center">
			<a
			href="/login"
			class="xl:w-5/6 max-sm:w-full lg:w-full  text-center rounded-full px-6 py-1 text-white bg-amber-600 shadow-sm hover:bg-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
			>Sign in with email</a
		>
		</div>
		
	

		<Divider>Or continue with</Divider>

		<SocialMediaButtons />
	</div>
</div>
