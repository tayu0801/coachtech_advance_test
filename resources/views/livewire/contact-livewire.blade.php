<div class="content">
  <div class="contact">
    <h1 class="title">お問い合わせ</h1>
    <form method="POST" action="{{ route('confirm') }}">
      @csrf
      <ul class="contact__list">
        <li class="contact__item">
          <div class="contact__hed required">お名前</div>
          <div class="contact__data-row">
            <input
              wire:model="lastname"
              class="contact__data-harf"
              type="text"
              name="lastname"
            />
            <input
              wire:model="firstname"
              class="contact__data-harf"
              type="text"
              name="firstname"
            />
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data-row">
            <div class="contact__data-harf example">例)山田</div>
            <div class="contact__data-harf example">例)太郎</div>
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data-row">
            <div class="contact__data-harf">
              @error('lastname')
              <span class="error_msg">{{ $message }}</span>
              @enderror
            </div>
            <div class="contact__data-harf">
              @error('firstname')
              <span class="error_msg">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed required">性別</div>
          <div class="contact__data-row-left">
            <div class="contact__data-radio">
              <input
                wire:model="gender"
                class="contact__data-radio1"
                type="radio"
                name="gender"
                value="1"
                id="man"
              />
              <label class="contact__data" for="man">男性</label>
            </div>

            <div class="contact__data-radio">
              <input
                wire:model="gender"
                class="contact__data-radio1"
                type="radio"
                name="gender"
                value="2"
                id="woman"
              />
              <label class="contact__data" for="woman">女性</label>
            </div>
          </div>
        </li>
        <li class="contact__item"></li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data-row">
            <div class="contact__data-harf">
              @error('genders')
              <span class="error_msg">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed required">メールアドレス</div>
          <div class="contact__data">
            <input
              wire:model="email"
              class="contact__data"
              type="text"
              name="email"
            />
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <p class="contact__data example">例)test@example.com</p>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data">
            @error('email')
            <span class="error_msg">{{ $message }}</span>
            @enderror
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed required">郵便番号</div>
          <div class="contact__data-row">
            <div class="contact__data-posticon">〒</div>
            <input
              wire:model="postcode"
              class="contact__data-postcode"
              type="text"
              name="postcode"
              id="inputPostcode"
            />
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data-row">
            <p class="contact__data-posticon"></p>
            <p class="contact__data-postcode example">例)123-4567</p>
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data-row">
            <div class="contact__data-posticon"></div>
            <div class="contact__data-postcode">
              @error('postcode')
              <span class="error_msg">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed required">住所</div>
          <div class="contact__data">
            <input
              wire:model="address"
              class="contact__data"
              type="text"
              name="address"
              id="inputAddress"
              value="{{ old('address') }}"
            />
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <p class="contact__data example">例)東京都渋谷区千駄ヶ谷1-2-3</p>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data">
            @error('address')
            <span class="error_msg">{{ $message }}</span>
            @enderror
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed">建物名</div>
          <div class="contact__data">
            <input
              wire:model="building_name"
              class="contact__data"
              type="text"
              name="building_name"
            />
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <p class="contact__data example">例)千駄ヶ谷マンション101</p>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data">
            @error('building_name')
            <span class="error_msg">{{ $message }}</span>
            @enderror
          </div>
        </li>
        <li class="contact__item-top">
          <div class="contact__hed-top required">ご意見</div>
          <div class="contact__data">
            <textarea
              wire:model="opinion"
              class="contact__data-textarea"
              rows="5"
              maxlength="120"
              name="opinion"
            ></textarea>
          </div>
        </li>
        <li class="contact__item">
          <div class="contact__hed"></div>
          <div class="contact__data">
            @error('opinion')
            <span class="error_msg">{{ $message }}</span>
            @enderror
          </div>
        </li>
      </ul>
      <button
        class="send-button"
        type="button"
        onclick="submit();"
        value="確認"
      >
        確認
      </button>
    </form>
  </div>
</div>
<script src="{{ asset('/js/main.js') }}"></script>
