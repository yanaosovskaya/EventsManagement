<template>
    <div class="modal-c">
        <div class="modal-window">
            <span>Are you sure ?</span>
            <div class="actions">
                <button type="button" class="cancel" @click="onCancel">Cancel</button>
                <button type="button" class="confirm" @click="onConfirm">Confirm</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       methods: {
           onConfirm() {
               this.$emit("confirm");
           },
           onCancel() {
               this.$emit("cancel");
           }
       }
    }
</script>

<style>
    .modal-c {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background: rgba(0, 0, 0, .5);
        z-index: 1;
    }

    .modal-window {
        position: absolute;
        top: 50%;
        left: 50%;
        transition: .5s;
        width: 100%;
        min-width: 400px;
        max-width: 600px;
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, .5);
        transform: translate(-50%, -50%);
        padding: 1em;
        color: black;
        font-weight: bold;
        text-align: center;
    }

    .modal-window .actions {
        display: flex;
        justify-content: flex-end;
    }

    .actions button {
        font-size: inherit;
        margin: 4px;
        border: none;
        padding: 6px 8px;
        cursor: pointer;
    }

    .actions .cancel {
        background: darkred;
        color: white;
    }

    .actions .confirm {
        background: darkcyan;
        color: white;
    }

</style>
