<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
  // 問い合わせ表示
  public function contact()
  {
    return view('contact');
  }

  // 問い合わせ確認画面票表示
  public function confirm(Request $request)
  {
    // バリデーション
    $request->validate([
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
    ]);
    // 性別はあらかじめ日本語に直して、gendernameとして配列にセット
    $inputs = $request->all();
    if ($inputs['gender'] == '1') {
      $inputs = array_merge($inputs, ['gendername' => '男性']);
    } else {
      $inputs = array_merge($inputs, ['gendername' => '女性']);
    }
    // 問い合わせ確認画面票表示
    return view('confirm', [
      'inputs' => $inputs,
    ]);
  }

  // 問い合わせデータ作成
  public function send(Request $request)
  {
    // 修正・登録のどちらをクリックしたのか判定
    // actionの値を取得
    $action = $request->input('action');
    // action以外のinputの値を取得
    $inputs = $request->except('action');
    //actionの値で分岐
    if ($action !== 'submit') {
      // 戻るボタンの場合リダイレクト処理
      return redirect('contact')->withInput($inputs);
    } else {
      $inputs = array_merge($inputs, [
        'fullname' => $inputs['lastname'] . ' ' . $inputs['firstname'],
      ]);
      // 送信ボタンの場合、問い合わせデータ作成
      contact::create($inputs);
      // 送信完了表示
      return view('thanks');
    }
  }

  // 管理画面表示
  public function manage()
  {
    $contacts = Contact::Paginate(15);
    return view('manage', ['contacts' => $contacts])
      ->with('keyword_fullname', '')
      ->with('keyword_radio0', 'checked')
      ->with('keyword_radio1', '')
      ->with('keyword_radio2', '')
      ->with('keyword_genderno', 0)
      ->with('keyword_firstdate', '')
      ->with('keyword_lastdate', '')
      ->with('keyword_email', '');
  }

  // 管理画面 検索機能
  public function search(Request $request)
  {
    // ページ遷移に検索項目を残す対応
    $form = $request->only([
      'keyword_fullname',
      'keyword_gender',
      'keyword_radio0',
      'keyword_radio1',
      'keyword_radio2',
      'keyword_genderno',
      'keyword_firstdate',
      'keyword_lastdate',
      'keyword_email',
    ]);

    if (!empty($form['keyword_fullname'])) {
      $keyword_fullname = $form['keyword_fullname'];
    } else {
      $keyword_fullname = '';
    }
    if (!empty($form['keyword_gender'])) {
      $keyword_gender = $form['keyword_gender'];
      $keyword_radio0 = '';
      $keyword_radio1 = '';
      $keyword_radio2 = '';
      if ($keyword_gender == '0') {
        $keyword_radio0 = 'checked';
        $keyword_genderno = 0;
      } elseif ($keyword_gender == '1') {
        $keyword_radio1 = 'checked';
        $keyword_genderno = 1;
      } else {
        $keyword_radio2 = 'checked';
        $keyword_genderno = 2;
      }
    } elseif (!empty($form['keyword_genderno'])) {
      $keyword_gender = $form['keyword_genderno'];
      $keyword_radio0 = '';
      $keyword_radio1 = '';
      $keyword_radio2 = '';
      if ($keyword_gender == '0') {
        $keyword_radio0 = 'checked';
        $keyword_genderno = 0;
      } elseif ($keyword_gender == '1') {
        $keyword_radio1 = 'checked';
        $keyword_genderno = 1;
      } else {
        $keyword_radio2 = 'checked';
        $keyword_genderno = 2;
      }
    } else {
      $keyword_gender = 0;
      $keyword_radio0 = 'checked';
      $keyword_genderno = 0;
      $keyword_radio1 = '';
      $keyword_radio2 = '';
    }

    // 検索日が空白の場合、検索ができないため、空のときは仮の値をセット
    if (!empty($form['keyword_firstdate'])) {
      $keyword_firstdate = $form['keyword_firstdate'];
    } else {
      $keyword_firstdate = '1900-01-01';
    }
    if (!empty($form['keyword_lastdate'])) {
      $keyword_lastdate = $form['keyword_lastdate'];
    } else {
      $keyword_lastdate = '2099-12-31';
    }
    if (!empty($form['keyword_email'])) {
      $keyword_email = $form['keyword_email'];
    } else {
      $keyword_email = '';
    }

    $query = Contact::query();
    if (!empty($form)) {
      if ($keyword_gender == '0') {
        $query
          ->where('fullname', 'like', '%' . $keyword_fullname . '%')
          ->Where('gender', '>=', $keyword_genderno)
          ->WhereBetween('created_at', [$keyword_firstdate, $keyword_lastdate])
          ->where('email', 'like', '%' . $keyword_email . '%');
      } else {
        $query
          ->where('fullname', 'like', '%' . $keyword_fullname . '%')
          ->Where('gender', '=', $keyword_genderno)
          ->WhereBetween('created_at', [$keyword_firstdate, $keyword_lastdate])
          ->where('email', 'like', '%' . $keyword_email . '%');
      }
    }

    // 仮の値をセットされた検索日を元に戻す
    if ($keyword_firstdate == '1900-01-01') {
      $keyword_firstdate = '';
    }
    if ($keyword_lastdate == '2099-12-31') {
      $keyword_lastdate = '';
    }

    $contacts = $query->Paginate(15);

    return view('manage', ['contacts' => $contacts])
      ->with('keyword_fullname', $keyword_fullname)
      ->with('keyword_radio0', $keyword_radio0)
      ->with('keyword_radio1', $keyword_radio1)
      ->with('keyword_radio2', $keyword_radio2)
      ->with('keyword_genderno', $keyword_genderno)
      ->with('keyword_firstdate', $keyword_firstdate)
      ->with('keyword_lastdate', $keyword_lastdate)
      ->with('keyword_email', $keyword_email);
  }

  // 管理画面 レコード削除機能
  public function delete(Request $request)
  {
    Contact::find($request->id)->delete();

    return redirect()->route('manage');
  }
}
