import { handler } from './build/handler.js';
import express from 'express';
import { Server } from '@tus/server';
import { S3Store } from '@tus/s3-store';
import * as crypto from 'crypto';

const TusServer = new Server({
	path: '/uploads',
	maxSize: 10485760,
	respectForwardedHeaders: true,
	namingFunction(req, metadata) {
		const extension = metadata.type.split('/')[1];
		const id = crypto.randomBytes(16).toString('hex');
		return `temp/${id}.${extension}`;
	},
	generateUrl(req, { host, path, id }) {
		return `https://${host}${path}/${id}`;
	},
	getFileIdFromRequest({ url }) {
		const id = url.split('/').pop();
		return `temp/${id}`;
	},
	async onUploadCreate(req, res, upload) {
		if (!['image/jpeg', 'image/png', 'image/webp'].includes(upload.metadata.type)) {
			throw { status_code: 500, body: `Must be Jpeg/Png/Webp image. Got ${upload.metadata.type}` };
		}
		return { res, metadata: { ...upload.metadata } };
	},
	datastore: new S3Store({
		s3ClientConfig: {
			endpoint: process.env.S3_URL,
			bucket: process.env.S3_BUCKET,
			region: process.env.S3_DEFAULT_REGION,
			credentials: {
				accessKeyId: process.env.S3_ACCESS_KEY_ID,
				secretAccessKey: process.env.S3_SECRET_ACCESS_KEY
			}
		}
	})
});
const uploadApp = express();
const app = express();

// add a route that lives separately from the SvelteKit app
uploadApp.all('*', TusServer.handle.bind(TusServer));
app.use('/uploads', uploadApp);

// let SvelteKit handle everything else, including serving prerendered pages and static assets
app.use(handler);

app.listen(3000, () => {
	console.log('listening on port 3000');
});
