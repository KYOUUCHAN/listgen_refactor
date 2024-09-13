<?php
$error_message = array();

//初回の訪問ならばローディング画面を作成
function CreatLoading($isFirstVisit)
{
  if ($isFirstVisit) {
    echo '
      <div id="loader">
        <div class="loader"></div>
      </div>';
  }
}

//初めての訪問か二回目以降の訪問かを記録する
$isFirstVisit = false;

//すべてのフィールドに値が入っているかをチェック
$isComplete = false; //値が入っていない箇所が一つでもあればfalseとなる

//バリデーションチェック
if (isset($_POST["SendButton"])) {
  $isComplete = true;
  if (empty($_POST["F"])) {
    $_POST["F"] = 1;
  }

  if (empty($_POST["E"])) {
    $error_message["E"] = "Eの値を記入してください";
    $isComplete = false;
  }

  if (empty($_POST["S"])) {
    $error_message["S"] = "Sの値を記入してください";
    $isComplete = false;
  }

  if (empty($_POST["Pretextarea"])) {
    $error_message["Pretextarea"] = "Preの値を記入してください";
    $isComplete = false;
  }

  if (empty($_POST["Posttextarea"])) {
    $error_message["Posttextarea"] = "Postの値を記入してください";
    $isComplete = false;
  }
} else {
  //初回訪問であることを記録する
  $isFirstVisit = true;
}

//戻るボタン（すべてリセットする）
if (isset($_POST["BackButton"])) {
  $isComplete = false;
  $_POST["SendButton"] = false;
  $isFirstVisit = false;
}

function showValidationErrors()
{
  global $error_message;
  if ($error_message) {
    echo '<h2><ul class="errorMessage" style="font-size: 33px; color: red; margin-left: 20px; font-family: \'Dela Gothic One\', sans-serif; font-weight: 7;">
            エラー<br>';
    foreach ($error_message as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul></h2>';
  }
}

function PrintFormOrList()
{
  global $isComplete;
  if ($isComplete == true) {
    //リスト表示画面
    echo '<div style="margin-top: 100px; padding: 0; margin-left: 30px;">
              <div style="font-size: 30px; font-family: \'Dela Gothic One\', sans-serif; font-weight: 200;">';
    for ($totalAdds = 0, $lineBreak = 1; $_POST["F"] + $totalAdds * $_POST["S"] <= $_POST["E"]; $totalAdds++, $lineBreak++) {
      echo $_POST["Pretextarea"] . $_POST["F"] + $totalAdds * $_POST["S"] . $_POST["Posttextarea"];
      //リストが長い場合に横長になるのを防ぐ
      if ($lineBreak == 7) {
        echo '<br>';
        $lineBreak = 0;
      }
    }
    echo '  </div><br>
            <form method="POST">
              <input type="hidden" name="F" value="">
              <input type="hidden" name="E" value="">
              <input type="hidden" name="S" value="">
              <input type="hidden" name="Pretextarea" value="">
              <input type="hidden" name="Posttextarea" value="">
              <input type="submit" value="戻る" name="BackButton" style="width: 50px; height: 30px">
            </h2>
            </form>
            </div>';
  } else {
    //フォーム表示画面
    echo '<form style="margin-top: 70px; padding: 0; margin-left: 30px;" method="POST">
            <h2>
                <div style="color: red; font-size: 80px; font-family: \'Dela Gothic One\', sans-serif; font-weight: 200;">F = 未記入 : 1</div>
                <label>F：</label>
                <input type="number" name="F" placeholder="数字を入力して下さい" value="' . (isset($_POST["F"]) ? $_POST["F"] : '') . '">
                <br>
                <label>E：</label>
                <input type="number" name="E" placeholder="数字を入力して下さい" value="' . (isset($_POST["E"]) ? $_POST["E"] : '') . '">
                <br>
                <label>S：</label>
                <input type="number" name="S" placeholder="数字を入力して下さい" value="' . (isset($_POST["S"]) ? $_POST["S"] : '') . '">
                <br>
                <hr>
                <label>Pre：</label><br>
                <textarea class="TextArea" name="Pretextarea" placeholder="文字列を入力してください">' . (isset($_POST["Pretextarea"]) ? $_POST["Pretextarea"] : '') . '</textarea>
                <br>
                <label>Post：</label><br>
                <textarea class="TextArea" name="Posttextarea" placeholder="文字列を入力してください">' . (isset($_POST["Posttextarea"]) ? $_POST["Posttextarea"] : '') . '</textarea> 
                <hr><hr>
                <input type="submit" value="送信" name="SendButton" style="width: 50px; height: 30px">
            </h2>
            </form>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
  <title>リストジェネレータ</title>
  <style type="text/css">
    .loader {
      height: 60px;
      aspect-ratio: 1;
      position: relative;
    }

    .loader::before,
    .loader::after {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 50%;
      transform-origin: bottom;
    }

    .loader::after {
      background:
        radial-gradient(at 75% 15%, #fffb, #0000 35%),
        radial-gradient(at 80% 40%, #0000, #0008),
        radial-gradient(circle 5px, #fff 94%, #0000),
        radial-gradient(circle 10px, #000 94%, #0000),
        linear-gradient(#F93318 0 0) top /100% calc(50% - 5px),
        linear-gradient(#fff 0 0) bottom/100% calc(50% - 5px) #000;
      background-repeat: no-repeat;
      animation: l20 1s infinite cubic-bezier(0.5, 120, 0.5, -120);
    }

    .loader::before {
      background: #ddd;
      filter: blur(8px);
      transform: scaleY(0.4) translate(-13px, 0px);
    }

    @keyframes l20 {

      30%,
      70% {
        transform: rotate(0deg)
      }

      49.99% {
        transform: rotate(0.2deg)
      }

      50% {
        transform: rotate(-0.2deg)
      }
    }

    #loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: white;
      z-index: 9999;
      transition: opacity 1s;
      opacity: 1;
    }

    #loader.fade-out {
      opacity: 0;
      pointer-events: none;
    }

    .TextArea {
      margin-top: 10px;
      width: 100%;
      max-width: 500px;
      height: 90px;
      resize: none;
    }
  </style>
</head>

<body style="background-color: #93aad4; padding: 0;">
  <?php
  CreatLoading($isFirstVisit);
  ?>
  <header>
    <div style="background-color: #222a41;
                    color: white;
                    height: 75px;
                    width: 100%;
                    position: fixed;
                    top: 0;
                    left: 0;
                    display: flex;
                    align-items: center;
                    justify-content: space-around; ">リストジェネレータ</div>
    <hr>
  </header>
  <?php
  PrintFormOrList();
  showValidationErrors();
  ?>
</body>

</html>
<script>
  //ロード画面の表示時間の設定
  document.addEventListener('DOMContentLoaded', function() {
    // ローダーを終了させる
    var loader = document.getElementById('loader');
    setTimeout(function() {
      loader.classList.add('fade-out');
    }, 2500);
  });
</script>