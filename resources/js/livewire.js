import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Wait for DOM to be fully loaded before starting Livewire
document.addEventListener('DOMContentLoaded', () => {
    window.Livewire = Livewire;
    Livewire.start();
    
    // Add this to debug Livewire initialization
    console.log('Livewire initialized', window.Livewire);
});