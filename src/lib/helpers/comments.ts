import toast from 'svelte-french-toast';
import { tick } from 'svelte';

export const commentMassage = {
	add: {
		loading: 'Adding comment...',
		success: 'comment added',
		error: 'Error adding comment'
	},
	reply: {
		loading: 'Adding reply...',
		success: 'Reply added',
		error: 'Error adding reply'
	},
	delete: {
		loading: 'Deleting comment...',
		success: 'Comment deleted',
		error: 'Error deleting comment'
	},
	edit: {
		loading: 'Editing comment...',
		success: 'Comment edited',
		error: 'Error editing comment'
	}
};

export function сommentValidations(value: string) {
	value = value.trim();
	toast.dismiss();
	if (!value) {
		toast.error('Comment cannot be empty');
		return;
	}
	if (value.length <= 2) {
		toast.error('Comment cannot be longer than 3 characters');
		return;
	}
	return true;
}

export async function scrollToBottom(id: string) {
	await tick();
	const element = document.getElementById(id);
	const rect = element?.getBoundingClientRect();

	if (rect && rect.bottom > window.innerHeight) {
		element?.scrollIntoView({ behavior: 'instant', block: 'end', inline: 'nearest' });
	}
}
