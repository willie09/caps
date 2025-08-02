     <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Members List') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-end mb-4">
                        <x-primary-button x-data="" x-on:click="$dispatch('open-modal', 'add-member')">
                            {{ __('Add New Member') }}
                        </x-primary-button>
                    </div>

                    <x-modal name="add-member" focusable>
                        <form method="POST" action="{{ route('members.store') }}" class="p-6">
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('Add New Member') }}
                            </h2>

                            <div class="mt-4">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="membership_type" :value="__('Membership Type')" />
                                <select id="membership_type" name="membership_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="basic">Basic</option>
                                    <option value="premium">Premium</option>
                                    <option value="vip">VIP</option>
                                </select>
                                <x-input-error :messages="$errors->get('membership_type')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                                <x-text-input id="expiry_date" class="block mt-1 w-full" type="date" name="expiry_date" required />
                                <x-input-error :messages="$errors->get('expiry_date')" class="mt-2" />
                            </div>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close-modal', 'add-member')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-primary-button class="ml-3">
                                    {{ __('Save Member') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </x-modal>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Membership
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Join Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Expiry Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Option
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($members as $member)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $member->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $member->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClasses = [
                                                'basic' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                'premium' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                'vip' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses[$member->membership_type] }}">
                                            {{ ucfirst($member->membership_type) }} - P{{ $membershipPrices[$member->membership_type] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $member->join_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $member->expiry_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <button 
                                            x-data=""
                                            x-on:click="$dispatch('open-modal', 'edit-member-{{ $member->id }}')"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3"
                                        >
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('members.destroy', $member->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="button"
                                                onclick="confirm('Are you sure you want to delete this member?') && this.form.submit()"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('members.notifyMember', $member->id) }}" class="inline ml-2">
                                            @csrf
                                            <button 
                                                type="submit"
                                                class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300"
                                            >
                                                Notify
                                            </button>
                                        </form>

                                        <x-modal name="edit-member-{{ $member->id }}" focusable>
                                            <form method="POST" action="{{ route('members.update', $member->id) }}" class="p-6">
                                                @csrf
                                                @method('PATCH')
                                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                                    {{ __('Edit Member') }}
                                                </h2>

                                                <div class="mt-4">
                                                    <x-input-label for="edit-name-{{ $member->id }}" :value="__('Name')" />
                                                    <x-text-input 
                                                        id="edit-name-{{ $member->id }}" 
                                                        class="block mt-1 w-full" 
                                                        type="text" 
                                                        name="name" 
                                                        value="{{ $member->name }}" 
                                                        required 
                                                    />
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="edit-email-{{ $member->id }}" :value="__('Email')" />
                                                    <x-text-input 
                                                        id="edit-email-{{ $member->id }}" 
                                                        class="block mt-1 w-full" 
                                                        type="email" 
                                                        name="email" 
                                                        value="{{ $member->email }}" 
                                                        required 
                                                    />
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="edit-membership_type-{{ $member->id }}" :value="__('Membership Type')" />
                                                    <select 
                                                        id="edit-membership_type-{{ $member->id }}" 
                                                        name="membership_type" 
                                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                    >
                                                        <option value="basic" {{ $member->membership_type === 'basic' ? 'selected' : '' }}>Basic</option>
                                                        <option value="premium" {{ $member->membership_type === 'premium' ? 'selected' : '' }}>Premium</option>
                                                        <option value="vip" {{ $member->membership_type === 'vip' ? 'selected' : '' }}>VIP</option>
                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="edit-expiry_date-{{ $member->id }}" :value="__('Expiry Date')" />
                                                    <x-text-input 
                                                        id="edit-expiry_date-{{ $member->id }}" 
                                                        class="block mt-1 w-full" 
                                                        type="date" 
                                                        name="expiry_date" 
                                                        value="{{ $member->expiry_date->format('Y-m-d') }}" 
                                                        required 
                                                    />
                                                </div>

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-member-{{ $member->id }}')">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>

                                                    <x-primary-button class="ml-3">
                                                        {{ __('Update Member') }}
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
