<template>
    <div :class="['alert', 'alert-'+type, 'alert-flash']" role="alert" v-show="show">
        <strong>{{ body }}</strong>
    </div>
</template>

<script>
    export default {
        props: ['message', 'type'],

        data() {
            return {
                body: '',
                show: false
            }
        },

        // watch: {
        //     message(){
        //         this.flash(this.message);
        //     }
        // },

        created() {
            if (this.message) {
                this.flash(this.message);
            }
        },

        methods: {
            flash(message) {
                this.body = message;
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        top: 25px;
    }
</style>
