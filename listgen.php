<?php
$error_message = array();

//初回の訪問ならばローディング画面を作成
function CreatLoading($is_first_visit)
{
  if ($is_first_visit) {
    echo '
      <div id="loader">
        <div class="loader"></div>
      </div>';
  }
}

//初めての訪問か二回目以降の訪問かを記録する
$is_first_visit = false;

//すべてのフィールドに値が入っているかをチェック
$is_complete = false; //値が入っていない箇所が一つでもあればfalseとなる

//バリデーションチェック
if (isset($_POST["SendButton"])) {
  $is_complete = true;
  if (empty($_POST["F"])) {
    $_POST["F"] = 1;
  }

  if (empty($_POST["E"])) {
    $error_message["E"] = "Eの値を記入してください";
    $is_complete = false;
  }

  if (empty($_POST["S"])) {
    $error_message["S"] = "Sの値を記入してください";
    $is_complete = false;
  }

  if (empty($_POST["Pretextarea"])) {
    $error_message["Pretextarea"] = "Preの値を記入してください";
    $is_complete = false;
  }

  if (empty($_POST["Posttextarea"])) {
    $error_message["Posttextarea"] = "Postの値を記入してください";
    $is_complete = false;
  }
} else {
  //初回訪問であることを記録する
  $is_first_visit = true;
}

//戻るボタン（すべてリセットする）
if (isset($_POST["BackButton"])) {
  $is_complete = false;
  $_POST["SendButton"] = false;
  $is_first_visit = false;
}

function ShowValidationErrors()
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
  global $is_complete;
  if ($is_complete == true) {
    //リスト表示画面
    echo '<div style="margin-top: 100px; padding: 0; margin-left: 30px;">
              <div style="font-size: 30px; font-family: \'Dela Gothic One\', sans-serif; font-weight: 200;">';
    for ($total_adds = 0, $line_break = 1; $_POST["F"] + $total_adds * $_POST["S"] <= $_POST["E"]; $total_adds++, $line_break++) {
      echo $_POST["Pretextarea"] . $_POST["F"] + $total_adds * $_POST["S"] . $_POST["Posttextarea"];
      //リストが長い場合に横長になるのを防ぐ
      if ($line_break == 7) {
        echo '<br>';
        $line_break = 0;
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
  <link href="./css/index.css" rel="stylesheet" type="text/css" media="all">
  <title>リストジェネレータ</title>
</head>

<body style="background-color: #93aad4; padding: 0;">
  <?php
  CreatLoading($is_first_visit);
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
  ShowValidationErrors();
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