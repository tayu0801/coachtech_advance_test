@extends('layouts.default') @section('content')
<div class="content">
  <div class="contact">
    <h1 class="title">内容確認</h1>
    <form method="POST" action="{{ route('send') }}">
      @csrf
      <ul class="contact__list">
        <li class="contact__item">
          <div class="contact__hed">お名前</div>
          <p class="contact__data">
            {{ $inputs['lastname'] }} {{ $inputs['firstname'] }}
          </p>
        </li>
        <li class="contact__item">
          <input
            wire:model="lastname"
            class="contact__data-harf"
            type="hidden"
            name="lastname"
            value="{{ $inputs['lastname'] }}"
          />
          <input
            wire:model="firstname"
            class="contact__data"
            type="hidden"
            name="firstname"
            value="{{ $inputs['firstname'] }}"
          />
        </li>
        <li class="contact__item">
          <div class="contact__hed">性別</div>
          <p class="contact__data">
            {{ $inputs['gendername'] }}
          </p>
          <input
            wire:model="gender"
            class="contact__data"
            type="hidden"
            name="gender"
            value="{{ $inputs['gender'] }}"
          />
        </li>
        <li class="contact__item"></li>
        <li class="contact__item">
          <div class="contact__hed">メールアドレス</div>
          <p class="contact__data">
            {{ $inputs['email'] }}
          </p>
        </li>
        <li class="contact__item">
          <input
            wire:model="email"
            class="contact__data"
            type="hidden"
            name="email"
            value="{{ $inputs['email'] }}"
          />
        </li>
        <li class="contact__item">
          <div class="contact__hed">郵便番号</div>
          <p class="contact__data">{{ $inputs['postcode'] }}</p>
        </li>
        <li class="contact__item">
          <input
            wire:model="postcode"
            class="contact__data"
            type="hidden"
            name="postcode"
            id="inputAddress"
            value="{{ $inputs['postcode'] }}"
          />
        </li>
        <li class="contact__item">
          <div class="contact__hed">住所</div>
          <p class="contact__data">{{ $inputs['address'] }}</p>
        </li>
        <li class="contact__item">
          <input
            wire:model="address"
            class="contact__data"
            type="hidden"
            name="address"
            id="inputAddress"
            value="{{ $inputs['address'] }}"
          />
        </li>
        <li class="contact__item">
          <div class="contact__hed">建物名</div>
          <p class="contact__data">{{ $inputs['building_name'] }}</p>
        </li>
        <li class="contact__item">
          <input
            wire:model="building_name"
            class="contact__data"
            type="hidden"
            name="building_name"
            value="{{ $inputs['building_name'] }}"
          />
        </li>
        <li class="contact__item-top">
          <div class="contact__hed-top">ご意見</div>
          <textarea
            wire:model="opinion"
            class="contact__data-textarea border-none"
            rows="5"
            type="hidden"
            name="opinion"
            readonly
            >{{ $inputs['opinion'] }}</textarea
          >
        </li>
      </ul>
      <div class="button-area">
        <button class="send-button" type="submit" name="action" value="submit">
          送信する
        </button>
        <button class="back-button" type="submit" name="action" value="back">
          <span class="under">修正する</span>
        </button>
      </div>
    </form>
  </div>
</div>
<script src="{{ asset('/js/main.js') }}"></script>
@endsection
