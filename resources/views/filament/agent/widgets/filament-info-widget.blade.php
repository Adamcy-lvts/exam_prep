<x-filament-widgets::widget>
    <x-filament::section>
        <div>
            <h2 class="text-sm font-semibold">Your Referral Link</h2>
            <p class="text-xs text-gray-400">Share this link to invite others and earn rewards.</p>
        </div>
        <div class="flex items-center">
            <!-- Display the referral link as a clickable anchor element -->
            <a id="referralLink" href="http://localhost:8083/user/register?ref={{ auth()->user()->agent->referral_code }}"
                class="text-sm text-blue-400 hover:underline flex-1">
                http://localhost:8083/user/register?ref={{ auth()->user()->agent->referral_code }}
            </a>
            <!-- Copy button -->
            <svg onclick="copyToClipboard()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                class="w-6 h-6 fill-current">
                <path
                    d="M208 0H332.1c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 21.2 14.1 33.9 14.1V336c0 26.5-21.5 48-48 48H208c-26.5 0-48-21.5-48-48V48c0-26.5 21.5-48 48-48zM48 128h80v64H64V448H256V416h64v48c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48z" />
            </svg>
        </div>
    </x-filament::section>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("referralLink").href;
            navigator.clipboard.writeText(copyText).then(function() {
                alert("Copied to clipboard!");
            }, function(err) {
                console.error("Could not copy text: ", err);
            });
        }
    </script>

</x-filament-widgets::widget>
