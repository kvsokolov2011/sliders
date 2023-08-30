<template>
    <div>
        <div class="bg-transparent mask" v-if="confirm_delete"></div>
        <transition name="fade">
            <div class="col-12 mb-2 p-3 h4 message d-flex justify-content-center align-items-center" style="background-color: #2dc26b" v-if="success_message">{{ success_message }}</div>
            <div class="col-12 mb-2 p-3 h4 message d-flex justify-content-center align-items-center" style="background-color: #ff0000" v-if="error_message">{{ error_message }}</div>
            <div class="col-12 mb-2 p-3 h4 message d-flex flex-column justify-content-center align-items-center" style="background-color: #fff" v-if="confirm_delete">
                <div class="h4 mb-3">Действительно удалить слайдер?</div>
                <div>
                    <div class="btn btn-danger mr-3" v-on:click="del_slider();">Удалить</div>
                    <div class="btn btn-outline-success"  v-on:click="hide();">Отмена</div>
                </div>
            </div>
            <div class="col-12 mb-2 p-3 h4 message d-flex flex-column justify-content-center align-items-center" style="background-color: #fff" v-if="confirm_del_slide">
                <div class="h4 mb-3">Действительно удалить слайд?</div>
                <div>
                    <div class="btn btn-danger mr-3" v-on:click="del_slide();">Удалить</div>
                    <div class="btn btn-outline-success"  v-on:click="hide();">Отмена</div>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    emits: ['hide', 'delete_slider', 'delete_slide'],
    props: ['confirm_delete', 'delete_slug', 'success_message', 'error_message', 'confirm_del_slide'],
    data: function() {
        return {
        }
    },
    watch:{
        success_message: function(){ this.show_message(); },
        error_message: function(){ this.show_message(); },
    },
    methods: {
        show_message(){
            setTimeout(()=>{ this.hide(); }, 3000);
        },
        del_slider(){
            this.hide();
            this.$emit('delete_slider');
        },
        del_slide(){
            this.hide();
            this.$emit('delete_slide');
        },
        hide(){
            this.$emit("hide");
        },
    },
}

</script>

<style scoped>
.btn-outline-primary{
    border: none;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
}
.message{
    position: fixed;
    top: 40%;
    left: 33%;
    width: 33%;
    height: 20%;
    z-index: 10000;
    border: 0.0625rem solid #444;
}
.mask{
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    z-index: 1000;
}
</style>
