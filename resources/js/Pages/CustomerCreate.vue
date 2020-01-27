<template>
    <layout title="New Customer">
        <form @submit.prevent="store">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input v-model="form.name" type="text" :class="{'form-control form-control-sm': true, 'is-invalid': $page.errors.name}" placeholder="Type name here...">
                        <small class="text-danger" v-if="$page.errors.name">
                            {{ $page.errors.name[0] }}
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input v-model="form.email" type="text" :class="{'form-control form-control-sm': true, 'is-invalid': $page.errors.email}" placeholder="Type email here...">
                        <small class="text-danger" v-if="$page.errors.email">
                            {{ $page.errors.email[0] }}
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="">Phone <span class="text-danger">*</span></label>
                        <input v-model="form.phone" type="text" :class="{'form-control form-control-sm': true, 'is-invalid': $page.errors.phone}" placeholder="Type phone here...">
                        <small class="text-danger" v-if="$page.errors.phone">
                            {{ $page.errors.phone[0] }}
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="">Address <span class="text-danger">*</span></label>
                        <textarea v-model="form.address" cols="30" rows="10" :class="{'form-control form-control-sm': true, 'is-invalid': $page.errors.address}" placeholder="Type address here..."></textarea>
                        <small class="text-danger" v-if="$page.errors.address">
                            {{ $page.errors.address[0] }}
                        </small>
                    </div>
                    <button type="submit" :class="{'btn btn-success btn-sm':true, 'disabled': is_saving}">{{ is_saving ? 'Saving...':'Save' }}</button>
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
        data() {
            return {
                is_saving: false,
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    address: ''
                }
            }
        },
        methods: {
            store() {
                this.is_saving = true;

                this.$inertia.post('/customer',this.form)
                .then(() => this.is_saving = false);
            }
        }
    }
</script>

