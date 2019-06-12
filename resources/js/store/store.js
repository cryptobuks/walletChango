import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const baseURL = "http://127.0.0.1:8000/api";
let config = {
    headers: {
        Authorization: "Bearer " + localStorage.getItem("token"),
    }
}
const store = new Vuex.Store({
    state: {
        all_groups: [],
        group_details: [],
        group_created_status: [],
        group_invite: [],
        group_invite_status: [],


        all_payments: [],


        all_projects: [],
        project_details: {},
        project_monthly_payments: {},
        project_created_status: [],

        all_wallets: [],
        wallet_created_status: [],

        user_token: [],
        authenticate_token_status: [],


    },
    mutations: {
        /*----------------------
     ------user -------
   /*---------------------*/

        SET_AUTH_TOKEN: (state, payload) => {
            return state.user_token = payload;
        },
        SET_AUTH_TOKEN_RESPONSE: (state, payload) => {
            return state.authenticate_token_status = payload;
        },
        /*----------------------
          ------group -------
        /*---------------------*/
        SET_ALL_GROUPS: (state, payload) => {
            return state.all_groups = payload;
        }, SET_GROUP_DETAILS: (state, payload) => {
            return state.group_details = payload;

        }, SET_GROUP_CREATE_RESPONSE: (state, payload) => {
            return state.group_created_status = payload
        }, SET_GROUP_INVITE: (state, payload) => {
            return state.group_invite = payload
        }, SET_GROUP_INVITE_RESPONSE: (state, payload) => {
            return state.group_invite_status = payload
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
        }, SET_PROJECT_DETAILS: (state, payload) => {
            return state.project_details = payload;
        }, SET_PROJECT_MONTHLY_PAYMENTS: (state, payload) => {
            return state.project_monthly_payments = payload;
        }, SET_PROJECTS_CREATE_RESPONSE: (state, payload) => {
            return state.project_created_status = payload
        },   /*----------------------
         ------wallet -------
       /*---------------------*/
        SET_ALL_WALLETS: (state, payload) => {
            console.log(payload)
            return state.all_wallets = payload;

        }, WALLETS_CREATE_RESPONSE: (state, payload) => {
            return state.wallet_created_status = payload
        },
    },
    actions: {
        get_groups: (context) => {
            let response_data = {};
            axios.get(baseURL + '/group', config).then(response => {
                context.commit("SET_ALL_GROUPS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }, get_group_details: (context, payload) => {
            let response_data = {};
            axios.get(baseURL + '/group/' + payload, config).then(response => {
                context.commit("SET_GROUP_DETAILS", response.data);
                response_data = response.data

            }).catch(error => {
                return error;
            })
            return response_data
        }, save_groups: (context, payload) => {
            axios.post(baseURL + '/group', payload, config).then(response => {
                context.commit("SET_ALL_GROUPS", response.data);

                if (response.status == 200) {
                    context.commit("SET_GROUP_CREATE_RESPONSE", 1);
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
        }, send_group_invite: (context, payload) => {
            axios.post(baseURL + '/invite/', payload, config).then(response => {
                context.commit("SET_GROUP_INVITE", response.data);
                if (response.status == 200) {
                    console.log(response.data)
                    if (response.data.status_code == 0) {
                        context.commit("SET_GROUP_INVITE_RESPONSE", 1);
                        toast.fire({
                            type: 'success',
                            title: 'Group Invite send  successfully'
                        })
                    } else {
                        toast.fire({
                            type: 'error',
                            title: 'Failed to send a Group Invite send ' + response.data.status_code
                        })
                    }
                } else {
                    context.commit("SET_GROUP_INVITE_RESPONSE", 1);
                    toast.fire({
                        type: 'error',
                        title: 'Failed to send a Group Invite send  '
                    })
                }
                return response;

            })
        },

        /*------------------------------------------------*/
        /*           payments       */
        /*------------------------------------------------*/

        get_payments(context, payload) {
            axios.get(baseURL + "/payment/group/" + payload, config).then(response => {
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
        get_monthly_payments: (context, payload) => {
            console.log("laods_ " + payload)
            let response_data = {};
            axios.get(baseURL + '/project/' + payload + '/chart', config).then(response => {
                context.commit("SET_PROJECT_MONTHLY_PAYMENTS", response.data);
                // response_data = response.data
            }).catch(error => {
                return error;
            });
            return response_data
        }, get_projects: (context) => {
            let response_data = {};
            axios.get(baseURL + '/project', config).then(response => {
                context.commit("SET_ALL_PROJECTS", response.data);
                response_data = response.data
            }).catch(error => {
                console.log(error)

                return error;
            });
            return response_data
        }, get_project: (context, payload) => {
            let response_data = {};
            axios.get(baseURL + '/project/' + payload, config).then(response => {
                console.log(response.data)

                context.commit("SET_PROJECT_DETAILS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            });
            return response_data
        }, save_projects: (context, payload) => {
            axios.post(baseURL + '/project/', payload, config).then(response => {
                context.commit("SET_ALL_PROJECTS", response.data);
                console.log(response.data);
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
        },/*------------------------------------------------*/
        /*                      wallets                  */
        /*------------------------------------------------*/
        get_wallets: (context) => {
            let response_data = {};
            axios.get(baseURL + '/wallet', config).then(response => {
                context.commit("SET_ALL_WALLETS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }, get_wallet: (context, payload) => {
            let response_data = {};
            axios.get(baseURL + '/wallet/' + payload, config).then(response => {
                console.log(response.data)
                context.commit("SET_ALL_WALLETS", response.data);
                response_data = response.data
            }).catch(error => {
                return error;
            })
            return response_data
        }, save_wallets: (context, payload) => {
            axios.post(baseURL + '/wallet/', payload).then(response => {
                context.commit("SET_ALL_WALLETS", response.data);
                if (response.status == 200) {
                    context.commit("SET_WALLETS_CREATE_RESPONSE", 1);
                    toast.fire({
                        type: 'success',
                        title: 'Wallet Created successfully'
                    })
                } else {
                    console.log(response)
                    context.commit("SET_WALLETS_CREATE_RESPONSE", 0);
                    toast.fire({
                        type: 'error',
                        title: 'Wallet Not Created Please Try again '
                    })
                }
                return response;

            })
        },


        /**
         * user login
         */
        authenticate_user: (context, payload) => {
            axios.post(baseURL + '/auth/authenticate/', payload, config).then(response => {
                console.log(response.data)
                console.log("reposne server")
                context.commit("SET_AUTH_TOKEN", response.data);
                console.log(response.data);
                if (response.status == 200) {
                    if (response.data.status_code == 0) {
                        context.commit("SET_AUTH_TOKEN_RESPONSE", 1);
                        localStorage.setItem('token', response.data.data.token)
                        toast.fire({
                            type: 'success',
                            title: 'Successfully logged In'
                        })
                    } else {
                        context.commit("SET_AUTH_TOKEN_RESPONSE", 0);
                        toast.fire({
                            type: 'error',
                            title: 'Failed to login in. Wrong credentials  '
                        })
                    }
                } else {
                    context.commit("SET_AUTH_TOKEN_RESPONSE", 0);
                    toast.fire({
                        type: 'error',
                        title: 'Failed to login in. Wrong credentials  '
                    })
                }
                return response;

            })
        }

    },
    getters: {
        /*----------------------
          ------group -------
        /*---------------------*/
        ALL_GROUPS: state => state.all_groups,
        ALL_GROUP_DETAILS: state => state.group_details,
        GROUP_CREATION_RESPONSE: state => state.group_created_status,
        GROUP_INVITE: state => state.group_invite,
        GROUP_INVITE_RESPONSE: state => state.group_invite,

        /*----------------------
          ------payments -------
        /*---------------------*/
        ALL_PAYMENTS: state => state.all_payments,

        /*----------------------
       ------projects -------
     /*---------------------*/
        ALL_PROJECTS: state => state.all_projects,
        PROJECT_DETAILS: state => state.project_details,
        PROJECT_MONTHLY_PAYMENTS: state => state.project_monthly_payments,
        PROJECTS_CREATION_RESPONSE: state => state.project_create,
        /*----------------------
       ------wallets -------
     /*---------------------*/
        ALL_WALLETS: state => state.all_wallets,
        WALLETS_CREATION_RESPONSE: state => state.wallet_created_status,

        /**
         * authentication
         */
        AUTH_RESPONSE: state => state.authenticate_token_status,


    }

})


export default store;
