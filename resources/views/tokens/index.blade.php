<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Api Tokens
        </h2>
    </x-slot>

    <div id="app">

        <x-container class="py-8">

            <x-form-section class="mb-12">
                <x-slot name="title">
                    Access Token
                </x-slot>
                <x-slot name="description">
                    Aqui podra generar un Access Token
                </x-slot>

                <div class="grid grid-cols-6 gap-6">

                    <div class="col-sapn-6 sm:col-span-4">
                        
                        <div v-if="form.errors.length > 0" class="bg-red-100 border border-rey-400 text-red-700 py-3 px-4 rounded">
                            <strong class="font-bold">Whoops! </strong>
                            <span>¡Algo salio mal!</span>
            
                            <ul>
                                <li v-for="error in form.errors">
                                    @{{ error }}
                                </li>
                            </ul>
                        </div>

                        <label for="name">
                            Nombre
                        </label>
                        <input v-model="form.name" type="text" class="w-full mt-1" id="name">
                        
                    </div>
                </div>

                <x-slot name="actions">
                    <x-primary-button v-on:click="store">
                        Crear
                    </x-primary-button>
                </x-slot>
            </x-form-section>

        </x-container>

    </div>

    @push('js')

        <script>

            const { createApp } = Vue

            createApp({
                
                data() {

                    return {
                        form:{
                            name: null,
                            errors: []
                        }
                    }
                },

                methods:{
                    store: function () {
                        axios.post('/oauth/personal-access-tokens', this.form)
                            .then(response => {
                                this.form.name = null;
                                this.form.errors = [];
                            })
                            .catch(error => {

                                this.form.errors = Object.values(error.response.data.errors).flat();

                            })
                    }
                }
            }).mount('#app')
                        
        </script>

    @endpush

</x-app-layout>