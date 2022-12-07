<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;

class ContactLivewire extends Component
{
  public $lastname;
  public $firstname;
  public $gender;
  public $email;
  public $postcode;
  public $address;
  public $building_name;
  public $opinion;

  protected $rules = [
    'lastname' => 'required|max:100',
    'firstname' => 'required|max:100',
    'gender' => 'required|between:1,2',
    'email' => 'required|email|max:255',
    'postcode' => [
      'required',
      'max:8',
      'regex:/^(\d{1,3})$|^(\d{3}-\d{0,4})$|^(\d{3}-\d{4})$/',
    ],
    'address' => 'required|max:255',
    'building_name' => 'max:255',
    'opinion' => 'required|max:120',
  ];

  // Javascriptから呼び出すための関数
  protected $listeners = [
    'refresh' => '$refresh',
    'updateAddress' => 'updateAddress',
  ];

  // HTMLのaddressに値をセット
  public function updateAddress($request)
  {
    $this->address = $request;
  }

  // 更新を都度検知(リアルタイムバリデーション)
  public function updated($propertyName)
  {
    $this->validateOnly($propertyName);
  }

  // 問い合わせ画面を表示
  public function render()
  {
    return view('livewire.contact-livewire');
  }

  // 初回画面時の初期値
  public function mount()
  {
    if (old('lastname')) {
      $this->lastname = old('lastname');
    }
    if (old('firstname')) {
      $this->firstname = old('firstname');
    }
    // 初期値は男性の1,過去データがあればそれを優先する
    if (old('gender')) {
      $this->gender = old('gender');
    } else {
      $this->gender = '1';
    }
    if (old('email')) {
      $this->email = old('email');
    }
    if (old('postcode')) {
      $this->postcode = old('postcode');
    }
    if (old('address')) {
      $this->address = old('address');
    }
    if (old('building_name')) {
      $this->building_name = old('building_name');
    }
    if (old('opinion')) {
      $this->opinion = old('opinion');
    }
  }
}
