<template>
    <div class="container">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{group_details.members_count}}</h3>
                            <p>Members</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{group_details.group_payments_total}}<sup style="font-size: 20px">Kshs</sup></h3>

                            <p>Members Contribution</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>Projects Running</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Projects Completed</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <div class="row">
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
                                    <tr v-for="membership in group_details.group_members">
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
                                        <th>User</th>
                                        <th>Project</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="payments in group_details.group_payments">
                                        <td><a href="#">{{payments.payment_reference}}</a>
                                        </td>
                                        <td>{{payments.payment_amount}}</td>
                                        <td><span class="badge ">{{payments.user.name}}</span></td>

                                        <td>
                                            {{payments.project[0].project_name}}
                                        </td>
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
            </div>
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

    export default {
        props: ['id'],
        data() {
            return {
                all_payments: [],
                group_details: [],
                form: new Form({
                    phone_no: '',
                    invite_type: 0,
                    group_id: this.id,

                }),
            }
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            open_my_modal() {
                $("#send_invite").modal('show');
            },
            fetch_payments() {
                this.$store.dispatch('get_payments', this.id)
            }, fetch_group_details() {
                this.$store.dispatch('get_group_details', this.id)
            }, sendUserInvite() {
                this.$store.dispatch("send_group_invite", this.form);
            }
        },
        computed: {
            load_all_payments() {
                return this.all_payments = this.$store.getters.ALL_PAYMENTS
            }, load_all_group_details() {
                return this.group_details = this.$store.getters.ALL_GROUP_DETAILS
            }, load_send_group_invite() {
                return this.group_details = this.$store.getters.GROUP_CREATION_RESPONSE
            }
        },
        created() {
            this.fetch_payments();
            this.fetch_group_details();
        },
        watch: {
            load_all_payments(new_, old) {
                if (new_ != old) {
                    this.all_payments = new_;
                }
            }, load_all_group_details(new_, old) {
                if (new_ != old) {
                    this.group_details = new_;

                }
            }, load_send_group_invite(new_, old) {
                if (new_ == 1) {
                    this.group_details = new_;
                    $("#send_invite").modal('hide');

                }
            }

        }
    }
</script>
