export const handleIsMy = (me, id) => {
	let isMy = false;

	if (me?.id) {
		isMy = BigInt(me.id) == id;
	}

	return isMy;
};
