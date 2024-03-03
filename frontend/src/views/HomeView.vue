<template>
    <div class="full-page bg-light">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-6">
                    <div class="card p-4 rounded shadow">
                        <div class="text-center mb-4">
                            <img src="/logo.png" class="img-fluid mb-3" alt="Logo">
                            <h5 class="card-title mb-0">Short it</h5>
                        </div>
                        <div class="input-group mb-3">
                            <input @change="showModal=false" v-model="inputValue" type="url" class="form-control" placeholder="Url to short" required>
                            <div class="invalid-feedback" v-if="!isValidUrl">Please enter a valid URL.</div>
                        </div>
                        <div class="d-grid mb-3">
                            <button @click="makeApiRequest" :disabled="!isValidUrl" class="btn btn-primary btn-lg">Sign In</button>
                        </div>
                        <div v-if="response" class="text-center">
                            <b-modal v-model="showModal" title="API Response" size="xl" @hidden="resetResponse">
                                <p>{{ response }}</p>
                            </b-modal>
                            <div class="alert alert-error" role="alert">
                                {{ errorResponse }}
                                <button @click="showModal = true" class="btn btn-link"></button>
                            </div>
                            <div class="alert alert-success" role="alert">
                                {{ response }}
                                <button @click="showModal = true" class="btn btn-link"></button>
                                <button @click="copyToClipboard(response)" class="btn btn-link">Copy Response</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { BModal } from 'bootstrap-vue-next';

export default {
    components: {
        BModal,
    },
    data() {
        return {
            inputValue: '',
            response: '',
            errorResponse: '',
            showModal: false,
            backendUrl: import.meta.env.VITE_APP_BACKEND_URL,
        };
    },
    computed: {
        isValidUrl() {
            var urlPattern = new RegExp('^(https?:\\/\\/)?'+ // validate protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // validate domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))'+ // validate OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // validate port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?'+ // validate query string
                '(\\#[-a-z\\d_]*)?$','i'); // validate fragment locator


            // Check if the input value is a valid URL
            return !!urlPattern.test(this.inputValue);
        }
    },
    methods: {
        async makeApiRequest() {
            try {
                const response = await fetch(this.backendUrl + '/api/route', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        url: this.inputValue,
                    }),
                });
                if (response.status === 200) {
                    this.response = this.backendUrl + '/' + JSON.parse(await response.text());
                } else {
                    this.errorResponse = JSON.parse(await response.text()).errors.url[0];
                }
            } catch (error) {
                console.error(error);
                this.response = 'Error occurred';
            }
        },
        resetResponse() {
            this.response = '';
        },
        copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    console.log('Text copied to clipboard');
                    // You can add feedback or toast here if needed
                })
                .catch((error) => {
                    console.error('Unable to copy text to clipboard:', error);
                    // You can handle errors here if needed
                });
        }
    }
};
</script>

<style scoped>
.full-page {
    height: 100vh;
}

.card {
    background-color: #fff;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}
</style>
