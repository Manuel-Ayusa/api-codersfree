@props(['modal'])

<div v-show="{{$modal}}" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">

        <div v-on:click="{{$modal}} = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="w-full flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">

                    <div class="w-full text-center sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">{{$title}}</h3>
                        <div class="mt-2">
                        <p class="text-sm text-gray-500">{{$content}}</p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    {{$footer}}
                </div>
            </div>
        </div>
    </div>
  </div>