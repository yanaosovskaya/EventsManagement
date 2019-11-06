<template>
    <div class="alert"
         role="alert"
         :class="{
            'd-none': !isShown,
            'alert-success': messageType === 'success',
            'alert-warning': messageType === 'warning',
            'alert-danger': messageType === 'error'
        }">
        {{ message }}
    </div>
</template>

<script>
    /*
     Для отображения алерта из другого компонента нужно сделать

     import EventBus from '../event-bus';
     import { ALERT_MSG } from '../constants';

     EventBus.$emit('ALERT_MSG', {
         message: 'Message',
         messageType: 'success'|'warning'|'error',
         messageTime: 1000 (default 3000)
     });

     */



    import EventBus from '../event-bus';
    import {ALERT_MSG} from '../constants';

    export default {
        props: [],
        mounted() {
            EventBus.$on(ALERT_MSG, (event) => {
                this.message = event.message;
                this.messageType = event.messageType;
                this.messageTime = typeof event.messageTime !== 'undefined' && event.messageTime ? event.messageTime : 3000;
                this.showAlert();
            });
        },
        data: function() {
            return {
                isShown: false,
                messageType: '',
                message: '',
                messageTime: 3000
            }
        },

        methods: {
            showAlert() {
                this.isShown = true;
                setTimeout(() => {
                    this.isShown = false;
                }, this.messageTime);
            }
        },
    }
</script>
