<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bars4 } from '@steeze-ui/heroicons';
	import FooterContent from './FooterContent.svelte';
	import Dropdown from '../atoms/Dropdown.svelte';
</script>

<Dropdown style={'z-50 mt-5 w-72 min-w-max  left-0 text-sm'}>
	<div slot="button">
		<Icon src={Bars4} class="w-8 h-8 " />
	</div>
	<div slot="panel">
		<FooterContent media="desktop" />
	</div>
</Dropdown>
