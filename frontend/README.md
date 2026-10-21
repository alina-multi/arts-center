## Developing

Once you've created a project and installed dependencies with `yarn`, start a development server:

```bash
yarn dev
yarn storybook
```

## Building

To create a production version of your app:

```bash
yarn build
yarn build-storybook
```

You can preview the production build with `yarn preview`.

## Demo on Vercel

The public gallery can run without MySQL or the Laravel API. Copy `.env.example` to `.env` (it sets `USE_MOCK_DATA=true` and leaves `PUBLIC_IMAGE_HOST` empty, so images come from placeholder photos), then run `pnpm dev`.

Vercel project settings:

- Root directory: `frontend`
- Install: pnpm
- Build command: `pnpm prisma generate && pnpm build`
- Environment: `USE_MOCK_DATA=true`, `PUBLIC_ENV=production`

Register/login create a browser-local demo account and a `demo_session` cookie. The signed-in account is also kept in an httpOnly `demo_account` cookie so auth still works on Vercel when the filesystem is read-only. On Vercel, connect a Blob store so uploads and richer session state survive refresh (`BLOB_READ_WRITE_TOKEN`). Without that token, local runs store files in `frontend/.demo-sessions` (or `/tmp/demo-sessions` on Vercel). Comments, messages, and payments stay disabled.
