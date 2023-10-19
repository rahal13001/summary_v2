<?php

namespace App\Livewire\Superadmin;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Tambahpermission extends Component
{
    public $name, $submit;
    use LivewireAlert;

    public function submit()
    {
        $validatedData = $this->validate([
            'name' => 'required|max:255|unique:permissions,name,except,id',
        ], [
            'required' => 'Harap Jawab Pertanyaan Ini',
            'max' => 'Jumlah Karakter Maksimal Adalah 255 Karaker (Termasuk Spasi)',   
            'unique' => 'Kategori Telah Tersedia'   
            ]);
 
        Permission::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        $this->alert('success', 'Permission Berhasil Ditambah', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);

        $this->clearForm();
        $this->dispatch('updatepermission');
    }

    public function clearForm()
    {
        $this->name = "";
    }

    public function render()
    {
        return view('livewire.superadmin.tambahpermission');
    }
}
