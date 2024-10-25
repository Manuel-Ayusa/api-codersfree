<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>


    <x-container id="app" class="py-8">
        <x-form-section class="mb-12">
            <x-slot name="title">
                Crea un nuevo cliente
            </x-slot>
            <x-slot name="description">
                Ingrese los datos solicitados para poder crear un nuevo cliente
            </x-slot>
            
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">
                    <label for="name">Nombre</label>
                    <input v-model="createForm.name" type="text" class="w-full mt-1" id="name">
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <label for="url">URL de redirección</label>
                    <input v-model="createForm.redirect" type="text" class="w-full mt-1" id="url">
                </div>
            </div>
            

            <x-slot name="actions">
                <x-primary-button v-on:click="store">
                    Crear
                </x-primary-button>
            </x-slot>

        </x-form-section>


        <x-form-section>
            <x-slot name="title">
                Lista de clientes
            </x-slot>
            <x-slot name="description">
                Aqui podras encontrar todos los clientes que has agregado
            </x-slot>
            
            <div>
                
            </div>
            

            <x-slot name="actions">
                <x-primary-button v-on:click="store">
                    Crear
                </x-primary-button>
            </x-slot>

        </x-form-section>
    </x-container>

    @push('js')
        
        <script>
            const { createApp } = Vue

            createApp({

                data() {

                    return {

                        createForm:{

                            errors:[],

                            name: null,

                            redirect: null,

                        },

                    }

                },

                methods:{

                    store: function(){

                        axios.post('/oauth/clients', this.createForm)

                        .then(response => {

                            this.createForm.name=null;

                            this.createForm.redirect=null;

                            Swal.fire(

                                'Deleted!',

                                'Your file has been deleted.',

                                'success'

                            );

                        }).catch(error =>{

                            alert('No has completado los datos correspondientes')

                        })

                    }

                }

            }).mount('#app');
        </script>

    @endpush

</x-app-layout>

