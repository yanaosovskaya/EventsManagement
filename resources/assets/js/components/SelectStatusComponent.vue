<template>
    <div>
        <form v-on:change="onSubmit" @keydown="form.errors.clear($event.target.name)">
            <select :name="fieldName" class="form-control" v-model="form[fieldName]">
                <option v-for="(option, index) in JSON.parse(options)" v-bind:value="index">
                    {{ option }}
                </option>
            </select>

            <span class="text-danger" v-if="form.errors.has(fieldName)"
                  v-text="form.errors.get(fieldName)"></span>
        </form>
    </div>
</template>

<script>
    import Form from '../form';
    import EventBus from '../event-bus';
    import { ALERT_MSG, CHANGE_STATUS } from '../constants';

    export default {
        props: {
            r: {
                type: String,
                required: true,
            },
            fieldName: {
                type: String,
                required: true,
            },
            options: {
                type: String,
                required: true,
            },
            modelValue: {
                type: String,
                required: true,
            }
        },
        data: function() {
            return {
                form: new Form({
                    [this.fieldName]: this.modelValue
                })
            }
        },
        methods: {
            onSubmit() {
                this.form.put(this.r)
                    .then(response => {
                        EventBus.$emit(CHANGE_STATUS);

                        EventBus.$emit(ALERT_MSG, {
                            message: response,
                            messageType: 'success'
                        });
                    })
                    .catch((error) => {
                        EventBus.$emit(ALERT_MSG, {
                            message: error.message,
                            messageType: 'error'
                        });
                    });
            },
        }
    }
</script>
