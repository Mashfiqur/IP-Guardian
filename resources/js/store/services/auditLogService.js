export default {
    /**
     * @payload
     * @returns {*}
     */
    index(payload) {
        return axios.get(`/audit-logs`, {params: payload});
    },

}
