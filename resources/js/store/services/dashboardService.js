export default {
    /**
     * @returns {*}
     */
    overview() {
        return axios.get(`/dashboard/overview`);
    },

    /**
     * @returns {*}
     */
    getRecentLogins() {
        return axios.get(`/dashboard/recent-logins`);
    },
}
