// Groups by extention, order by extention, order by width
export function pictureMap(sources) {
    const typeMap = {};
    for (const source of sources) {
        const type = "image/" + source.src.split('.').pop();
        typeMap[type]= [...typeMap[type] || [], source]
    }
    const data = [];
    const keysInRightOrder = Object.keys(typeMap).sort().reverse();
    for (const type of keysInRightOrder) {
        const srcsetGroup = {
            type,
            srcset: typeMap[type]
            .sort((a, b) =>  a.width-b.width)
            .map(({src, width}) => `${src} ${width}w`).join(', ')
        }
        data.push(srcsetGroup)
    }
    return data
}

// Finds the smallest non-webp image
export function srcFind(sources: Source[]) {
    return sources
    .filter(({src})=>!src.endsWith('webp'))
    .sort((a, b) => b.width - a.width)
    .pop()
    ?.src
}
// Converts the photo object to a new format with default image and sources
export function convertToPicture(hit) {
    if (hit.photo) {
        hit.photo = { src: srcFind(hit.photo.sources), sources: pictureMap(hit.photo.sources) };
    }
    return hit;
}