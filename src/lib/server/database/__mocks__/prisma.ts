import type { PrismaClient } from '@prisma/client';
import { beforeEach } from 'vitest';
import { mockDeep, mockReset } from 'vitest-mock-extended';

// https://www.prisma.io/blog/testing-series-1-8eRB5p0Y8o
beforeEach(() => {
	mockReset(prisma);
});

const prisma = mockDeep<PrismaClient>();
export default prisma;
