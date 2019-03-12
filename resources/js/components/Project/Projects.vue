<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">project

                        <button class="btn btn-success right"
                                @click="open_my_modal">
                            New project
                            <i class="nav-icon fas fa-plus-square "></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div v-for="project in all_projects" class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa- fa-3x orange"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text"><b>Projects Name:</b>{{project.project_name}}</span>
                                        <span class="info-box-number"><b>Subscribers:</b> {{project.members_subscribed}} </span>

                                        <div class="progress">
                                            <div class="progress-bar" :style="{width: project.members_count+'%'}"></div>
                                        </div>
                                        <span class="progress-description">
                                          30% Increase in 30 Days
                                        </span>
                                        <a class="btn" @click="view_project(project.id)">View<i
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
                                       placeholder="project Name"
                                       id="project_name"
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
                    project_name: '',
                    project_description: 0,
                    target_group_number: 0,
                    project_target_amount: 0,
                }),
                all_projects: []
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
            fetch_all_project() {
                this.$store.dispatch("get_projects")
            },
            create_project() {
                this.$store.dispatch("save_projects", this.form);
            }, view_project(payload) {

                this.$router.push({name: 'project-view',path:`project-view/${payload}`, params: {'project_id': payload}})
            }
        },
        computed: {
            load_all_project() {
                let _project = this.$store.getters.ALL_PROJECTS;
                this.all_projects = _project;
                return _project;
            }, check_creation_status() {
                return this.$store.getters.project_CREATION_RESPONSE
            }
        },
        created() {
            this.fetch_all_project();
        },
        watch: {
            load_all_project(old, new_) {
                if (old != new_) {
                    console.log(old)
                    this.all_projects = old;
                }
            },
            // check if created
            check_creation_status(_old, _new) {
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
