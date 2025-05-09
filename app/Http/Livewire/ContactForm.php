<?php 
namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactForm extends Component
{
    public $name, $email, $subject, $message,$success=null;

    public function submit()
    {
        Mail::to('mediarent.ma@gmail.com')->send(new ContactMessage([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]));

        session()->flash('success', 'Message envoyé avec succès !');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
