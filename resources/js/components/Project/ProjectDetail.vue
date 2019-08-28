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
                                            <img class="img-lg"
                                                 :src="'http://192.168.43.101/walletChango/storage/app/public/upload/images/projects/original/'+project_details.image_url"
                                                 alt="User Image">
                                            <span class="username">
<!--                                                <a href="#">Created By - {{project_details.user['name']}}</a>-->
                                            </span>
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

                                        <h4>Amount collected {{project_details.amount_collected}} out of
                                            {{project_details.project_target_amount}}</h4>
                                        <button type="button" class="btn btn-default btn-xs" @click="open_my_modal"><i
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
                                        <div class="col-md-12">
                                            <!-- LINE CHART -->
                                            <div class="col-sm-12">
                                                <h3>Bar Chart</h3>
                                                <bar-chart
                                                    id="bar" :data="bar_Data" xkey="month"
                                                    ykeys='[ "payment_amount" ]'
                                                    resize="true"
                                                    labels='[ "Android"]'
                                                    bar-colorssss='[ "#36A2EB" ]'
                                                    grid="true" grid-text-weight="bold">
                                                </bar-chart>
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
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Payments</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Amount</th>
                                        <th>Transacted on</th>
                                        <!--                                        <th>Project</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="payments in project_details.payments">
                                        <td><a href="#">{{payments.payment_reference}}</a>
                                        </td>
                                        <td>{{payments.payment_amount}}</td>
                                        <td>{{payments.paid_at}}</td>
                                        <!--                                        <td><span class="badge ">{{payments.user.name}}</span></td>-->

                                        <!--                                        <td>-->
                                        <!--                                            {{payments.project[0].project_name}}-->
                                        <!--                                        </td>-->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Paymnet</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All
                                Payments</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Members</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Member Name</th>
                                        <th>Joined At</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="membership in project_details.project_members">
                                        <td><a href="#">{{membership.user.name}}</a>
                                        </td>
                                        <td>{{membership.joined_when}}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a class="btn btn-sm btn-info float-left" @click="open_my_modal">Send Invite</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All
                                Payments</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <a @click="open_my_modal2" class="btn btn-sm btn-block btn-info float-left">Withdraw </a>
                </div>
            </div>


        </div>
        <div class="modal fade in" id="send_withdrwa" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- form start -->
                        <h5 class="modal-title">All Members will received a confirmation code</h5>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-block btn-info float-left">Withdraw </a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade in" id="send_invite" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- form start -->
                        <h5 class="modal-title">Send Invite</h5>
                    </div>
                    <form @submit.prevent="sendUserInvite()">
                        <div class="modal-body">
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-3">
                                        <label for="phone_no"></label>
                                    </div>
                                </div>
                                <input v-model="form.phone_no" type="text" name="phone_no"
                                       placeholder="Phone Number"
                                       id="phone_no"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('phone_no') }">
                                <has-error :form="form" field="phone_no"></has-error>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close
                            </button>
                            <button :disabled="form.busy" type="submit" class="btn btn-primary">
                                Invite
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
    import {BarChart, DonutChart, LineChart} from 'vue-morris'

    export default {

        props: ['id'],
        data() {
            return {

                all_payments: [],
                project_details: {},
                donutData: [
                    {label: 'Red', value: 300},
                    {label: 'Blue', value: 50},
                    {label: 'Yellow', value: 100}
                ],
                lineData:
                    [
                        {year: '2013', a: 10, b: 5},
                        {year: '2014', a: 40, b: 15},
                        {year: '2015', a: 20, b: 25},
                        {year: '2016', a: 30, b: 20},
                    ],
                form: new Form({
                    phone_no: '',
                    invite_type: 1,
                    project_id: this.id,

                }),
                barData: [],
                bar_Data: [{"month": "January", "payment_amount": 225}, {
                    "month": "February",
                    "payment_amount": 107
                }, {"month": "March", "payment_amount": 231}, {
                    "month": "April",
                    "payment_amount": 495
                }, {"month": "May", "payment_amount": 378}, {"month": "June", "payment_amount": 0}, {
                    "month": "July",
                    "payment_amount": 512
                }, {"month": "August", "payment_amount": 0}, {
                    "month": "September",
                    "payment_amount": 0
                }, {"month": "October", "payment_amount": 218}, {
                    "month": "November",
                    "payment_amount": 356
                }, {"month": "December", "payment_amount": 185}],
                //     [
                //     {'year': '2013', and: 10, },
                //     {'year': '2014', and: 10,},
                //     {'year': '2015', and: 20, },
                //     {'year': '2016', and: 40, },
                // ],
                month_list: [],
            }
        },
        components: {
            DonutChart, BarChart, LineChart,
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            open_my_modal() {
                $("#send_invite").modal('show');
            },
         open_my_modal2() {
            $("#send_withdrwa").modal('show');
        },
            // fetch_payments() {
            //     this.$store.dispatch('get_payments', this.id)
            // },
            fetch_monthly_payments() {
                this.$store.dispatch('get_monthly_payments', this.id)
            },
            fetch_project_details() {
                this.$store.dispatch('get_project', this.id)
            },
            sendUserInvite() {
                this.$store.dispatch("send_group_invite", this.form);
            }

        },
        computed: {
            // load_all_payments() {
            //     return this.all_payments = this.$store.getters.ALL_PAYMENTS
            // },
            load_monthly_payments() {
                return this.barData = JSON.stringify(this.$store.getters.PROJECT_MONTHLY_PAYMENTS)
            },
            load_project_details() {
                return this.project_details = this.$store.getters.PROJECT_DETAILS
            },
            load_send_group_invite() {
                return this.group_details = this.$store.getters.GROUP_CREATION_RESPONSE
            }
        },
        created() {
            // this.fetch_payments();
            this.fetch_project_details();
            this.fetch_monthly_payments();
        }
        ,
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
            ,
            load_monthly_payments(new_, old) {
                if (new_ != old) {
                    this.barData = new_;
                }
            },
            load_send_group_invite(new_, old) {
                if (new_ == 1) {
                    this.group_details = new_;
                    $("#send_invite").modal('hide');

                }
            }

        }
    }
</script>
