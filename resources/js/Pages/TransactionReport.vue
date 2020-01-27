<template>
    <layout title="View Report">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Transaction Date From</label>
                    <input v-model="query.from" type="date" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Transaction Date To</label>
                    <input v-model="query.to" type="date" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Cluster Name</label>
                    <input v-model="query.cluster" type="text" class="form-control form-control-sm" placeholder="Type cluster name here...">
                </div>
                <div class="form-group">
                    <label for="">Type Rumah</label>
                    <input v-model="query.type" ype="text" class="form-control form-control-sm" placeholder="Type rumah type here...">
                </div>
                <InertiaLink href="/transaction/report" :data="query" class="btn btn-secondary btn-sm" preserve-state>Search</InertiaLink>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <th scope="col">Document #</th>
                        <th scope="col">Cluster Name</th>
                        <th scope="col">Type Rumah</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                    </thead>
                    <template v-for="detail in details">
                        <tr :key="detail.id">
                            <td>{{ detail.transaction.document_number }}</td>
                            <td>{{ detail.cluster.name }}</td>
                            <td>{{ detail.type.name }}</td>
                            <td>{{ detail.transaction.customer.name }}</td>
                            <td>{{ detail.transaction.customer.phone }}</td>
                            <td>{{ detail.type.description }}</td>
                            <td>{{ detail.price }}</td>
                            <td>{{ detail.qty }}</td>
                            <td>{{ detail.total }}</td>
                            <td>{{ detail.transaction.date }}</td>
                        </tr>
                    </template>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a :href="'/transaction/export'+urlParam" :class="{'btn btn-secondary btn-sm': true, 'disabled': _.isEmpty(details)}" preserve-state>Export to Excel</a>
                <a href="javascript:void(0)" class="btn btn-secondary btn-sm ml-3" @click="window.print()">Print</a>
            </div>
        </div>
    </layout>
</template>

<script>
    import Layout from './Layout';

    export default {
        components: {
            Layout
        },
        props: {
            details: Array
        },
        data() {
            return {
                query: {
                    from: '',
                    to: '',
                    cluster: '',
                    type: ''
                },
                urlParam: ""
            }
        },
        mounted() {
            this.urlParam = "/?from="+this.query.from+"&to="+this.query.to+"&cluster="+this.query.cluster+"&type="+this.query.type;
        }
    }
</script>
