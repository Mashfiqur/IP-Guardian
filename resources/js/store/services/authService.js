export default {
    /**
     *
     * @param payload
     * @returns {*}
     */
    login(payload) {
        return axios.post(`/login`, payload);
    },

    /**
     *
     * @returns {*}
     */
    logout() {
        return axios.post(`/logout`);
    },

    /**
     *
     * @returns {*}
     */
    authorize() {
        return axios.get(`/user`);
    },
}