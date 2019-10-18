<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Transacted on</th>
                                <th>BY</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tr v-for="all_transaction in all_transactions">
                                <td>{{all_transaction.id}}</td>
                                <td>{{all_transaction.amount}}</td>
                                <td>{{all_transaction.transaction_at}}</td>
                                <td>{{all_transaction.user.name}}</td>
                                <td>{{all_transaction.reference}}</td>
                            </tr>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
        <div class="modal fade in" id="create_project" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">New project</h5>
                        <h5 v-show="editMode" class="modal-title">Update project's Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update_project():create_project()">
                        <div class="modal-body">
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-3">
                                        <label for="project_name"></label>
                                    </div>
                                </div>
                                <input v-model="form.project_name" type="text" name="project_name"
                                       placeholder="Project Name"
                                       id="project_name"
                                       required
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('project_ref') }">
                                <has-error :form="form" field="project_ref"></has-error>
                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-3">
                                        <label for="project_description"></label>
                                    </div>
                                </div>
                                <input v-model="form.project_description" type="text" name="project_description"
                                       placeholder="Project Description"
                                       id="project_description"
                                       required
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('project_description') }">
                                <has-error :form="form" field="project_description"></has-error>
                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-3">
                                        <label for="project_description"></label>
                                    </div>
                                </div>
                                <input v-model="form.project_details" type="text" name="project_details"
                                       placeholder="Project Detailed Description"
                                       id="project_details"
                                       required
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('project_description') }">
                                <has-error :form="form" field="project_description"></has-error>
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
                    project_name: '',
                    project_description: '',
                    project_details: '',
                    target_group_number: 0,
                    project_target_amount: 0,
                }),
                all_transactions: [],
                image_url: "http://192.168.43.101/walletChango/storage/app/public/upload/images/projects/original/jesuHoffman_1559488427.jpg"
            }
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            /** open creating/update of project information**/
            open_my_modal() {
                $("#create_project").modal('show');
            },
            /**project data**/
            fetch_all_transactions() {
                this.$store.dispatch("get_transactions")
            },
            create_project() {
                this.$store.dispatch("save_projects", this.form);
            }, view_project(payload) {

                this.$router.push({
                    path: `project-view/${payload}`,
                    params: {project_id: payload}
                })
            }
        },
        computed: {
            load_all_transactions() {
                let _all_transactions = this.$store.getters.ALL_TRANSACTIONS;
                this.all_transactions = _all_transactions;
                console.log(this.all_transactions)
                return _all_transactions;
            }, check_creation_status() {
                return this.$store.getters.PROJECTS_CREATION_RESPONSE
            }
        },
        created() {
            this.fetch_all_transactions();
        },
        watch: {
            load_all_transactions(old, new_) {
                if (old != new_) {
                    this.all_transactions = old;
                    $('#create_project').modal('hide');
                }
            },
            // check if created
            check_creation_status(_old, _new) {
                console.log("old_" + old)
                console.log("nw_" + _new)

                if (_old == 1) {
                    $('#create_project').modal('hide');
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
