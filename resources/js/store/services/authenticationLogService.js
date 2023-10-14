export default {
    /**
     * @payload
     * @returns {*}
     */
    index(payload) {
        return axios.get(`/authentication-logs`, {params: payload});
    },

}
