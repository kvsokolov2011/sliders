<template>
    <div class="card">
        <div class="card-body">
            <form>
                <h2 class="h4 mb-3">{{ action }} слайдер</h2>
                <input hidden type="text" v-model="id_slider" />
                <div class="form-group mr-md-3">
                    <label>Название слайдера:</label>
                    <input type="text" v-model="title_slider" class="form-control" />
                </div>
                <div class="form-group mr-md-3">
                    <label>Адресная строка:</label>
                    <input type="text" v-model="slug_slider" class="form-control" />
                </div>
                <div class="form-group mr-md-3">
                    <label>Описание слайдера:</label>
                    <input type="text" v-model="description_slider" class="form-control" />
                </div>
                <button class="btn btn-success"
                        type="button"
                        v-on:click="storage_slider()">Сохранить слайдер</button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    emits: ['show_message', 'clear_id_slider', 'list_sliders_func'],
    props: ['action', 'id', 'title', 'slug', 'description', 'url_storage', 'url_update'],
    data: function() {
        return {
            id_slider: this.id,
            title_slider: this.title,
            slug_slider: this.slug,
            description_slider: this.description,
        }
    },
    methods: {
        storage_slider(){
            if(this.id_slider === '') {
                let formData = new FormData();
                formData.append("title", this.title_slider);
                formData.append("slug", this.slug_slider);
                formData.append("description", this.description_slider);
                axios
                    .post(this.url_storage, formData, {
                        responseType: 'json'
                    })
                    .then(response => {
                        let result = response.data;
                        if(!result.success){
                            this.$emit("show_message" ,'error', result.message);
                        } else {
                            this.$emit("show_message", 'success', result.message);
                            setTimeout(()=>{this.$emit('list_sliders_func'); }, 3000);
                        }
                    })
                    .catch(error => {
                        this.$emit("show_message", 'error', 'Неожиданный ответ с сервера');
                    })
            } else {
                let formData = new FormData();
                formData.append("id", this.id_slider);
                formData.append("title", this.title_slider);
                formData.append("slug", this.slug_slider);
                formData.append("description", this.description_slider);
                axios
                    .post(this.url_update, formData, {
                        responseType: 'json'
                    })
                    .then(response => {
                        let result = response.data;
                        if(!result.success){
                            this.$emit('show_message', 'error', result.message);
                        } else {
                            this.$emit('show_message', 'success', result.message);
                            setTimeout(()=>{this.$emit('list_sliders_func'); }, 3000);
                        }
                    })
                    .catch(error => {
                        this.$emit('show_message', 'error', 'Неожиданный ответ с сервера');
                    })
                this.$emit('clear_id_slider');
            }
        },
    },
}
</script>
