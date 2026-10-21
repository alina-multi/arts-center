import { PrismaClient } from '@prisma/client';
import { useMockData } from '$lib/server/mock/mode';

function createPrisma(): PrismaClient {
	if (useMockData()) {
		return new Proxy({} as PrismaClient, {
			get(_target, prop) {
				if (prop === 'then') return undefined;
				throw new Error(`Prisma is disabled while USE_MOCK_DATA=true (${String(prop)})`);
			}
		});
	}

	const client = new PrismaClient({
		log: [
			{
				emit: 'event',
				level: 'query'
			}
		]
	});

	if (process?.env?.PRISMA_LOG) {
		client.$on('query', (event) => {
			console.log('Query: ' + event.query);
			console.log('Params: ' + event.params);
			console.log('Duration: ' + event.duration + 'ms');
		});
	}

	return client;
}

export const prisma = createPrisma();
