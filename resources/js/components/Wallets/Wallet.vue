<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Wallet

                        <button class="btn btn-success right"
                                @click="open_my_modal">
                            New Wallet
                            <i class="nav-icon fas fa-plus-square "></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div v-for="wallet in all_wallets" class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{wallet.wallet_name}}</span>
                                        <span class="info-box-number">{{wallet.wallet_amount}} Kshs</span>

                                        <a class="btn" @click="view_wallet(wallet.id)">View<i
                                            class=" fas fa-tachometer-alt"></i></a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="create_wallet" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">New Wallet</h5>
                        <h5 v-show="editMode" class="modal-title">Update Wallet's Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update_wallet():create_wallet()">
                        <div class="modal-body">
                            <div class="form-wallet">

                                <div class="row">
                                    <div class="col-3">
                                        <label for="wallet_name"></label>
                                    </div>
                                </div>
                                <input v-model="form.wallet_name" type="text" name="wallet_name"
                                       placeholder="Wallet Name"
                                       id="wallet_name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('project_ref') }">
                                <has-error :form="form" field="project_ref"></has-error>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close
                            </button>
                            <button v-show="!editMode" :disabled="form.busy" type="submit" class="btn btn-primary">
                                Create
                            </button>
                            <button v-show="editMode" :disabled="form.busy" type="submit" class="btn btn-success">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</template>

<script>

    export default {
        data() {
            return {
                editMode: false,
                form: new Form({
                    wallet_name: '',
                    wallet_amount: 0,
                    user_id: 0,
                }),
                all_wallets: []
            }
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            /** open creating/update of wallet information**/
            open_my_modal() {
                $("#create_wallet").modal('show');
            },
            /**wallet data**/
            fetch_all_wallet() {
                this.$store.dispatch("get_wallets")
            },
            create_wallet() {
                this.$store.dispatch("save_wallets", this.form);
            }, view_wallet(payload) {

                this.$router.push({name: 'wallet-view', path: `wallet-view/${payload}`, params: {'wallet_id': payload}})
            }
        },
        computed: {
            load_all_wallet() {
                let _wallet = this.$store.getters.ALL_WALLETS;
                console.log(_wallet)
                this.all_wallets = _wallet;
                return _wallet;
            }, check_creation_status() {
                return this.$store.getters.WALLETS_CREATE_RESPONSE
            }
        },
        created() {
            this.fetch_all_wallet();
        },
        watch: {
            load_all_wallet(old, new_) {
                if (old != new_) {
                    this.all_wallets = old;
                }
            },
            // check if created
            check_creation_status(_old, _new) {
                if (_old == 1) {
                    $('#create_wallet').modal('hide');
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
