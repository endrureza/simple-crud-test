<template>
    <layout title="Create New Sales Transaction">
        <form @submit.prevent="store">
            <div class="row mb-3">
                <template v-if="!_.isEmpty($page.errors)">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Whoops!</strong> Something Error.
                            <ul v-for="error in $page.errors" :key="'error' + error">
                                <li>
                                    {{ error[0] }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </template>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Document Number</label>
                        <input v-model="form.transaction_number" type="text" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Transaction Date</label>
                        <input v-model="form.transaction_date" type="text" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Customer <span class="text-danger">*</span></label>
                        <select v-model="form.customer.id" class="form-control form-control-sm" @change="selectCustomer">
                            <option value="">Select Customer</option>
                            <option :value="customer.id" v-for="customer in customers" :key="customer.id">{{ customer.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Customer Address</label>
                        <textarea id="customer-address" v-model="form.customer.address" cols="30" rows="10" class="form-control form-control-sm" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Telephone</label>
                        <input v-model="form.customer.phone" type="text" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Email Address</label>
                        <input v-model="form.customer.email" type="text" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Notes</label>
                        <textarea id="notes" v-model="form.notes" cols="30" rows="10" class="form-control form-control-sm" placeholder="Type notes here..."></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 class="text-secondary">Detail Item</h4>
                    <table class="table table-sm">
                        <thead>
                            <th scope="col">ID</th>
                            <th scope="col">Cluster Name</th>
                            <th scope="col">Type Rumah</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                            <!-- <th scope="col">Edit</th> -->
                            <th scope="col">Delete</th>
                        </thead>
                        <template v-for="detail in form.details">
                            <tr :key="detail.id">
                                <td>{{ detail.id }}</td>
                                <td>{{ detail.cluster_name }}</td>
                                <td>{{ detail.type_name }}</td>
                                <td>{{ detail.description }}</td>
                                <td>{{ detail.price }}</td>
                                <td>{{ detail.qty }}</td>
                                <td>{{ detail.total }}</td>
                                <!-- <td>{{ }}</td> -->
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" @click="deleteDetail(detail.id)">Delete</a>
                                </td>
                            </tr>
                        </template>
                        <hr>
                        <tr>
                            <td colspan="2">
                                <select v-model="selectedDetail.cluster_id" class="form-control" @change="getTypes">
                                    <option value="">Select Cluster</option>
                                    <option :value="cluster.id" v-for="cluster in clusters" :key="'cluster' + cluster.id">{{ cluster.name }}</option>
                                </select>
                            </td>
                            <td>
                                <select v-model="selectedDetail.type_id" class="form-control" :disabled="selectedDetail.cluster_id == ''" @change="selectType">
                                    <option value="">Select Type</option>
                                    <option :value="type.id" v-for="type in types" :key="'type' + type.id">{{ type.name }}</option>
                                </select>
                            </td>
                            <td>
                                <input v-model="selectedDetail.description" type="text" class="form-control" placeholder="description..." readonly>
                            </td>
                            <td>
                                <input v-model="selectedDetail.price" type="text" class="form-control" placeholder="price..." readonly>
                            </td>
                            <td>
                                <input v-model="selectedDetail.qty" type="number" class="form-control" @change="calculateTotal">
                            </td>
                            <td>
                                <input v-model="selectedDetail.total" type="number" class="form-control" readonly>
                            </td>
                            <td colspan="2">
                                <a href="javascript:void(0)" :class="{'btn btn-secondary btn-sm': true, 'disabled': !selectedDetail.qty || !selectedDetail.cluster_id || !selectedDetail.type_id}" @click="addDetail">Add</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 class="text-secondary">Grand Total : Rp. {{ grandTotal | convertNumeral }}</h4>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <button type="submit" :class="{'btn btn-primary btn-sm': true, 'disabled': is_saving}">{{ is_saving ? 'Saving...':'Save' }}</button>
                    <InertiaLink href="/" :class="{'btn btn-secondary btn-sm':true, 'disabled': is_saving}">Cancel</InertiaLink>
                </div>
            </div>
        </form>
    </layout>
</template>

<script>
    import Layout from './Layout';

    export default {
        components: {
            Layout
        },
        computed: {
            grandTotal: function() {
                return _.sumBy(this.form.details, function(arr) {
                    return arr.total;
                });
            }
        },
        filters: {
            convertNumeral(val) {
                return numeral(val).format('0,0');
            }
        },
        data() {
            return {
                is_saving: false,
                form: {
                    transaction_number: Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5) + '/' + moment().format('YYYYMMDDhhmmss'),
                    transaction_date: moment().format('YYYY-MM-DD hh:mm:ss'),
                    customer: {
                        id: '',
                        address: '',
                        phone: '',
                        email: ''
                    },
                    notes: '',
                    details: []
                },
                selectedDetail: {
                    cluster_id: '',
                    cluster_name: '',
                    type_id: '',
                    type_name: '',
                    description: '',
                    price: '',
                    qty: '',
                    total: ''
                },
                customers: [],
                clusters: [],
                types: []
            }
        },
        mounted() {
            this.getCustomers();
            this.getClusters();
        },
        methods: {
            getCustomers() {
                axios({
                    method: 'get',
                    url: '/customers'
                })
                .then((res) => {
                    let data = res.data.data

                    return this.$set(this, 'customers', data);
                })
            },
            selectCustomer() {
                let customer = _.find(this.customers, {'id':this.form.customer.id});

                this.form.customer.address = customer.address;
                this.form.customer.phone = customer.phone;
                this.form.customer.email = customer.email;
            },
            getClusters() {
                axios({
                    method: 'get',
                    url: '/clusters'
                })
                .then((res) => {
                    let data = res.data.data

                    return this.$set(this, 'clusters', data);
                })
            },
            getTypes() {
                let cluster = _.find(this.clusters, {'id': this.selectedDetail.cluster_id});

                this.selectedDetail.cluster_name = cluster.name;

                return this.$set(this, 'types', cluster.types);
            },
            selectType() {
                let type = _.find(this.types, {'id': this.selectedDetail.type_id});

                this.selectedDetail.type_name = type.name;

                this.selectedDetail.description = type.description;
                this.selectedDetail.price = type.price;
            },
            addDetail() {
                this.form.details.push({
                    id: this.selectedDetail.cluster_id,
                    cluster_id: this.selectedDetail.cluster_id,
                    cluster_name: this.selectedDetail.cluster_name,
                    type_id: this.selectedDetail.type_id,
                    type_name: this.selectedDetail.type_name,
                    price: this.selectedDetail.price,
                    qty: this.selectedDetail.qty,
                    total: this.selectedDetail.total
                });

                return this.$set(this, 'selectedDetail', {
                    cluster_id: '',
                    cluster_name: '',
                    type_id: '',
                    type_name: '',
                    description: '',
                    price: '',
                    qty: '',
                    total: ''
                });
            },
            deleteDetail(id) {
                return this.form.details = _.filter(this.form.details, function(arr) {
                    return arr.id != id;
                });
            },
            calculateTotal(){
                return this.selectedDetail.total = this.selectedDetail.qty * this.selectedDetail.price;
            },
            store() {
                this.is_saving = true;
                this.$inertia.post('/transaction',this.form)
                .then(() => {
                    this.is_saving = false;
                });
            }
        }
    }
</script>
