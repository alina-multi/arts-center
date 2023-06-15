interface Params {
	method: string;
    deleteId?: number;
	commentable_id?: number;
	commentable_type?: string;
	comment_id?: number;
	text?: string;
	
}

export async function handleSubmitComment(params: Params) {
    const { method, commentable_id, deleteId, commentable_type, comment_id, text } = params;
    
	const url = `/api/comment${deleteId ? `/${deleteId}` : ''}`;


	const response = await fetch(url, {
		method,
		headers: {
			'content-type': 'application/json'
		},
		body: JSON.stringify({
			commentable_id,
			commentable_type,
			comment_id,
			text
		})
	});

	return response;
}
