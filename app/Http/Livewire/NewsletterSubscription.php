<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Support\Str;

class NewsletterSubscription extends Component
{
    public $email = '';
    public $submitted = false;
    public $error = null;
    protected $queryString = []; 

    protected $rules = [
        'email' => 'required|email|max:255'
    ];
    protected $listeners = ['submitForm' => 'handleSubmit'];
    
    // 2. Then add the handleSubmit method
    public function handleSubmit($payload)
    {
        $resolve = $payload['resolve'];
        try {
            $this->subscribe(); // Calls your main action
            $resolve();
        } catch (\Exception $e) {
            $resolve();
            throw $e;
        }
    }

    // app/Http/Livewire/NewsletterSubscription.php
public function hydrate()
{
    $this->dispatch('livewire:load'); // Force Livewire initialization
}

// protected $listeners = ['submit' => 'subscribe']; // Alternative submission handler
//     public function subscribe()
// {
//     $this->validate(['email' => 'required|email']);
    
//     // Immediate response for testing
//     logger()->debug('Form submitted', ['email' => $this->email]);

//     $this->submitted = true;
//     $this->email = '';
    
//     // Remove dd() for now as it breaks Livewire's response
// }

public function subscribe()
{
    $this->reset(['submitted', 'error']);
    
    try {
        // Custom validation rules
        $validated = $this->validate([
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Check if email already exists
                    if (Subscriber::where('email', $value)->exists()) {
                        $fail('Cet email est déjà abonné à notre newsletter.');
                    }
                    
                    // Check for disposable emails
                    if ($this->isDisposableEmail($value)) {
                        $fail('Les emails jetables ne sont pas acceptés.');
                    }
                }
            ]
        ]);
        
        $subscriber = Subscriber::create([
            'email' => $this->email,
            'confirmation_token' => Str::random(32),
            'is_confirmed' => false
        ]);

        Mail::to($this->email)->send(new SubscriptionConfirmation($subscriber));
        
        $this->submitted = true;
        $this->reset('email');
        
    } catch (\Exception $e) {
        $this->error = $e->getMessage(); // Show the actual error message
        logger()->error('Subscription error: '.$e->getMessage());
    }
}

// Helper method to check disposable emails (add to your component)
private function isDisposableEmail($email)
{
    $disposableDomains = [
        'mailinator.com',
        'tempmail.com',
        '10minutemail.com',
        // Add more disposable domains as needed
    ];
    
    $domain = substr(strrchr($email, "@"), 1);
    return in_array($domain, $disposableDomains);
}

    public function render()
    {
        return view('livewire.newsletter-subscription');
    }
}