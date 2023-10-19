<?php

namespace App\Livewire\Superadmin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Tambahuserrole extends Component
{

    public $nama, $taut, $user_idrole, $clearform;
    public $role_id = [];
    use LivewireAlert;
  
    public function render()
    {
        return view('livewire.superadmin.tambahuserrole',[
            "usersrole" => User::get(),
            "roles" => Role::get(),
        ]);
    }


    public function taut(){

        $validatedData = $this->validate([
            'user_idrole' => 'required',
            'role_id' => 'required'
        ], [
            'user_id.required' => 'Harap Isi Kolom User',
            'role_id.required' => 'Harap Isi Kolom Kategori',
             
            ]);

            
        $user = User::where('id', $this->user_idrole)->first();

        $user->assignRole($this->role_id);

        $this->alert('success', 'User Berhasil Diberi Role', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
        
        $this->clearForm();
        $this->dispatch('updateUserKategori');
        $this->dispatch('reloadform');
        
    }

    public function clearForm()
    {
        $this->user_idrole = Null;
        $this->role_id = Null;
    }
}
