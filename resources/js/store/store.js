import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const baseURL = "http://127.0.0.1:8000/api";

const store = new Vuex.Store({
    state: {
        all_chamas: [],
        chamaa_created_status: []
    },
    mutations: {
        SET_ALL_CHAMAS: (state, payload) => {
            return state.all_chamas = payload;

        }, SET_CHAMAA_CREATE_RESPONSE: (state, payload) => {
            state.chamaa_created_status = payload
            return
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
                toast.fire({
                    type: 'success',
                    title: 'Chamaa Created successfully'
                })
                if (response.status == 200) {
                    context.commit("SET_CHAMAA_CREATE_RESPONSE", 1);
                }
                return response;

            })
        }
    },
    getters: {
        ALL_CHAMAS: state => state.all_chamas,
        CHAMAA_CREATION_RESPONSE: state => state.chamaa_created_status
    }

})


export default store;
