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

    protected $rules = [
        'email' => 'required|email|max:255'
    ];

    public function mount()
    {
        $this->reset(['submitted', 'error', 'email']);
    }

    public function subscribe()
    {
        $this->reset(['submitted', 'error']);
        
        try {
            $validated = $this->validate([
                'email' => [
                    'required',
                    'email:rfc,dns',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        if (Subscriber::where('email', $value)->exists()) {
                            $fail('Cet email est déjà abonné à notre newsletter.');
                        }
                        
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
            $this->error = 'Une erreur est survenue. Veuillez réessayer.';
            logger()->error('Subscription error: '.$e->getMessage());
        }
    }

    private function isDisposableEmail($email)
    {
        $disposableDomains = [
            'mailinator.com',
            'tempmail.com',
            '10minutemail.com',
        ];
        
        $domain = substr(strrchr($email, "@"), 1);
        return in_array($domain, $disposableDomains);
    }

    public function render()
    {
        return view('livewire.newsletter-subscription');
    }
}