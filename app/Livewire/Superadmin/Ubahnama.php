<?php

namespace App\Livewire\Superadmin;

use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Ubahnama extends Component
{
    use LivewireAlert;

    public $name;
    public $user;
    public $nama;
    public $ubah;

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function ubah(){
        $this->ubah = true;
    }

    public function batal(){
        $this->ubah = false;
    }

    public function mount($user)
    {
        $this->name = $user->name;
        $this->user = $user;
    }

    public function update()
    {
        $this->validate();       
        User::whereKey($this->user->id)->update(['name' => $this->name]);


        $this->ubah = false;
        $this->alert('success', 'Profil Berhasil Diubah', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
    }

    public function render()
    {
        return view('livewire.superadmin.ubahnama');
    }
}
