import { PrismaClient } from '@prisma/client';

export const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
});

if (process?.env?.PRISMA_LOG) {
	prisma.$on('query', (e) => {
		console.log('Query: ' + e.query)
		console.log('Params: ' + e.params)
		console.log('Duration: ' + e.duration + 'ms')
	})
}