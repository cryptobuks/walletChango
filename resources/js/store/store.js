import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const baseURL = "http://127.0.0.1:8000/api";

const store = new Vuex.Store({
    state: {
        all_chamas: [],
        all_payments: [],
        chamaa_created_status: [],
    },
    mutations: {
        /*----------------------
          ------chamaa -------
        /*---------------------*/
        SET_ALL_CHAMAS: (state, payload) => {
            return state.all_chamas = payload;

        }, SET_CHAMAA_CREATE_RESPONSE: (state, payload) => {
            return state.chamaa_created_status = payload
        },
        /*----------------------
          ------payments -------
        /*---------------------*/
        SET_ALL_PAYMENTS: (state, payload) => {
            return state.all_payments = payload;

        }
    },
    actions: {
        get_chamas: (context) => {
            let response_data = {};
            axios.get(baseURL + '/chamaa').then(response => {
                context.commit("SET_ALL_CHAMAS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }, save_chamas: (context, payload) => {
            axios.post(baseURL + '/chamaa', payload).then(response => {
                context.commit("SET_ALL_CHAMAS", response.data);

                if (response.status == 200) {
                    context.commit("SET_CHAMAA_CREATE_RESPONSE", 1);
                    toast.fire({
                        type: 'success',
                        title: 'Chamaa Created successfully'
                    })
                } else {
                    context.commit("SET_CHAMAA_CREATE_RESPONSE", 0);
                    toast.fire({
                        type: 'error',
                        title: 'Chamaa Created successfully'
                    })
                }
                return response;

            })
        },


        /**payments*/
        get_payments(context, payload) {
            axios.get(baseURL + "/payment/chamaa/" + payload).then(response => {
                console.log(response)

                context.commit("SET_ALL_PAYMENTS", response.data)
            }).catch(error => {
                toast.fire({
                    type: 'error',
                    title: 'Failed to get payments'
                })
            })
        }

    },
    getters: {
        /*----------------------
          ------chamaa -------
        /*---------------------*/
        ALL_CHAMAS: state => state.all_chamas,
        CHAMAA_CREATION_RESPONSE: state => state.chamaa_created_status,

        /*----------------------
          ------payments -------
        /*---------------------*/
        ALL_PAYMENTS: state => state.all_payments,
    }

})


export default store;
