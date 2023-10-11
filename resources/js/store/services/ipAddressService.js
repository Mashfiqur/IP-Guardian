export default {
    /**
     * @payload
     * @returns {*}
     */
    index(payload) {
        return axios.get(`/ip-addresses`, {params: payload});
    },

    /**
     *
     * @payload
     * @returns {*}
     */
    store(payload) {
        return axios.post(`/ip-addresses`, payload);
    },

    /**
     * @id
     * @returns {*}
     */
    show(id) {
        return axios.get(`/ip-addresses/${id}`);
    },

    /**
     * @id
     * @payload
     * @returns {*}
     */
    update(id, payload) {
        return axios.put(`/ip-addresses/${id}`, payload);
    },

}
