<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ChatComponent extends Component
{
    public $topic;
    public $message = '';
    public $messages = [];
    public $temporaryResponse;

    protected $listeners = ['handleAddMessage'];

    public function mount($topic)
    {
        $this->topic = $topic;
        // Load initial messages if needed, otherwise, initialize an empty array.
        $this->messages = [];
    }


    public function handleAddMessage()
    {
        if ($this->temporaryResponse) {
            // Add the OpenAI response to the messages
            $this->addMessage($this->temporaryResponse, false);
            $this->temporaryResponse = ''; // Clear the temporary response
            $this->dispatch('messageAdded'); // Ensure this is dispatchBrowserEvent and not dispatch
        }
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') {
            $this->addError('message', 'The message cannot be empty.');
            return;
        }

        // Add the user's message
        $this->addMessage($this->message, true);

        // Indicate that the AI is "typing"
        $this->dispatch('typingStart');

        // Get the response from OpenAI
        $this->temporaryResponse = $this->talkToOpenAI($this->message);

        if ($this->temporaryResponse) {
            // Dispatch an event indicating a response has been received
            $this->dispatch('responseReceived');
        } else {
            $this->addError('openai', 'Unable to get a response from OpenAI.');
        }

        // Stop typing indicator in either case
    
        $this->dispatch('typing-done');
        $this->message = '';
    }
    protected function addMessage($text, $fromUser)
    {
        $this->messages[] = [
            'id' => (string) Str::uuid(),
            'text' => $text,
            'fromUser' => $fromUser,
            'timestamp' => now()->format('g:i A'),
            'avatar' => $fromUser ? asset('path/to/user-avatar.jpg') : asset('path/to/openai-avatar.jpg'),
        ];
        $this->dispatch('messageAdded'); // Emit an event when a new message is added.
    }

    protected function talkToOpenAI($message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a Physics expert that knows everything about physics and a very good tutor"
                ],
                [
                    "role" => "user",
                    "content" => $this->topic . ": " . $message,
                ]
            ],
            'max_tokens' => 20,
        ]);

        // if (!$response->successful()) {
        //     // Log the error or handle it as required
        //     logger()->error('OpenAI API call failed', ['response' => $response->body()]);
        //     return null;
        // }
        // dd($response);
        $content = $response->json()['choices'][0]['message']['content'] ?? '';
        return is_string($content) ? trim($content) : '';
    }


    public function render()
    {
        return view('livewire.chat-component', [
            'messages' => $this->messages, // Pass the messages to the view
        ]);
    }
}
