<template>
    <div>
        <div class="container" v-for="(node, index) in nodesL">
            <div class="tree-menu">
                <div class="label-wrapper row">
                    <div :style="indent" :class="labelClasses" class="col-md-8">
                        <i v-if="node.nodes.length" class="fas" :class="iconClasses" @click="toggleChildren(node)"></i>
                        <span>{{ node.name }}</span>
                        <small>({{ node.type }})</small> <small v-if="node.visible">Visible - {{ node.visible }}</small>

                    </div>
                    <div class="col-md-1">
                        <i class="fas fa-arrow-up cursor-pointer" v-if="index != 0" @click="clickArrowUp(node.id)" title="Upper"></i>
                    </div>
                    <div class="col-md-1">
                        <i class="fas fa-arrow-down cursor-pointer" v-if="index != (nodesL.length - 1)" @click="clickArrowDown(node.id)" title="Lower down"></i>
                    </div>
                    <div class="col-md-1">
                        <i class="fas fa-trash-alt cursor-pointer" @click="clickDelete(node.id)"
                           title="Delete"></i>
                    </div>
                </div>
                <menu-tree
                        v-if="showChildren"
                        :nodes="node.nodes"
                        :depth="depth + 1"
                        :menu-id="menuId"
                >
                </menu-tree>
            </div>

        </div>
        <confirm v-if="confirmModal" @confirm="deleteItem" @cancel="cancelDelete"></confirm>
    </div>
</template>

<script>

    import EventBus from '../../event-bus';
    import { ALERT_MSG, NEW_MENU_ITEM } from '../../constants';
    import Form from '../../form';
    import ConfirmComponent from "../ConfirmComponent";

    export default {
        components: {ConfirmComponent},
        props: {
            nodes: {
                type: Array,
                required: false,
            },
            depth: {
                type: Number,
                required: true,
            },
            menuId: {
                type: Number,
                required: true,
            },
        },
        data: function() {
            return {
                showChildren: false,
                nodesL: this.nodes,
                form: new Form({}),
                formSorting: new Form({
                    sort: 1,
                }),
                confirmModal: false,
                itemId: '',
                prev: {},
            }
        },
        computed: {
            iconClasses() {
                return {
                    'fas fa-plus': !this.showChildren,
                    'fas fa-minus': this.showChildren
                }
            },
            labelClasses() {
                return { 'has-children': this.nodesL }
            },
            indent() {
                return { transform: `translate(${this.depth * 50}px)` }
            },
            sortedArray: function() {
                function compare(a, b) {
                    if (a.sorting < b.sorting)
                        return -1;
                    if (a.sorting > b.sorting)
                        return 1;
                    return 0;
                }

                return this.nodesL.sort(compare);
            },
        },
        methods: {
            toggleChildren(node) {
                this.showChildren = !this.showChildren;
            },
            clickDelete(id) {
                this.itemId = id;
                this.confirmModal = true;
            },
            deleteItem() {
                this.confirmModal = false;
                this.form.delete(`/admin/menu-item-tree/${this.itemId}`)
                    .then(response => {
                        location.reload();
                    })
                    .catch((error) => {
                        EventBus.$emit('ALERT_MSG', {
                            message: error.message,
                            messageType: 'error'
                        });
                    });
            },
            cancelDelete() {
                this.confirmModal = false;
                this.itemId = null;
            },
            clickArrowUp(id) {
                this.formSorting.sort = 1;
                this.updateSorting(id);
            },
            clickArrowDown(id) {
                this.formSorting.sort = 0;
                this.updateSorting(id);
            },
            updateNodes(data) {
                this.showChildren = false;
                axios.get(`/admin/menu-item-tree/${this.menuId}`)
                    .then((response) => {
                        this.nodesL = response.data.tree;
                        this.showChildren = true;
                    })
                    .catch((error) => {
                        EventBus.$emit('ALERT_MSG', {
                            message: error.message,
                            messageType: 'error'
                        });
                    });
            },
            updateSorting(id) {
                this.formSorting.put(`/admin/menu-item-sorting/${id}`)
                    .then(response => {
                        location.reload();
                    })
                    .catch((error) => {
                        EventBus.$emit('ALERT_MSG', {
                            message: error.message,
                            messageType: 'error'
                        });
                    });
            }
        },
        mounted() {
            EventBus.$on(NEW_MENU_ITEM, (data) => {
                this.updateNodes(data);
            });
        }
    }
</script>

<style>
    .tree-menu .label-wrapper {
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }
    .tree-menu .label-wrapper .has-children,
    .cursor-pointer
    {
        cursor: pointer;
    }
</style>
