<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\Warehouse;

class CreateUser extends Component
{
    public $email;
    public $password;
    public $cpassword;
    public $name;
    public $role;
    public $warehouse_id;

    public function save()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password',
            'name' => 'required',
            'role' => 'required',
            'warehouse_id' => 'required'
        ]);

        $user = new User();
        $user->email = $this->email;
        $user->password = $this->password;
        $user->name = ucwords($this->name);
        $user->role = $this->role;
        $user->warehouse_id = $this->warehouse_id;
        $user->save();

        session()->flash('success', 'User Created Successfully!');

        $this->dispatch('UserCreated', $user->id);

        $this->reset();
    }
    public function render()
    {
        return view('livewire.user.create-user', [
            'warehouses' => Warehouse::all()
        ]);
    }
}
