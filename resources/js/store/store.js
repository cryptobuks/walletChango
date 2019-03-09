import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);


const store = new Vuex.Store({
    state: {
        all_chamas: {},
    },
    mutations: {
        SET_ALL_CHAMAS: (state, payload) => {
            return state.all_chamas = payload
        }
    },
    actions: {
        getChamas: async (context, payload) => {
            let {data} = await axios.get();
            context.commit('SET_CHAMA', data)
        }
    },
    getters: {
        ALL_CHAMAS: state => state.all_chamas,
    }

})


export default store;
