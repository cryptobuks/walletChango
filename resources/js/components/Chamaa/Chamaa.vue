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
                                        <span class="info-box-text">{{chama.chamaa_name}}</span>
                                        <span class="info-box-number">{{chama.members_count}} Members</span>

                                        <div class="progress">
                                            <div class="progress-bar" :style="{width: chama.members_count+'%'}"></div>
                                        </div>
                                        <span class="progress-description">
                                          30% Increase in 30 Days
                                        </span>
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
        <div class="modal fade in" id="create_user" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">


                    <div class="modal-body">

                    </div>
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
                all_chamas: []
            }
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            /** open creating/update of chamaa information**/
            open_my_modal() {

                $("#create_user").modal('show');
            },
            /**chamaa data**/
            fetch_all_chama() {
                this.$store.dispatch("getChamas")
            },
        },
        computed: {
            load_all_chama() {
                let _chamaa = this.$store.getters.ALL_CHAMAS;
                this.all_chamas = _chamaa;
                return _chamaa;

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
            }

        }
    }
</script>
