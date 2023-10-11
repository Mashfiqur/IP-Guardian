export default {
    /**
     *
     * @returns {*}
     */
    getProfile() {
        return axios.get(`/me`);
    },

    /**
     *
     * @param payload
     * @returns {*}
     */
    updateProfile(payload){
        return axios.post(`/me`, payload);
    }
}