<template>
    <div class="container">
        <div class="container-fluid">

            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">{{project_details.project_name}} Project</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Box Comment -->
                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <div class="user-block">
                                            <img class="img-lg" :src="image_url" alt="User Image">
                                            <span class="username"><a
                                                href="#">Created By - {{project_details.user.name}}</a></span>
                                            <span
                                                class="description">{{project_details.project_description}}</span>
                                        </div>
                                        <!-- /.user-block -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <img class="img-responsive pad"
                                             :src="'http://192.168.43.101/walletChango/storage/app/public/upload/images/projects/original/'+project_details.image_url"
                                             alt="Photo">

                                        <h4>Amount collected {{project_details.amount_collected}} out of {{project_details.project_target_amount}}</h4>
                                        <button type="button" class="btn btn-default btn-xs"><i
                                            class="fa fa-share"></i>
                                            Invite Members
                                        </button>
                                        <span class="pull-right text-muted">Members {{project_details.members_subscribed}}</span>
                                    </div>
                                    <!-- /.box-body -->
                                    <!-- /.box-footer -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div class="col-sm-6">
                                <!-- Custom Tabs (Pulled to the right) -->
                                <div class="nav-tabs-custom">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1-1">
                                            <b>Project Description:</b>

                                            <p>{{project_details.project_details}}
                                            </p>

                                        </div>
                                        <div class="col-md-6">
                                            <!-- LINE CHART -->
                                            <div class="box box-info">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Line Chart</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div class="chart">
                                                        <canvas id="lineChart" style="height:250px"></canvas>
                                                    </div>
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                            <!-- /.box -->

                                          

                                        </div>
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- nav-tabs-custom -->
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
</script>
<script>

    export default {
        props: ['id'],
        data() {
            return {
                all_payments: [],
                project_details: {},
                image_url: "http://192.168.43.101/walletChango/storage/app/public/upload/images/projects/original/crowd_fund4.jpg"

            }
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            // fetch_payments() {
            //     this.$store.dispatch('get_payments', this.id)
            // },
            fetch_project_details() {
                this.$store.dispatch('get_project', this.id)
            }
        },
        computed: {
            // load_all_payments() {
            //     return this.all_payments = this.$store.getters.ALL_PAYMENTS
            // },
            load_project_details() {
                return this.project_details = this.$store.getters.PROJECT_DETAILS
            }
        },
        created() {
            // this.fetch_payments();
            this.fetch_project_details();
        },
        watch: {
            // load_all_payments(new_, old) {
            //     if (new_ != old) {
            //         this.all_payments = new_;
            //     }
            // },
            load_project_details(new_, old) {
                if (new_ != old) {
                    this.project_details = new_;
                }
            }

        }
    }
</script>
