// 郵便番号から都道府県・市区町村データを取得
function getAddressData(zip) {
  return new Promise(function (resolve, reject) {
    var zipPattern = /^[0-9]{3}-?[0-9]{4}$/;
    if (!zip.match(zipPattern)) {
      resolve(0);
    }
    const api = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=';
    const param = zip.replace('-', '');
    const url = api + param;
    fetchJsonp(url, {
      timeout: 1000,
    }).then((response) => {
      resolve(response.json());
    });
  });
}

// Livewireの値セット
function LivewireUpdateAddress(zip) {
  Livewire.emitTo('contact-livewire', 'updateAddress', zip);
}

// 同期処理で住所補足を呼び出してLivewireの機能でセット
async function asyncFunc(zip) {
  const result = await getAddressData(zip);
  result !== 0;
  LivewireUpdateAddress(
    result.results[0].address1 +
      result.results[0].address2 +
      result.results[0].address3,
  );
}

// 郵便番号の補足本体
function adjustPostcode(zip) {
  zip = zip
    .replace(/[！-～]/g, function (s) {
      return String.fromCharCode(s.charCodeAt(0) - 0xfee0);
    })
    .replace(/[-－﹣−‐⁃‑‒–—﹘―⎯⏤ーｰ─━]/g, '-');
  if (zip.match(/^([0-9０-９]{7})$/)) {
    zip = zip.substr(0, 3) + '-' + zip.substr(3);
  }
  return zip;
}

// 郵便番号の半角変換、住所補足
function toHalfWidthPostcode(elm) {
  const inputPostcode = document.getElementById(elm);
  let isImeSts = false;
  // componentstartでIMEの開始(日本語入力)を判定
  inputPostcode.addEventListener('compositionstart', () => {
    isImeSts = true;
    inputPostcode.value = adjustPostcode(inputPostcode.value);
    if (inputPostcode.value.match(/^(\d{3}-{1}\d{4})$/)) {
      asyncFunc(inputPostcode.value);
    }
  });
  // componentstartでIMEの終了(日本語入力)を判定
  inputPostcode.addEventListener('compositionend', () => {
    isImeSts = false;
  });
  inputPostcode.addEventListener('keyup', () => {
    if (!isImeSts) {
      inputPostcode.value = adjustPostcode(inputPostcode.value);
      if (inputPostcode.value.match(/^(\d{3}-{1}\d{4})$/)) {
        asyncFunc(inputPostcode.value);
      }
    }
  });
}
toHalfWidthPostcode('inputPostcode');
