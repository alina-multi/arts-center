<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Check, XMark } from '@steeze-ui/heroicons';

	export let checked: boolean = false,
		name: string,
		value = true,
		flipValue = false;
	$: displayChecked = flipValue ? !checked : checked;
</script>

<label
	class="{displayChecked
		? 'bg-blue-600'
		: 'bg-zinc-300'} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"
>
	<input type="checkbox" class="sr-only" bind:checked {value} {name} />

	<span
		class="{displayChecked
			? 'translate-x-5'
			: 'translate-x-0'} pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
	>
		<span
			class="{displayChecked
				? 'opacity-0 duration-100 ease-out'
				: 'opacity-100 duration-200 ease-in'} absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
			aria-hidden="true"
		>
			<Icon src={XMark} class="h-2.5 w-2.5 stroke-[3]" />
		</span>

		<span
			class="{displayChecked
				? 'opacity-100 duration-200 ease-in'
				: 'opacity-0 duration-100 ease-out'} absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
			aria-hidden="true"
		>
			<Icon src={Check} class="h-2.5 w-2.5 stroke-[5] text-blue-600" />
		</span>
	</span>
</label>
