import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const baseURL = "http://127.0.0.1:8000/api";

const store = new Vuex.Store({
    state: {
        all_chamas: []
    },
    mutations: {
        SET_ALL_CHAMAS: (state, payload) => {
             state.all_chamas = payload;
            return
        }
    },
    actions: {
        getChamas: (context) => {
            let response_data = {};
            axios.get(baseURL + '/chamaa').then(response => {
                context.commit("SET_ALL_CHAMAS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }
    },
    getters: {
        ALL_CHAMAS: state => state.all_chamas,
    }

})


export default store;
