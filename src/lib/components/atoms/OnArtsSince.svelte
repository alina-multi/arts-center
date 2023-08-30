<script>
    import { Icon } from '@steeze-ui/svelte-icon';
	import { CalendarDays } from '@steeze-ui/heroicons';
    import {t} from '$lib/translations';
    export let user, size = 'w-[17px] h-[17px]';
</script>

<div class="flex gap-1 items-center">
    <Icon src={CalendarDays} class={size} />
    <span>{$t('global.user.on_arts_since')}</span>
    <span> {new Date(user.created_at).getFullYear()}</span>
</div>