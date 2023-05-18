import { S3Client, PutObjectCommand } from '@aws-sdk/client-s3';

export const s3 = new S3Client({
	region: process.env.S3_DEFAULT_REGION,
	credentials: {
		accessKeyId: process.env.S3_ACCESS_KEY_ID,
		secretAccessKey: process.env.S3_SECRET_ACCESS_KEY
	},
	endpoint: process.env.S3_URL
});

export async function uploadFile(file: File, Key: string) {
	try {
		s3.send(
			new PutObjectCommand({
				ACL: 'public-read',
				Key,
				Body: await file.arrayBuffer(),
				Bucket: process.env.S3_BUCKET,
				ContentLength: file.size
			})
		);
		return true;
	} catch (error) {
		return false;
	}
}
