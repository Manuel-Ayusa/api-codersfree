<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Api Tokens
        </h2>
    </x-slot>

    <div id="app">

        <x-container class="py-8">

            {{-- Crear access token --}}
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

            {{-- Mostrar access tokens --}}
            <x-form-section v-if="tokens.length > 0">
                <x-slot name="title">
                    Lista de Access Tokens
                </x-slot>
                <x-slot name="description">
                    Aqui podras encontrar la lista de Access Tokens creados
                </x-slot>
                
                <div >
                    <table class="text-gray-600">
                        <thead class="border-b border-gray-300">
                            <tr class="text-left">
                                <th class="py-2 w-full">Nombre</th>
                                <th class="py-2">Acción</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-300">
                            <tr v-for="token in tokens">
                                <td class="py-2">
                                    @{{ token.name }}
                                </td>
                                <td class="flex divide-x divide-gray-300 py-2">

                                    <a class="pr-2 hover:text-green-600 font-semibold cursor-pointer"
                                    v-on:click="">
                                        Ver
                                    </a>
                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer"
                                    v-on:click="revoke(token)">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        
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
                        },
                        tokens: [],
                    }
                },

                mounted() {
                    this.getTokens();
                },

                methods:{
                    store: function () {
                        axios.post('/oauth/personal-access-tokens', this.form)
                            .then(response => {
                                this.form.name = null;
                                this.form.errors = [];

                                this.getTokens();
                            })
                            .catch(error => {

                                this.form.errors = Object.values(error.response.data.errors).flat();

                            })
                    },

                    getTokens: function () {
                        axios.get('/oauth/personal-access-tokens')
                        .then(response => {
                            this.tokens = response.data;
                        })
                    },

                    revoke: function (token) {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                            if (result.isConfirmed) {

                                axios.delete('/oauth/personal-access-tokens/' + token.id)

                                .then(response => {
                                    this.getTokens();  
                                })

                                Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                                });
                            }
                            });
                    }
                }
            }).mount('#app')
                        
        </script>

    @endpush

</x-app-layout>