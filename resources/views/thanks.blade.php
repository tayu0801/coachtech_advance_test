@extends('layouts.default') @section('content')
<div class="thanks-content">
  <div class="button-area">
    <p class="thanks-msg">ご意見いただきありがとうございました。</p>
    <button
      class="send-button"
      type="button"
      onclick="location.href='{{ route('contact') }}' "
    >
      トップページへ
    </button>
  </div>
</div>
@endsection
