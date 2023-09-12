export async function fetchData(method: string, body: object) {
    const response = fetch('/api/favorite', {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    return response;
}