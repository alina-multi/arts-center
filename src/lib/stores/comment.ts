import { writable } from 'svelte/store';

function createData() {
	const { subscribe, set, update } = writable({
		replyCommentId: null,
		editCommentId: null
	});

	return {
		subscribe,
		showReplyForm: (comment) =>
			update(() => ({
				replyCommentId: comment.id,
				editCommentId: null
			})),

		hideReplyForm: () =>
			update((data) => ({
				...data,
				replyCommentId: null
			})),

		showEditForm: (comment) =>
			update(() => ({
				replyCommentId: null,
				editCommentId: comment.id
			})),

		hideEditForm: () =>
			update((data) => ({
				...data,
				editCommentId: null
			}))
	};
}

export const commentsState = createData();
