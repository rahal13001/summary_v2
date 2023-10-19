<?php

namespace App\Livewire\Superadmin;

use Livewire\Component;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Tambahrole extends Component
{
    public $name, $submit;
    use LivewireAlert;

    public function submit()
    {
        $validatedData = $this->validate([
            'name' => 'required|max:255|unique:roles,name,except,id',
        ], [
            'required' => 'Harap Jawab Pertanyaan Ini',
            'max' => 'Jumlah Karakter Maksimal Adalah 255 Karaker (Termasuk Spasi)',   
            'unique' => 'Kategori Telah Tersedia'   
            ]);
 
        Role::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        $this->alert('success', 'Role Berhasil Ditambah', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);

        $this->clearForm();
        $this->dispatch('updaterole');
    }

    public function clearForm()
    {
        $this->name = "";
    }

    public function render()
    {
        return view('livewire.superadmin.tambahrole');
    }


}
