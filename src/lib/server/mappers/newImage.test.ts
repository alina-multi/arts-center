import {describe, expect, it, test} from 'vitest';
import { pictureMap, srcFind } from './newImage';
const sources = [
    {
        src: "https://picsum.photos/id/1/300/250.webp",
        width: 300,
        height: 250
    },
    {
        src: "https://picsum.photos/id/1/300/250.jpeg",
        width: 300,
        height: 250
    },
    {
        src: "https://picsum.photos/id/1/150/100.png",
        width: 150,
        height: 100
    },
    {
        src: "https://picsum.photos/id/1/600/450.webp",
        width: 600,
        height: 450
    },
    {
        src: "https://picsum.photos/id/1/600/450.png",
        width: 600,
        height: 450
    },
    {
        src: "https://picsum.photos/id/1/600/450.jpeg",
        width: 600,
        height: 450
    },
];

describe("pictureMap converts from sources", () => {
    test("that it groups by extention", () => {
        const result = pictureMap(sources);
        expect(result).toStrictEqual([
            {
                'type': 'image/webp',
                'srcset': 'https://picsum.photos/id/1/300/250.webp 300w, https://picsum.photos/id/1/600/450.webp 600w',
            },
            {
                'type': 'image/png',
                'srcset': 'https://picsum.photos/id/1/150/100.png 150w, https://picsum.photos/id/1/600/450.png 600w',
            },
            {
                'type': 'image/jpeg',
                'srcset': 'https://picsum.photos/id/1/300/250.jpeg 300w, https://picsum.photos/id/1/600/450.jpeg 600w',
            },
        ])
    })
})

describe("srcFind does it job )))", () => {
    test("grabs smallest non-webp image", () => {
        const result = srcFind(sources);
        expect(result).toStrictEqual('https://picsum.photos/id/1/150/100.png')
    })
})