<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    
    <!-- source:https://codepen.io/owaiswiz/pen/jOPvEPB -->
<div class="min-h-screen bg-zinc-500 text-gray-900 flex justify-center">
    <div class="max-w-screen-xl m-0 sm:m-10 bg-zinc-300 shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="mx-auto place-self-center mt-10 max-w-xs">
                <img src="https://play-lh.googleusercontent.com/s3Q_r6k5UXFcPIQxZXCOssMOubAOnEWJcv2_kgv0d9spJf0xbpybZi6LVccCIcIDTg"
                    class=" w-20 h-20"  />
            </div>
            <div class="mt-6 flex flex-col text-center">
                <div class="w-full flex-1 mt-8">
                    <h4 class="text-2xl xl:text-3xl font-extrabold">LOG IN</h4>
                
<form method="POST" action="{{ route('login') }}">
        @csrf

                    <div class="mx-auto mt-12 items-center max-w-xs">
                        <input id="email" class="w-full px-8 py-4 rounded-lg font-medium bg-zinc-200 border border-zinc-500 placeholder-black text-sm focus:outline-none focus:border-indigo-600 focus:bg-white" type="email" placeholder="Email"  name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <input id="password" class="w-full px-8 py-4 rounded-lg font-medium bg-zinc-200 border border-zinc-500 placeholder-black text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        
                       
                         <x-primary-button class="mt-5 tracking-wide font-semibold bg-green-400 text-white-500 w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <path d="M20 8v6M23 11h-6" />
                            </svg>
                {{ __('Log in') }}
            </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-zinc-400 text-center shadow rounded-lg hidden lg:flex">
             <div class="m-12 xl:m-16 w-full bg-contain rounded-full bg-center opacity-70 bg-no-repeat"
                style="background-image: url('https://img.freepik.com/premium-vector/muscle-man-bodybuilder-vector-black-color-silhouette_986058-6626.jpg');">
            </div>
        </div>
    </div>
</div>
    </form>
</x-guest-layout>

