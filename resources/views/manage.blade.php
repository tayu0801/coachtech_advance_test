@extends('layouts.default') @section('content')

<div class="content">
  <p class="title">管理システム</p>
  <div class="manage">
    <form action="/manage/search" method="get">
      @csrf
      <ul class="manage__list">
        <li class="manage__item">
          <div class="manage__hed">お名前</div>
          <div class="manage__data-row">
            <input
              class="manage__data-harf margin-right"
              type="text"
              name="keyword_fullname"
              value="{{ $keyword_fullname }}"
            />
            <div class="manage__hed">性別</div>
            <div class="manage__data-row-left">
              <div class="manage__data-radio">
                <input
                  class="manage__data-radio1"
                  type="radio"
                  name="keyword_gender"
                  value="0"
                  id="all"
                  {{
                  $keyword_radio0
                  }}
                />
                <label class="manage__data-radio2" for="man">全て</label>
              </div>
              <div class="manage__data-radio">
                <input
                  class="manage__data-radio1"
                  type="radio"
                  name="keyword_gender"
                  value="1"
                  id="man"
                  {{
                  $keyword_radio1
                  }}
                />
                <label class="manage__data-radio2" for="man">男性</label>
              </div>

              <div class="manage__data-radio">
                <input
                  class="manage__data-radio1"
                  type="radio"
                  name="keyword_gender"
                  value="2"
                  id="woman"
                  {{
                  $keyword_radio2
                  }}
                />
                <label class="manage__data-radio2" for="woman">女性</label>
              </div>
              <input
                type="hidden"
                name="genderno"
                value="{{ $keyword_genderno }}"
              />
            </div>
          </div>
        </li>
        <li class="manage__item">
          <div class="manage__hed">登録日</div>
          <div class="manage__data-row">
            <input
              class="manage__data"
              type="date"
              min="2022-01-01"
              max="2030-01-01"
              name="keyword_firstdate"
              value="{{ $keyword_firstdate }}"
            />
            <span>～</span>
            <input
              class="manage__data"
              type="date"
              min="2022-01-01"
              max="2030-01-01"
              name="keyword_lastdate"
              value="{{ $keyword_lastdate }}"
            />
          </div>
        </li>
        <li class="manage__item">
          <div class="manage__hed">メールアドレス</div>
          <input
            class="manage__data"
            type="text"
            name="keyword_email"
            value="{{ $keyword_email }}"
          />
        </li>
        <div class="button-area">
          <button class="send-button">検索</button>
          <button
            class="back-button under"
            type="button"
            onclick="location.href='{{ route('manage') }}' "
          >
            リセット
          </button>
        </div>
      </ul>
    </form>
  </div>
  <div class="page-info">
    @if (count($contacts) >0)
    <p>
      全{{ $contacts->total() }}件中
      {{  ($contacts->currentPage() -1) * $contacts->perPage() + 1}} -
      {{ (($contacts->currentPage() -1) * $contacts->perPage() + 1) + (count($contacts) -1)











      }}件
    </p>
    @else
    <p>データがありません</p>
    @endif
    <div class="pagination">
      {{ $contacts->appends(['keyword_fullname' => $keyword_fullname,'keyword_genderno' => $keyword_genderno,'keyword_firstdate' => $keyword_firstdate, 'keyword_lastdate' => $keyword_lastdate, 'keyword_email' => $keyword_email])->links('vendor.pagination.semantic-ui')  }}
    </div>
  </div>

  <table>
    <tr>
      <th class="manage__table-hed">ID</th>
      <th class="manage__table-hed">お名前</th>
      <th class="manage__table-hed">性別</th>
      <th class="manage__table-hed">メールアドレス</th>
      <th class="manage__table-hed">ご意見</th>
      <th class="manage__table-hed"></th>
    </tr>
    @foreach ($contacts as $contact)
    <tr>
      <td class="manage__table-data">{{$contact->id}}</td>
      <td class="manage__table-data">{{$contact->fullname}}</td>
      <td class="manage__table-data">
        @if($contact->gender == '1') 男性 @elseif($contact->gender == '2') 女性
        @else @endif
      </td>
      <td class="manage__table-data">{{$contact->email}}</td>
      <td class="manage__table-data" title="{{$contact->opinion}}">
        @if (Str::length($contact->opinion) >= 25)
        {{
        Str::substr($contact->opinion,0,24)












        }}... @else {{$contact->opinion}} @endif
      </td>
      <td>
        <form action="/{{$contact->id}}/delete" method="post">
          @csrf
          <button class="send-button-mini">削除</button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>
</div>

@endsection
