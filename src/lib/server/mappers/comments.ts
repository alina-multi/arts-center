import type { comments } from '@prisma/client';
import type { Comment } from '$lib/interfaces/Comment';
import { ownerMap } from './owners';

export function commentsMap(comments: comments[]): Comment[] {
	let tree = [];
	let idRef = {};

	for (let comment of comments) {
		let generatedComment = commentMap(comment);
		if (!comment.comment_id) {
			let generatedComment = commentMap(comment);
			tree.push(generatedComment);
			idRef[comment.id] = generatedComment;
		} else {
			if (!idRef[comment.comment_id].answers) {
				idRef[comment.comment_id].answers = [];
			}
			idRef[comment.comment_id].answers.push(generatedComment);
			idRef[comment.id] = generatedComment;
		}
	}
	return tree;
}

export function commentMap(comment: comments): Comment {
	return {
		id: comment.id,
		body: JSON.parse(comment.body),
		deleted_at: comment.deleted_at,
		created_at: comment.created_at,
		updated_at: comment.updated_at,
		rating: comment.rating,
		owner: ownerMap(comment.owner)
	};
}
