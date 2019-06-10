<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Project

                        <button class="btn btn-success right float-right"
                                @click="open_my_modal">
                            New Project
                            <i class="nav-icon fas fa-plus-square "></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div v-for="project in all_projects" class="col-md-4 col-sm-4 ">
                                <div class="info-box ">

                                    <div class="box box-widget widget-user">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-black"
                                             :style="{ backgroundImage: 'url( http://192.168.43.101/walletChango/storage/app/public/upload/images/projects/original/' + project.image_url + ')'}">
                                            <h5 class="widget-user-username">{{project.project_name}}</h5>
                                            <h5 class="widget-user-desc">Project Name</h5>

                                        </div>

                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header"> {{project.amount_collected}} of
                                                            {{project.project_target_amount}}</h5>
                                                        <span class="description-text">Amount Raised</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">
                                                            {{project.members_subscribed}}</h5>
                                                        <span class="description-text">Members</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4">
                                                    <div class="description-block">
                                                        <h5 class="description-header">35</h5>
                                                        <span class="description-text">PRODUCTS</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <div class="row">
                                                <div class="box-footer box-comments" style="margin:20px">
                                                    <div class="box-comment">
                                                        <!-- User image -->
                                                        <img class="img-circle img-sm"
                                                             :src="'http://192.168.43.101/walletChango/storage/app/public/upload/images/projects/original/'+project.image_url"
                                                             alt="User Image">

                                                        <div class="comment-text">
                                                              <span class="username">
                                                                  Project Description                                                                <span
                                                                  class="text-muted pull-right"></span>
                                                              </span><br/>
                                                            {{project.project_description}}
                                                        </div>
                                                        <!-- /.comment-text -->
                                                    </div>
                                                    <!-- /.box-comment -->

                                                </div>

                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <div class="row" style=" margin:20px">
                                            <a class="btn btn-block btn-outline-success "
                                               @click="view_project(project.id)">View</a>
                                        </div>
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
                all_projects: [],
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
            fetch_all_project() {
                this.$store.dispatch("get_projects")
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
