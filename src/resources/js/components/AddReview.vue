<template>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModalWindow">Добавить отзыв</button>
        <!--Modal window-->
        <div class="modal fade" tabindex="-1" role="dialog" id="reviewModalWindow" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Оставить отзыв</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createReviewForm">
                            <div class="alert mt-3" :class="{'alert-danger': error, 'alert-success': !error}" role="alert" v-if="messages.length">
                                <template v-for="message in messages">
                                    {{ message }}
                                    <br>
                                </template>
                            </div>
                            <!--Пользователье известен-->
                            <input type="hidden"
                                   name="user_id"
                                   v-if="this.userAuth"
                                   :value="this.userAuth">
                            <!--Пользователь неизвестен-->
                            <div class="my-3" v-if="! this.userAuth">
                                <label for="from">Ваше имя:</label>
                                <input type="text"
                                       id="from"
                                       name="from"
                                       v-model="from"
                                       placeholder="Иванов Иван"
                                       class="form-control mb-3">
                            </div>
                            <!--Совственно сообщение отзыва-->
                            <div class="my-3">
                                <label for="description">Ваш отзыв:</label>
                                <textarea type="text"
                                          v-model="description"
                                          name="description"
                                          rows="3"
                                          cols="4"
                                          id="description"
                                          placeholder="Сообщение"
                                          class="form-control mb-3">
                                </textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!--Кнопка оставить отзыв-->
                        <button type="button"
                            class="btn btn-primary"
                                :disabled="loading"
                                @click="submitCreateForm()">
                            Оставить отзыв <i class="fas fa-spinner fa-spin" v-if="loading"></i>
                        </button>
                        <!--Кнопка закрыть окно-->
                        <button type="button"
                            class="btn btn-primary"
                                :disabled="loading"
                                @click="closeModal()">
                            Закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['formAction', 'userAuth'],

        data() {
            return {
                loading: false,
                error: false,
                messages: [],
                description: "",
                from: "",
            }
        },

        methods: {

            sleep() {
                return new Promise(resolve => setTimeout(resolve, 2000));
            },
            closeModal() {
                $("#reviewModalWindow").modal('hide');
                this.messages=[];
            },
            submitCreateForm() {
                let form = document.getElementById('createReviewForm');
                let formData = new FormData(form);
                this.loading = true;
                this.reviewSended = true;
                this.messages = [];
                this.error = false;
                let action = this.formAction;
                axios
                    .post(action, formData, {
                        responseType: 'json'
                    })
                    .then(response => {
                        let result = response.data;
                        this.messages.push(result.message);
                        this.sleep().then(() => {
                            this.messages = [];});
                    })
                    .catch(error => {
                        this.error = true;
                        let data = error.response.data;
                        for (error in data.errors) {
                            if (data.errors.hasOwnProperty(error)) {
                                this.messages.push(data.errors[error][0]);
                            }
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                        if (! this.error) {
                            this.from = null;
                            this.description = null;
                        }
                    });
            }
        }
    }
</script>

<style scoped>
</style>
