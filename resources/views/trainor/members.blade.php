<x-trainor-layout>
    
   <div class="py-8  px-6 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           

            <!-- Members List -->
            <div class="glass-effect border border-white/20 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">Assigned Members</h3>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search members..." class="glass-effect border border-white/20 rounded-xl px-4 py-2 text-white placeholder-white/50 focus:border-white/40 focus:outline-none w-64">
                                <svg class="w-5 h-5 text-white/50 absolute right-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-2 xl:grid-cols-5 gap-6">
                    @forelse($members as $member)
                        <div class="glass-effect border border-white/20 rounded-2xl p-6 transition-colors duration-200 flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center mb-4">
                                <span class="text-2xl font-bold text-white">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                            </div>
                            <h4 class="text-xl font-semibold text-white mb-1">{{ $member->name }}</h4>
                            <p class="text-white/70 mb-1">{{ $member->email }}</p>
                            <p class="text-white/60 text-sm mb-2">{{ $member->phone ?? 'N/A' }}</p>
                            @if($member->expiry_date && $member->expiry_date > now())
                                <span class="px-3 py-1 text-xs rounded-full font-medium bg-green-500/20 text-green-300 border border-green-500/30 mb-2 inline-block">Active</span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full font-medium bg-red-500/20 text-red-300 border border-red-500/30 mb-2 inline-block">Expired</span>
                            @endif
                            <p class="text-white/60 text-sm mb-4">{{ $member->membership_type ?? 'N/A' }}</p>
                            <div class="flex space-x-4">
                                <button type="button" class="text-zinc-800 hover:text-gray-300 transition-colors duration-200 flex items-center" onclick="showMemberDetails({{ $member->id }})">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </button>
                                
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="flex flex-col items-center space-y-4">
                                <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-white/70 text-lg font-medium">No members assigned yet</p>
                                    <p class="text-white/50 text-sm">Members will appear here once assigned to you</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Member Details Modal -->
    <div id="memberDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100" id="memberDetailsModalLabel">Member Details</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" onclick="closeModal()">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-4 text-white" id="memberDetailsContent">
                    <!-- Details will be populated here -->
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500" onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store member data for JavaScript access
        const membersData = @json($members);

        function showMemberDetails(memberId) {
            const member = membersData.find(m => m.id === memberId);
            if (!member) return;

            const isActive = member.expiry_date && new Date(member.expiry_date) > new Date();
            const statusClass = isActive ? 'text-green-600' : 'text-red-600';
            const statusText = isActive ? 'Active' : 'Expired';

            const content = `
                <div class="space-y-2">
                    <p class="text-sm"><span class="font-medium">Name:</span> ${member.name}</p>
                    <p class="text-sm"><span class="font-medium">Email:</span> ${member.email}</p>
                    <p class="text-sm"><span class="font-medium">Phone:</span> ${member.phone || 'N/A'}</p>
                    <p class="text-sm"><span class="font-medium">Membership Plan:</span> ${member.membership_type || 'N/A'}</p>
                    <p class="text-sm"><span class="font-medium">Join Date:</span> ${member.join_date ? new Date(member.join_date).toLocaleDateString() : 'N/A'}</p>
                    <p class="text-sm"><span class="font-medium">Expiry Date:</span> ${member.expiry_date ? new Date(member.expiry_date).toLocaleDateString() : 'N/A'}</p>
                    <p class="text-sm"><span class="font-medium">Status:</span> <span class="${statusClass}">${statusText}</span></p>
                </div>
            `;

            document.getElementById('memberDetailsContent').innerHTML = content;
            document.getElementById('memberDetailsModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('memberDetailsModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('memberDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-trainor-layout>


