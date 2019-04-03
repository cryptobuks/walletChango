<template>
    <div class="container">
        <div class="container-fluid">

                        <!-- /.row -->
            <div class="row">
                <div class="col-sm-8">
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
                                    <tr v-for="payments in all_payments">
                                        <td><a href="pages/examples/invoice.html">{{payments.payment_reference}}</a>
                                        </td>
                                        <td>{{payments.payment_amount}}</td>
                                        <td><span class="badge ">{{payments.user.name}}</span></td>
                                        <td>
                                           {{payments.project.project_name}}
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

    </div>
</template>

<script>

    export default {
        props: ['project_id'],
        data() {
            return {
                all_payments: [],
            }
        },
        mounted() {
            console.log('Component mounted.')
        }, methods: {
            fetch_payments() {
                this.$store.dispatch('get_payments', this.project_id)
            }
        },
        computed: {
            load_all_payments() {
                return this.all_payments = this.$store.getters.ALL_PAYMENTS
            }
        },
        created() {
            this.fetch_payments();
        },
        watch: {
            load_all_payments(new_, old) {
                if (new_ != old) {
                    this.all_payments = new_;
                }
            }

        }
    }
</script>
