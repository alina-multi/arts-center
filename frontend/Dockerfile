FROM node:20-alpine

WORKDIR /var/www
COPY package.json .
COPY pnpm-lock.yaml .
COPY postcss.config.cjs .
COPY svelte.config.js .
COPY tailwind.config.cjs .
COPY tsconfig.json .
COPY vite.config.ts .
RUN corepack enable
RUN pnpm install
COPY ./src ./src
COPY ./static ./static
RUN ls
RUN pnpm prisma generate
RUN pnpm build

EXPOSE 3000

CMD ["node", "server.js"]

