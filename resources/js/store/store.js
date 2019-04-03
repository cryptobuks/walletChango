import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const baseURL = "http://127.0.0.1:8000/api";

const store = new Vuex.Store({
    state: {
        all_groups: [],
        group_created_status: [],


        all_payments: [],


        all_projects: [],
        project_created_status: [],
    },
    mutations: {
        /*----------------------
          ------group -------
        /*---------------------*/
        SET_ALL_GROUPS: (state, payload) => {
            return state.all_groups = payload;

        }, SET_GROUP_CREATE_RESPONSE: (state, payload) => {
            return state.group_created_status = payload
        },
        /*----------------------
          ------payments -------
        /*---------------------*/
        SET_ALL_PAYMENTS: (state, payload) => {
            return state.all_payments = payload;

        },
        /*----------------------
         ------payments -------
       /*---------------------*/
        SET_ALL_PROJECTS: (state, payload) => {
            return state.all_projects = payload;

        }, SET_PROJECTS_CREATE_RESPONSE: (state, payload) => {
            return state.project_created_status = payload
        },
    },
    actions: {
        get_groups: (context) => {
            let response_data = {};
            axios.get(baseURL + '/group').then(response => {
                context.commit("SET_ALL_GROUPS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }, save_GROUPs: (context, payload) => {
            axios.post(baseURL + '/group', payload).then(response => {
                context.commit("SET_ALL_GROUPS", response.data);

                if (response.status == 200) {
                    context.commit("SET_GROUPS_CREATE_RESPONSE", 1);
                    toast.fire({
                        type: 'success',
                        title: 'Group Created successfully'
                    })
                } else {
                    context.commit("SET_GROUP_CREATE_RESPONSE", 0);
                    toast.fire({
                        type: 'error',
                        title: 'Group Created successfully'
                    })
                }
                return response;

            })
        },

        /*------------------------------------------------*/
        /*           payments       */
        /*------------------------------------------------*/

        get_payments(context, payload) {
            axios.get(baseURL + "/payment/group/" + payload).then(response => {
                console.log(response)

                context.commit("SET_ALL_PAYMENTS", response.data)
            }).catch(error => {
                toast.fire({
                    type: 'error',
                    title: 'Failed to get payments'
                })
            })
        },

        /*------------------------------------------------*/
        /*                      projects                  */
        /*------------------------------------------------*/
        get_projects: (context) => {
            let response_data = {};
            axios.get(baseURL + '/project').then(response => {
                context.commit("SET_ALL_PROJECTS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }, get_project: (context, payload) => {
            let response_data = {};
            axios.get(baseURL + '/project/'+payload).then(response => {
                console.log(response.data)
                context.commit("SET_ALL_PROJECTS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }, save_projects: (context, payload) => {
            axios.post(baseURL + '/project/', payload).then(response => {
                context.commit("SET_ALL_PROJECTS", response.data);

                if (response.status == 200) {
                    context.commit("SET_PROJECTS_CREATE_RESPONSE", 1);
                    toast.fire({
                        type: 'success',
                        title: 'Project Created successfully'
                    })
                } else {
                    console.log(response)
                    context.commit("SET_PROJECTS_CREATE_RESPONSE", 0);
                    toast.fire({
                        type: 'error',
                        title: 'Project Not Created Please Try again '
                    })
                }
                return response;

            })
        },

    },
    getters: {
        /*----------------------
          ------group -------
        /*---------------------*/
        ALL_GROUPS: state => state.all_groups,
        GROUP_CREATION_RESPONSE: state => state.group_created_status,

        /*----------------------
          ------payments -------
        /*---------------------*/
        ALL_PAYMENTS: state => state.all_payments,

        /*----------------------
       ------payments -------
     /*---------------------*/
        ALL_PROJECTS: state => state.all_projects,
        PROJECTS_CREATION_RESPONSE: state => state.project_created_status,

    }

})


export default store;
