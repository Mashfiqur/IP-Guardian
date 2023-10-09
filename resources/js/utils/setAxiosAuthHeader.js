export default () => {
    let bearerToken = localStorage.getItem('bearer_token');

    if (bearerToken) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${bearerToken}`;
    } else {
        delete axios.defaults.headers.Authorization;
    }
}