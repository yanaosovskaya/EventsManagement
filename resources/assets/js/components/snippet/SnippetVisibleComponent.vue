<script>
    export default {
        props: {
            pageOn: {
                type: String,
                required: true,
            },
            pageNot: {
                type: String,
                required: true,
            },
            showSlugs: {
                type: Boolean,
                required: true,
            },
            startVisible: {
                type: String,
                required: true,
            },
        },
        data: function() {
            return {
                visible: this.startVisible,
            }
        },
        methods: {
            ChangeVisible() {
                if (this.visible == this.pageOn || this.visible == this.pageNot) {
                    this.showSlugs = true;
                } else {
                    this.showSlugs = false;
                }
            }
        }
    }
</script>
