export async function fetchData(method: string,url:string, body: object) {
    const response = fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    return response;
}