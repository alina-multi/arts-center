<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import EmailInput from '$lib/components/input/EmailInput.svelte';
	import PasswordInput from '$lib/components/input/PasswordInput.svelte';
	import TextInput from '$lib/components/input/TextInput.svelte';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import { availableLocales } from '$lib/translations';
	import InputGroup from '$lib/components/input/InputGroup.svelte';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import AvatarInput from '$lib/components/user/AvatarInput.svelte';

	export let data: PageData;
	export let form: ActionData;
	const profile = data.profile.data;
</script>

<form method="post" enctype="multipart/form-data" class="space-y-5">
	<FormGroup
		h1="Profile"
		h2="This information will be displayed publicly so be careful what you share."
	>
		<InputGroup label="Avatar" error={form?.errors?.avatar} let:elementId={id}>
			<AvatarInput {id} currentAvatar={profile?.avatar} />
		</InputGroup>

		<InputGroup
			label="Full name"
			error={form?.errors?.email}
			let:elementId={id}
			let:hasError={error}
		>
			<TextInput name="name" value={profile.name} {id} {error} />
		</InputGroup>

		<InputGroup
			label="Username"
			error={form?.errors?.username}
			let:elementId={id}
			let:hasError={error}
		>
			<div
				class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600"
			>
				<span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">arts.center/</span
				>
				<input
					type="text"
					name="username"
					{id}
					value={profile.username}
					class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
					placeholder="janesmith"
				/>
			</div>
		</InputGroup>

		<div class="col-span-full">
			<h3>Biography</h3>
			<div class="grid grid-cols-2 gap-3">
				{#each availableLocales as locale}
					<div class="col">
						<InputGroup
							label={locale}
							error={form?.errors?.country}
							let:elementId={id}
							let:hasError={error}
						>
							<TextAreaInput
								{id}
								{error}
								name="bios[{locale}]"
								value={profile?.bios?.[locale] ?? ''}
							/>
						</InputGroup>
					</div>
				{/each}
			</div>
			<p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about yourself.</p>
		</div>

		<InputGroup
			label="Country"
			error={form?.errors?.country}
			let:elementId={id}
			let:hasError={error}
		>
			<TextInput {id} {error} name="country" value={profile.country} />
		</InputGroup>
	</FormGroup>

	<FormGroup h1="Login Information">
		<InputGroup label="email" error={form?.errors?.email} let:elementId={id} let:hasError={error}>
			{#if !profile?.email_verified_at}
				<p class="mt-1 text-sm leading-6 text-gray-600">Email awaiting confirmation</p>
			{/if}
			<EmailInput {id} {error} name="email" value={profile.email} />
		</InputGroup>

		<InputGroup
			label="password"
			error={form?.errors?.password}
			let:elementId={id}
			let:hasError={error}
		>
			<PasswordInput {id} {error} name="password" autocomplete="off" />
		</InputGroup>

		<InputGroup label="confirm password" let:elementId={id}>
			<PasswordInput {id} name="password_confirmation" autocomplete="off" />
		</InputGroup>

		<InputGroup
			label="current password"
			error={form?.errors?.current_password}
			let:elementId={id}
			let:hasError={error}
		>
			<PasswordInput {id} {error} name="current_password" />
		</InputGroup>
	</FormGroup>
	<button
		type="submit"
		class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
	>
		Save
	</button>
</form>
