export default async function fetchPost(url = '', data = {}) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'php/json',
            'Accept': 'php/json'
        },
        body: JSON.stringify(data),
    });
    return await response.json();
}
