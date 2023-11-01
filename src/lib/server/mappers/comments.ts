import type { CommentRaw } from '$lib/interfaces/CommentRaw';
import type { Comment } from '$lib/interfaces/Comment';
import { ownerMap } from './owners';
import { workPreviewMap } from '$lib/server/mappers/work';

export function commentsMap(comments: CommentRaw[]): Comment[] {
	const tree = [];
	const idRef = {};

	for (const comment of comments) {
		const generatedComment = commentMap(comment);
		if (!comment.comment_id) {
			tree.push(generatedComment);
			idRef[comment.id] = generatedComment;
		} else {
			if (!idRef[comment.comment_id]) {
				continue;
			}
			if (!idRef[comment.comment_id].answers) {
				idRef[comment.comment_id].answers = [];
			}
			idRef[comment.comment_id]?.answers.push(generatedComment);
			idRef[comment.id] = generatedComment;
		}
	}
	return tree;
}

export function commentMap(comment: CommentRaw): Comment {
	return {
		id: comment.id,
		text: comment.text,
		deleted_at: comment.deleted_at,
		created_at: comment.created_at,
		updated_at: comment.updated_at,
		rating: comment.rating,
		owner: ownerMap(comment.owner)
	};
}

export function lastCommentsMap(comments: CommentRaw[]): Comment {
	return comments.map((comment) => ({
		...commentMap(comment),
		work: workPreviewMap(comment.work)
	}));
}
