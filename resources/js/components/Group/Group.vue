<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Chamaa

                        <button class="btn btn-success right"
                                @click="open_my_modal">
                            New Chamaa
                            <i class="nav-icon fas fa-plus-square "></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div v-for="chama in all_chamas" class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{chama.group_name}}</span>
                                        <span class="info-box-number">{{chama.members_count}} Members</span>

                                        <div class="progress">
                                            <div class="progress-bar" :style="{width: chama.members_count+'%'}"></div>
                                        </div>
                                        <span class="progress-description">
                                          30% Increase in 30 Days
                                        </span>
                                        <a class="btn" @click="view_group(chama.id)">View<i
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
        <div class="modal fade in" id="create_group" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">
                        <!-- form start -->
                        <h5 v-show="!editMode" class="modal-title">New Chamaa</h5>
                        <h5 v-show="editMode" class="modal-title">Update Chamaa's Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update_group():create_group()">
                        <div class="modal-body">
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-3">
                                        <label for="group_name"></label>
                                    </div>
                                </div>
                                <input v-model="form.group_name" type="text" name="group_name"
                                       placeholder="Chamaa Name"
                                       id="group_name"
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
                    group_name: '',
                    members_count: 0,
                    group_uuid: 0,
                }),
                all_chamas: []
            }
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            /** open creating/update of group information**/
            open_my_modal() {
                $("#create_group").modal('show');
            },
            /**group data**/
            fetch_all_chama() {
                this.$store.dispatch("get_chamas")
            },
            create_group() {
                this.$store.dispatch("save_chamas", this.form);
            }, view_group(payload) {

                this.$router.push({name: 'group-view',path:`group-view/${payload}`, params: {'group_id': payload}})
            }
        },
        computed: {
            load_all_chama() {
                let _group = this.$store.getters.ALL_CHAMAS;
                this.all_chamas = _group;
                return _group;
            }, check_creation_status() {
                return this.$store.getters.CHAMAA_CREATION_RESPONSE
            }
        },
        created() {
            this.fetch_all_chama();
        },
        watch: {
            load_all_chama(old, new_) {
                if (old != new_) {
                    this.all_chamas = old;
                }
            },
            // check if created
            check_creation_status(_old, _new) {
                if (_old == 1) {
                    $('#create_group').modal('hide');
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
