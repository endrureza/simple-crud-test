<template>
    <layout title="List Customer">
        <div class="row mb-3">
            <InertiaLink href="/customer/create" class="btn btn-success btn-sm">New Customer</InertiaLink>
            <InertiaLink href="/" class="btn btn-success btn-sm ml-3">List Transaction</InertiaLink>
        </div>
        <div class="row my-5">
            <div class="col-md-12">
                <template v-if="customers.length > 0">
                    <table class="table table-sm">
                        <thead>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                        </thead>
                        <template v-for="customer in customers">
                            <tr :key="customer.id">
                                <td>{{ customer.name }}</td>
                                <td>{{ customer.email }}</td>
                                <td>{{ customer.phone }}</td>
                            </tr>
                        </template>
                    </table>
                </template>
                <template v-else>
                    <div class="col-md-12 text-center my-5">
                        <h4 class="text-secondary">No Customer Data</h4>
                    </div>
                </template>

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
            customers: Array
        }
    }
</script>
