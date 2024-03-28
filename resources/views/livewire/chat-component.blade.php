<div>
    <style>
        .typing-indicator {
            display: flex;
            align-items: left;
            justify-content: start;
            height: 30px;
        }

        .dot {
            width: 4px;
            height: 4px;
            margin: 0 4px;
            background-color: #6b6969;
            /* change this to match your design */
            border-radius: 50%;
            animation: wave 1.5s infinite linear;
        }

        /* You can experiment with the keyframes to get the desired wave effect */
        @keyframes wave {

            0%,
            60%,
            100% {
                transform: initial;
            }

            30% {
                transform: translateY(-15px);
            }
        }

        /* Delay the animation for each dot to create the wave */
        .dot:nth-child(1) {
            animation-delay: -0.1s;
        }

        .dot:nth-child(2) {
            animation-delay: -0.2s;
        }

        .dot:nth-child(3) {
            animation-delay: -0.3s;
        }
    </style>
    <div x-data="{
        typing: false,
        messages: @entangle('messages'),
        init() {
            // Listen for the Livewire 'messageAdded' event to scroll the chat box
            Livewire.on('messageAdded', () => {
                this.scrollToBottom();
            });
    
            Livewire.on('typingStart', () => {
                if (!this.typing) {
                    // Start typing indicator
                    this.typing = true;
    
                    // Wait 2 seconds before stopping the typing indicator to simulate AI response time
                    setTimeout(() => {
                        this.typing = false;
                    }, 2000);
                }
    
            })
    
        },
        scrollToBottom() {
            this.$nextTick(() => {
                if (this.$refs.chatBox) {
                    this.$refs.chatBox.scrollTop = this.$refs.chatBox.scrollHeight;
                }
            });
        },
    }" x-init="init()">
        <div x-ref="chatBox" class="overflow-y-auto h-96 p-4 space-y-2 bg-white dark:bg-gray-900">
            <template x-for="message in messages" :key="message.id">
                <div :class="message.fromUser ? 'justify-end' : 'justify-start'" class="flex items-end space-x-2">
                    <div :class="message.fromUser ? ' bg-gray-300 dark:bg-gray-200' : 'bg-gray-900 dark:bg-gray-600'"
                        class="rounded-xl p-3 max-w-xs md:max-w-md lg:max-w-lg xl:max-w-xl">
                        <p x-text="message.text" class="text-sm break-words"  :class="message.fromUser ? 'text-gray-300 dark:text-gray-800' : 'text-gray-100 dark:text-gray-200'"></p>
                        <span x-text="message.timestamp"
                            class="text-xs block mt-2" :class="message.fromUser ? 'text-gray-800 dark:text-gray-800' : 'text-gray-100 dark:text-gray-200' " ></span>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator within chat area -->
            <div x-show="typing" class="typing-indicator" style="display: none;">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>

        <div class="p-4">
            <!-- Message input area -->
            <div class="mt-auto">
                <div class="mt-auto">
                    <div class="flex items-center relative w-full">
                        <input type="text" placeholder="Ask your question..."
                            class="w-full pl-4 pr-12 py-2 text-sm rounded-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none shadow"
                            wire:model.defer="message" wire:keydown.enter="sendMessage" />

                        <!-- Paper Plane Icon Button -->
                        <button
                            class="absolute inset-y-0 right-0 flex items-center justify-center w-10 h-10 bg-gray-500 hover:bg-gray-600 text-gray-500 hover:text-gray-600 dark:text-gray-100 rounded-full mr-1 transition duration-300 ease-in-out transform hover:scale-105"
                            wire:click="sendMessage">
                            <!-- SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor"
                                class="w-6 h-6">
                                <path
                                    d="M980.8 523.29c2.008-3.21 3.2-7.112 3.2-11.29s-1.192-8.08-3.253-11.38l.053.09a22.277 22.277 0 0 0-1.775-2.625l.036.048a23.697 23.697 0 0 0-6.933-6.38l-.106-.058c-.507-.305-.738-.896-1.273-1.164l-896.03-448C71.59 40.936 67.896 40 63.986 40c-13.254 0-24 10.745-24 24 0 3.422.717 6.677 2.008 9.623l-.06-.154L229.875 512 41.937 950.563c-1.217 2.78-1.925 6.017-1.925 9.42 0 13.255 10.736 24 23.986 24.017h.095c3.88 0 7.537-.947 10.755-2.62l-.13.06 896.034-447.97c.535-.27.768-.86 1.274-1.165 2.802-1.684 5.145-3.835 6.993-6.37l.046-.068a21.91 21.91 0 0 0 1.677-2.472l.057-.106zM111.875 114.78 858.312 488H271.836zM271.835 536h586.48l-746.44 373.248z" />
                            </svg>
                        </button>
                    </div>
                    
                </div>

                <!-- Display validation errors for message -->
                @error('message')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
                <!-- Display validation errors for OpenAI response -->
                @error('openai')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- AlpineJS for handling new message event and auto-scrolling -->
        @script
            <script>
                $wire.on('responseReceived', (event) => {
                    console.log('Hello');
                    setTimeout(() => {
                        // Emit an event back to Livewire to add the response after a 2-second delay
                        $wire.dispatch('handleAddMessage');
                    }, 2000);
                });
            </script>
        @endscript
    </div>
</div>
