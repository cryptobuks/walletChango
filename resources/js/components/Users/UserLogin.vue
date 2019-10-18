<template>

    <div class="modal " id="create_wallet" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">


                <div class="modal-body">
                    <!-- form start -->
                    <h5 v-show="!editMode" class="modal-title">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="authenticate_user()">
                    <div class="modal-body">
                        <div class="form-wallet">

                            <div class="row">
                                <div class="col-3">
                                    <label for="email"></label>
                                </div>
                            </div>
                            <input v-model="form.email" type="text" name="email"
                                   placeholder="Enter Email"
                                   id="email"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-wallet">

                            <div class="row">
                                <div class="col-3">
                                    <label for="password"></label>
                                </div>
                            </div>
                            <input v-model="form.password" type="password" name="email"
                                   placeholder="Enter Password"
                                   id="password"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>


                    </div>
                    <div class="modal-footer">

                        <button v-show="!editMode" :disabled="form.busy" type="submit" class="btn btn-primary">
                            Login
                        </button>

                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</template>

<script>

    export default {
        data() {
            return {
                editMode: false,
                form: new Form({
                    email: '',
                    password: '',
                }),
                all_wallets: []
            }
        },
        mounted() {
            $("#create_wallet").modal('show');

        }, methods: {
            /** open creating/update of wallet information**/
            open_my_modal() {
                $("#create_wallet").modal('show');
            },

            authenticate_user() {
                this.$store.dispatch("authenticate_user", this.form);
            },
        },
        computed: {
            check_authentication_status() {
                let auth_response = this.$store.getters.AUTH_RESPONSE
                if (auth_response === 1) {
                    this.$router.push({name: 'projects', path: 'projects'})
                }
                return auth_response
            }
        },
        created() {
        },
        watch: {
            check_authentication_status(_old, _new) {
                if (_old == 1) {
                    $('#create_wallet').modal('hide');
                    console.log(_old)
                    this.$router.push({name: 'projects', path: projects})
                } else {
                    swal.fire(
                        'Failed!',
                        'There Was an Problem Please try again.',
                        'error'
                    )
                }
            }

        }
    }
</script>
