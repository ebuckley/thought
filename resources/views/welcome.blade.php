<x-guest-layout>
    <main class='min-h-screen flex items-center justify-center'>
        <div class='max-w-4xl mx-auto p-6'>
            <h1 class="font-bold text-4xl md:text-5xl lg:text-6xl bg-gradient-to-r from-purple-600 to-pink-500 text-transparent bg-clip-text mb-6">
                MSP Documentation for a fraction of the price
            </h1>
            <h2 class=" text-xl md:text-2xl lg:text-3xl mb-8">
                We are focusing specifically on the needs of MSPs, and will never price gouge or lock you into a contract like Kaseya.
            </h2>
            <!-- Short explanation of the launch list and the product-->
            <p class="mb-2 text-lg mx-auto">
                Sick of your vendors going direct to your customer base? We hear you. Our solution is laser focused on delivering a ground up documentation platform. World Class usability.
            </p>
            <p class="mb-8 text-lg mx-auto">
                We are in the design and ideation phase of this product, and we don’t have anything to sell you yet. But we would love to bring you along for the journey, and understand how to solve the biggest problems with documentation platforms at work

            </p>
            <form action="{{ route('pre-signup-emails.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <input type="email" name="email" id="email" placeholder="Enter your email" required
                           class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2 text-white font-semibold bg-gradient-to-r from-purple-600 to-pink-500 rounded-md hover:from-purple-700 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 transform transition hover:scale-105">
                        Join the launch list
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>
