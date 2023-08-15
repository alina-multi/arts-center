FROM node:20

WORKDIR /var/www
COPY package.json ./
COPY pnpm-lock.yaml ./
RUN pnpm install
COPY ./ ./
RUN pnpm prisma generate
RUN pnpm build

EXPOSE 3000

CMD ["node", "build/index.js"]

