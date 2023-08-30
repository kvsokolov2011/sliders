<template>
    <div>
        <transition>
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-body">
                        <button class="btn" :class="list_slides_btn_class"
                                type="button"
                                v-on:click="list_slides_on()">Список слайдов</button>
                        <button class="btn" :class="add_slide_btn_class"
                                type="button"
                                v-on:click="form_slide_on()">Добавить слайд</button>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="fade">
            <div class="col-12" v-if="list_slides_show">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Название</th>
                                    <th>Заголовок</th>
                                    <th>Адресная строка</th>
                                    <th>Ссылка со слайда</th>
                                    <th>Начало показа слайда</th>
                                    <th>Окончание показа слайда</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="slide in slides">
                                        <td>{{ slide.id }}</td>
                                        <td>{{ slide.title }}</td>
                                        <td>{{ slide.short }}</td>
                                        <td>{{ slide.slug }}</td>
                                        <td>{{ slide.url }}</td>
                                        <td>{{ slide.published_at }}</td>
                                        <td>{{ slide.unpublished_at }}</td>
                                        <td>
                                            <div role="toolbar" class="btn-toolbar">
                                                <div class="btn-group btn-group-sm mr-1">
                                                    <div class="btn btn-primary" v-on:click="update_slide(slide)"><i class="far fa-edit"></i></div>
                                                    <div class="btn btn-dark"><i class="far fa-eye"></i></div>
                                                    <div class="btn btn-danger" v-on:click="del_slide(slide.slug)"><i class="fas fa-trash-alt"></i></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <!--Добавляем слайд-->
        <transition name="fade">
            <div class="col-12" v-if="form_slide_show">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <h2 class="h4 mb-3">{{ action }} слайд</h2>
                            <div v-for="input in inputs" :key="input.name" class="form-group mr-md-3">
                                <label :for="input.name">{{ input.label }}</label>
                                <input v-bind:type="input.type"  :id="input.name" v-model="input.value" class="form-control" />
                            </div>


<!--                            <div class="form-group">-->
<!--                                <Editor id="d1" v-model="proba" :other_options="options"></Editor>-->
<!--                            </div>-->

                            <Editor
                                api-key="no-api-key"
                                tinymce-script-src="http://localhost:8000/lang/initTynyMCE.js"
                                init="{
                                plugins: 'lists link image table code help wordcount',
                                menubar: true,
                                skin: 'oxide-dark',
                                content_css: 'dark',
                                branding: false
                            }"
                            />





                            <div class="form-group">
                                <label for="custom-file-input">Изображение: </label><br>
                                <input type="file" id="image" ref="image" name="image" v-on:change="imageUpload()" />
                            </div>
                            <button class="btn btn-success"
                                    type="button"
                                    v-on:click="storage_slide()">Сохранить слайд</button>
                        </form>
                    </div>
                </div>
            </div>
        </transition>

    </div>
</template>
<script>
import Editor from '@tinymce/tinymce-vue'
import Message from "./Message.vue";
export default {
    emits: ['show_message', 'confirm_delete_slide'],
    props: ['slug_slider', 'url_get_slides', 'url_storage_slide', 'url_update_slide'],
    components: {
        Message,
        Editor,
    },
    data: function() {
        return {
            add_slide_btn_class: 'btn-outline-primary',
            list_slides_btn_class: 'btn-primary',
            list_slides_show: true,
            form_slide_show: false,
            image: null,
            slides: null,
            id_slide: '',
            action: 'Добавить',
            inputs: [
                        { label: 'Название слайда: ', type: 'text', name: 'title', value: ''},
                        { label: 'Заголовок слайда: ', type: 'text', name: 'short', value: ''},
                        { label: 'Адресная строка: ', type: 'text', name: 'slug', value: ''},
                        { label: 'Ссылка со слайда: ', type: 'text', name: 'url', value: ''},
                        { label: 'Описание слайда: ', type: 'text', name: 'description', value: ''},
                        { label: 'Дата начала показа: ', type: 'text', name: 'published_at', value: ''},
                        { label: 'Дата окончания показа: ', type: 'text', name: 'unpublished_at', value: ''},
                    ],
            proba: '',
            options: {
                language_url: 'http://localhost:8000/lang/ru/langs/ru.js' //This url points to location of persian language file.
            },
        }
    },

    methods: {
        update_slide(slide){
            this.action = 'Редактировать';
            this.form_slide_set();
            this.add_slide_btn_class = 'btn-outline-primary';
            this.id_slide = slide.id;
            for(let key in this.inputs){
                if(slide[this.inputs[key].name])  this.inputs[key].value = slide[this.inputs[key].name];
                if(!slide[this.inputs[key].name])  this.inputs[key].value = '';
            }
        },
        clear_form(){
            this.image = null;
            for (let key in this.inputs){
                this.inputs[key].value = '';
            }
        },
        del_slide(slug){
            this.$emit('confirm_delete_slide' , slug , this.slug_slider);
        },
        imageUpload(){
            this.image = this.$refs.image.files[0];
        },
        form_slide_on(){
            this.action = "Добавить";
            this.form_slide_set();
        },
        form_slide_set(){
            this.list_slides_btn_class = 'btn-outline-primary';
            this.add_slide_btn_class = 'btn-primary';
            this.form_slide_show = true;
            this.list_slides_show = false;
            this.id_slide = '';
            this.clear_form();
        },
        list_slides_on(){
            this.list_slides_set();
            this.get_slides(this.slug_slider);
        },
        list_slides_set(){
            this.add_slide_btn_class = 'btn-outline-primary';
            this.list_slides_btn_class = 'btn-primary';
            this.form_slide_show = false;
            this.list_slides_show = true;
        },
        get_slides(slug_slider){
            let formData = new FormData();
            formData.append("slug_slider", slug_slider);
            axios
                .post(this.url_get_slides, formData, {
                    responseType: 'json'
                })
                .then(response => {
                    let result = response.data;
                    this.slides = result.slides;
                })
                .catch(error => {
                    this.$emit('show_message', 'error', 'Неожиданный ответ с сервера');
                })
        },
        storage_slide(){
            let formData = new FormData();
            if(this.id_slide === '') {
                formData.append("slug_slider", this.slug_slider);
                for(let key in this.inputs){
                    formData.append(this.inputs[key].name, this.inputs[key].value);
                }
                formData.append("image", this.image);

                axios
                    .post(this.url_storage_slide, formData, {
                       responseType: 'json',
                       contentType: 'multipart/form-data',
                    })
                    .then(response => {
                        let result = response.data;
                        if(!result.success){
                            this.$emit('show_message', 'error' , result.message );
                        } else {
                            this.$emit('show_message', 'success', result.message);
                            this.clear_form();
                            setTimeout(()=>{this.list_slides_on();}, 2000);
                        }
                    })
                    .catch(error => {
                        this.$emit('show_message', 'error', 'Неожиданный ответ с сервера');
                    })
            } else {
                formData.append("id", this.id_slide);
                for(let key in this.inputs){
                    formData.append(this.inputs[key].name, this.inputs[key].value);
                }
                formData.append("image", this.image);
                axios
                    .post(this.url_update_slide, formData, {
                        responseType: 'json'
                    })
                    .then(response => {
                        let result = response.data;
                        if(!result.success){
                            this.$emit('show_message', 'error', result.message);
                        } else {
                            this.$emit('show_message', 'success', result.message);
                            this.clear_form();
                            setTimeout(()=>{this.list_slides_on();}, 2000);
                        }
                    })
                    .catch(error => {
                        this.$emit('show_message', 'error', 'Неожиданный ответ с сервера');
                    })
                this.id_slider = '';
            }
        },
    },
    mounted() {
        this.list_slides_on();
    }
}

</script>
<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
}
.btn-outline-primary{
    border: none;
}
</style>
