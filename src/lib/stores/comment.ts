import { writable } from 'svelte/store';

function createData() {
	const { subscribe, set, update } = writable({
		replyCommentId: null,
		replyHandle: null
	});

	return {
		subscribe,
		showReplyForm: (comment) =>
			update(() => ({
				replyCommentId: comment.id,
				replyHandle: `@${comment.owner.username}`
			})),

		reply: (content, parentComment) =>
			update((data) => {
				const parentIdPath = parentComment ? getIdPath(parentComment) : [];

				const newComment = makeComment(content, data.currentUser, parentIdPath);

				if (parentIdPath.length === 0) {
					data.comments.push(newComment);
				} else {
					const comment = findCommentByIdPath(parentIdPath, data.comments);
					comment.replies = [newComment, ...comment.replies];
				}

				return data;
			})
	};
}

export const data = createData();
