<template>
    <layout title="List Transaction">
        <div class="row mb-3">
            <InertiaLink href="/transaction/create" class="btn btn-success btn-sm">New Transaction</InertiaLink>
            <InertiaLink href="/customer" class="btn btn-success btn-sm ml-3">List Customer</InertiaLink>
            <InertiaLink href="/transaction/report" class="btn btn-success btn-sm ml-3">View Report</InertiaLink>
        </div>
        <div class="row my-3">
            <template v-if="transactions.length > 0">
                <div class="col-md-12">
                    <table class="table table-sm">
                        <thead>
                            <th scope="col">Document #</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Date</th>
                        </thead>
                        <template v-for="transaction in transactions">
                            <tr>
                                <td>{{ transaction.document_number }}</td>
                                <td>{{ transaction.customer.name }}</td>
                                <td>{{ transaction.date }}</td>
                            </tr>
                        </template>
                    </table>
                </div>
            </template>
            <template v-else>
                <div class="col-md-12 text-center my-5">
                    <h4 class="text-secondary">No Transaction Data</h4>
                </div>
            </template>
        </div>
    </layout>
</template>

<script>
    import Layout from './Layout';

    export default {
        components: {
            Layout,
        },
        props: {
            transactions: Array
        }
    }
</script>
