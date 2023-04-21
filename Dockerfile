FROM node:20

WORKDIR /var/www
COPY package.json ./
COPY yarn.lock ./
RUN yarn install
COPY ./ ./
RUN yarn prisma generate
RUN yarn build

EXPOSE 3000

CMD ["node", "build/index.js"]

