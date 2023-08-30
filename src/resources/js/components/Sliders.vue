<template>
    <div>
        <message :confirm_delete="confirm_delete"
                 :confirm_del_slide="confirm_del_slide"
                 @hide="hide"
                 @delete_slider="delete_slider"
                 @delete_slide="delete_slide"
                 :success_message="success_message"
                 :error_message="error_message" />

        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <div :class="list_sliders_btn" class="btn mr-3"
                        v-on:click="list_sliders_func()">Список слайдеров</div>
                    <div :class="add_slider_btn" class="btn"
                            v-on:click="add_slider_func()">Добавить слайдер</div>
                </div>
            </div>
        </div>

        <transition name="fade">
            <div class="col-12" v-if="list_sliders">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Заголовок</th>
                                        <th>Slug</th>
                                        <th>Описание</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="slider in sliders">
                                        <td>{{ slider.id }}</td>
                                        <td>{{ slider.title }}</td>
                                        <td>{{ slider.slug }}</td>
                                        <td>{{ slider.description }}</td>
                                        <td>
                                            <div role="toolbar" class="btn-toolbar">
                                                <div class="btn-group btn-group-sm mr-1">
                                                    <div class="btn btn-primary" v-on:click="update_slider(slider.id, slider.title, slider.slug, slider.description)"><i class="far fa-edit"></i></div>
                                                    <div class="btn btn-dark" v-on:click="view_slides(slider.slug)"><i class="far fa-eye"></i></div>
                                                    <div class="btn btn-danger" v-on:click="confirm_delete_slider(slider.slug)"><i class="fas fa-trash-alt"></i></div>
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
<!--Добавляем слайдер-->
        <transition name="fade">
            <div class="col-12" v-if="add_slider">
                <add-slider :action="action_slider"
                            :id="id_slider"
                            :title="title_slider"
                            :slug="slug_slider"
                            :descriprion="description_slider"
                            :url_storage="url_storage_slider"
                            :url_update="url_update_slider"
                            @show_message="show_message"
                            @clear_id_slider="clear_id_slider"
                            @list_sliders_func="list_sliders_func"  :key="add_slider_key" />
            </div>
        </transition>

        <transition>
            <div v-if="view_slug">
                <slides v-bind:slug_slider="view_slug"
                        v-bind:url_get_slides="url_get_slides"
                        v-bind:url_storage_slide="url_storage_slide"
                        v-bind:url_update_slide="url_update_slide"
                        @show_message="show_message"
                        @confirm_delete_slide="confirm_delete_slide" />
            </div>
        </transition>

    </div>
</template>
<script>
    import Message from './Message.vue'
    export default {
        props: ['url_storage_slider', 'url_update_slider', 'url_get_sliders', 'url_delete_slider', 'url_get_slides', 'url_storage_slide', 'url_update_slide', 'url_delete_slide'],
        components: {
            Message
        },
        data: function() {
            return {
                confirm_delete: false,
                confirm_del_slide: false,
                delete_slug: '',
                success_message: false,
                error_message: false,
                action_slider: 'Добавить',
                list_sliders: true,
                add_slider: false,
                add_slide: false,
                list_sliders_btn: 'btn-primary',
                add_slider_btn: 'btn-outline-primary',

                id_slider: '',
                title_slider: '',
                slug_slider: '',
                description_slider: '',

                title_slide: '',
                short_slide: '',
                url_slide: '',
                description_slide: '',
                slug_slide: '',
                published_at_slide: '',
                unpublished_at_slide: '',

                sliders: null,
                view_slug: '',
                add_slider_key: true,
                del_slug_slide: '',
            }
        },

        methods: {
            show_message(type, message){
                if(type === 'error')  this.error_message = message;
                if(type === 'success')  this.success_message = message;
            },
            hide(){
                this.confirm_delete = false;
                this.confirm_del_slide = false;
                this.success_message = false;
                this.error_message = false;
            },
            view_slides(slug){
                this.view_slug = slug;
                this.sliders_of();
            },
            update_slider(id, title, slug, description){
                this.id_slider = id;
                this.title_slider = title;
                this.slug_slider = slug;
                this.description_slider = description;
                this.update_on();
            },
            confirm_delete_slider(slug){
                this.delete_slug = slug;
                this.confirm_delete = true;
            },
            confirm_delete_slide(slug, slug_slider){
                this.del_slug_slide = slug;
                this.confirm_del_slide = true;
                this.view_slug = slug_slider;
            },
            delete_slider(){
                let formData = new FormData();
                formData.append("slug", this.delete_slug);
                axios
                    .post(this.url_delete_slider, formData, {
                        responseType: 'json'
                    })
                    .then(response => {
                        let result = response.data;
                        if(!result.success){
                            this.show_message('error', result.message);
                        } else {
                            this.show_message('success', result.message);
                            setTimeout(()=>{this.list_sliders_func();}, 2000);
                        }
                    })
                    .catch(error => {
                        this.show_message('error', 'Неожиданный ответ с сервера');
                    })
            },
            delete_slide(){
                let formData = new FormData();
                formData.append("slug", this.del_slug_slide);
                axios
                    .post(this.url_delete_slide, formData, {
                        responseType: 'json'
                    })
                    .then(response => {
                        let result = response.data;
                        if(!result.success){
                            this.show_message('error', result.message);
                        } else {
                            this.show_message('success', result.message);
                            setTimeout(()=>{this.view_slides(this.view_slug);}, 2000);
                        }
                    })
                    .catch(error => {
                        this.show_message('error', 'Неожиданный ответ с сервера');
                    })
            },
            add_slider_func(){
                this.id_slider = '';
                this.action_slider = 'Добавить';
                this.title_slider = '';
                this.slug_slider = '';
                this.description_slider = '';
                this.add_slider_on();
            },
            get_sliders(){
                axios
                    .get(this.url_get_sliders, { responseType: 'json' })
                    .then(response => {
                        let result = response.data;
                        this.sliders = result.sliders;
                    })
                    .catch(error => {
                            this.show_message('error', 'Неожиданный ответ с сервера');
                        })
            },
            list_sliders_func(){
                this.list_sliders_on();
                this.get_sliders();
            },
            list_sliders_on(){
                this.list_sliders_btn = 'btn-primary';
                this.add_slider_btn = 'btn-outline-primary';
                this.add_slider = false;
                this.list_sliders = true;
                this.view_slug = false;
            },
            add_slider_on(){
                this.add_slider_key = !this.add_slider_key;
                this.list_sliders_btn = 'btn-outline-primary';
                this.add_slider_btn = 'btn-primary';
                this.list_sliders = false;
                this.add_slider = true;
                this.view_slug = false;
            },
            update_on(){
                this.list_sliders_btn = 'btn-outline-primary';
                this.add_slider_btn = 'btn-outline-primary';
                this.list_sliders = false;
                this.add_slider = true;
                this.action_slider = 'Редактировать';
                this.view_slug = false;
            },
            sliders_of(){
                this.list_sliders = false;
                this.add_slider = false;
                this.add_slider_btn = 'btn-outline-primary';
                this.list_sliders_btn = 'btn-outline-primary';
            },
            clear_id_slider(){
                this.id_slider = '';
            },
        },
        mounted() {
            this.list_sliders_func();
        }
    }
</script>

<style scoped>
 .btn-outline-primary{
     border: none;
 }
 .fade-enter-active, .fade-leave-active {
     transition: opacity 0.5s;
 }
 .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
     opacity: 0;
 }
</style>
