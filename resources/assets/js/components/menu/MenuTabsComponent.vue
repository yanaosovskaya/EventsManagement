<template>
    <div class="container">
        <div class="columns">

            <div class="tabs help-tabs">
                <ul id="tabsItems" class="nav nav-tabs">
                    <li class="nav-item" :class="[ tab === types[0] ? 'is-active' : '']">
                        <a class="nav-link small text-uppercase" @click="clickTab(types[0])">link</a>
                    </li>
                    <li class="nav-item" :class="[ tab === types[1] ? 'is-active' : '']">
                        <a class="nav-link small text-uppercase" @click="clickTab(types[1])">text</a>
                    </li>
                    <li class="nav-item" :class="[ tab === types[2] ? 'is-active' : '']" v-if="hasPageModule">
                        <a class="nav-link small text-uppercase" @click="clickTab(types[2])">page</a>
                    </li>
                </ul>
            </div>
            <br>
            <div class="tab-content">
                <div id="link" class="tab-pane fade" :class="[ tab === types[0] ? 'active show' : '']" v-if="tab ===types[0]">
                    <form @submit.prevent="onSubmit(formLink)" @keydown="formLink.errors.clear($event.target.name)" @change="formLink.errors.clear($event.target.name)">

                        <div class="form-group row">
                            <label for="content_i"
                                   class="col-sm-4 col-form-label text-md-right">URL</label>
                            <div class="col-md-6">
                                <input type="text" id="content_i" class="form-control"
                                       v-model="formLink.content" autofocus>

                                <span class="text-danger" v-if="formLink.errors.has('content')"
                                      v-text="formLink.errors.get('content')"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name_i"
                                   class="col-sm-4 col-form-label text-md-right">Link Caption</label>
                            <div class="col-md-6">
                                <input type="text" id="name_i" class="form-control"
                                       v-model="formLink.name">

                                <span class="text-danger" v-if="formLink.errors.has('name')"
                                      v-text="formLink.errors.get('name')"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent1"
                                   class="col-sm-4 col-form-label text-md-right">Parent</label>
                            <div class="col-md-6">
                                <select id="parent1" name="type" class="form-control" v-model="formLink.parent_id">
                                    <option v-for="(item) in items" :value=item.id>
                                        {{ item.name }}
                                    </option>
                                </select>

                                <span class="text-danger" v-if="formLink.errors.has('parent_id')"
                                      v-text="formLink.errors.get('parent_id')"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="visible1"
                                   class="col-sm-4 col-form-label text-md-right">Visible</label>
                            <div class="col-md-6">
                                <select id="visible1" name="type" class="form-control" v-model="formLink.visible">
                                    <option v-for="(item, key) in visibleStatuses" :value=key>
                                        {{ item }}
                                    </option>
                                </select>

                                <span class="text-danger" v-if="formLink.errors.has('visible')"
                                      v-text="formLink.errors.get('visible')"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-primary" :disabled="formLink.errors.any()">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="text" class="tab-pane fade" :class="[ tab === types[1] ? 'active show' : '']" v-if="tab ===types[1]">
                    <form @submit.prevent="onSubmit(formText)" @keydown="formText.errors.clear($event.target.name)" @change="formText.errors.clear($event.target.name)">

                        <div class="form-group row">
                            <label for="name_t"
                                   class="col-sm-4 col-form-label text-md-right">Caption</label>
                            <div class="col-md-6">
                                <input type="text" id="name_t" class="form-control"
                                       v-model="formText.name">

                                <span class="text-danger" v-if="formText.errors.has('name')"
                                      v-text="formText.errors.get('name')"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent2"
                                   class="col-sm-4 col-form-label text-md-right">Parent</label>
                            <div class="col-md-6">
                                <select id="parent2" name="type" class="form-control" v-model="formText.parent_id">
                                    <option v-for="(item) in items" :value=item.id>
                                        {{ item.name }}
                                    </option>
                                </select>

                                <span class="text-danger" v-if="formText.errors.has('parent_id')"
                                      v-text="formText.errors.get('parent_id')"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="visible2"
                                   class="col-sm-4 col-form-label text-md-right">Visible</label>
                            <div class="col-md-6">
                                <select id="visible2" name="type" class="form-control" v-model="formText.visible">
                                    <option v-for="(item, key) in visibleStatuses" :value=key>
                                        {{ item }}
                                    </option>
                                </select>

                                <span class="text-danger" v-if="formText.errors.has('visible')"
                                      v-text="formText.errors.get('visible')"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-primary" :disabled="formText.errors.any()">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="page" class="tab-pane fade" :class="[ tab === types[2] ? 'active show' : '']" v-if="tab ===types[2]">
                    <form @submit.prevent="onSubmit(formPage)" @keydown="formPage.errors.clear($event.target.name)" @change="formPage.errors.clear($event.target.name)">

                        <div class="form-group row">
                            <label for="content_p"
                                   class="col-sm-4 col-form-label text-md-right">Page</label>
                            <div class="col-md-6">
                                <select id="content_p" name="content" class="form-control" v-model="formPage.content">
                                    <option v-for="(page) in pages" :value=page.id>
                                        {{ page.name }} <small>(/{{ page.slug }})</small>
                                    </option>
                                </select>

                                <span class="text-danger" v-if="formPage.errors.has('content')"
                                      v-text="formPage.errors.get('content')"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent3"
                                   class="col-sm-4 col-form-label text-md-right">Parent</label>
                            <div class="col-md-6">
                                <select id="parent3" name="type" class="form-control" v-model="formPage.parent_id">
                                    <option v-for="(item) in items" :value=item.id>
                                        {{ item.name }}
                                    </option>
                                </select>

                                <span class="text-danger" v-if="formPage.errors.has('parent_id')"
                                      v-text="formPage.errors.get('parent_id')"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-primary" :disabled="formPage.errors.any()">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</template>
<script>

    import Form from '../../form';
    import EventBus from '../../event-bus';
    import { ALERT_MSG, NEW_MENU_ITEM } from '../../constants';

    export default {
        props: {
            hasPageModule: {
                type: Boolean,
                required: true,
            },
            menuId: {
                type: Number,
                required: true,
            },
            types: {
                type: Array,
                required: true,
            },
            visibleStatuses: {
                type: Object,
                required: true,
            },
            visibleDefault: {
                type: Number,
                required: true,
            },
            items: {
                type: Array,
                required: false,
            },
            pages: {
                type: Array,
                required: true,
            },
        },
        data: function() {
            return {
                tab: this.types[0],
                formLink: new Form({
                    name: '',
                    content: '',
                    menu_id: this.menuId,
                    type: this.types[0],
                    parent_id: '',
                    visible: this.visibleDefault,
                }),
                formText: new Form({
                    name: '',
                    content: '',
                    menu_id: this.menuId,
                    type: this.types[1],
                    parent_id: '',
                    visible: this.visibleDefault,
                }),
                formPage: new Form({
                    name: '',
                    content: '',
                    menu_id: this.menuId,
                    type: this.types[2],
                    parent_id: '',
                    visible: this.visibleDefault,
                }),
                tree: [],
            }
        },
        methods: {
            onSubmit(form) {
                if (form.type == this.types[2]) {
                    let filter = this.pages.filter(p => p.id === form.content);
                    form.name = filter.length > 0 ? filter[0].name : '';
                    form.visible = filter.length > 0 ? filter[0].visible : this.visibleDefault;
                }

                form.post('/admin/menu-item')
                    .then(response => {
                        this.emitMethod(response);
                        form.name = '';
                        form.content = '';
                        form.parent_id = '';
                        form.visible = this.visibleDefault;
                        // location.reload();
                    })
                    .catch((error) => {
                        EventBus.$emit('ALERT_MSG', {
                            message: error.message,
                            messageType: 'error'
                        });
                    });
            },
            clickTab(nameTab) {
                this.tab = nameTab;
            },
            emitMethod (response) {
                EventBus.$emit(NEW_MENU_ITEM, response);
            },
        },
        mounted() {
            //
        }
    }
</script>
<style lang="css" scoped>
    .help-tabs {
        margin-bottom: 10px !important;
    }
    .tabs li.is-active a {
        border-bottom-color: #000000;
        color: #7763A9;
        border-bottom: 3px solid;
        font-weight: bold;
    }
    code, pre {
        color: #1b1e21 !important;
        background-color: white !important;
    }
</style>