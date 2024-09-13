<?php
$err = array();
$first = false;
$comp = false;

if (isset($_POST["sb"])) {
  $comp = true;
  if (empty($_POST["f"])) {
    $_POST["f"] = 1;
  }
  if (empty($_POST["e"])) {
    $err["e"] = "Eの値を記入してください";
    $comp = false;
  }
  if (empty($_POST["s"])) {
    $err["s"] = "Sの値を記入してください";
    $comp = false;
  }
  if (empty($_POST["pre"])) {
    $err["pre"] = "Preの値を記入してください";
    $comp = false;
  }
  if (empty($_POST["post"])) {
    $err["post"] = "Postの値を記入してください";
    $comp = false;
  }
} else {
  $first = true;
}

if (isset($_POST["bb"])) {
  $comp = false;
  $_POST["sb"] = false;
  $first = false;
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
      background: radial-gradient(at 75% 15%, #fffb, #0000 35%),
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
  if ($first == true) {
    echo '<div id="loader"><div class="loader"></div></div>';
  }
  ?>
  <header>
    <div style="background-color: #222a41; color: white; height: 75px; width: 100%; position: fixed; top: 0; left: 0; display: flex; align-items: center; justify-content: space-around;">リストジェネレータ</div>
    <hr>
  </header>
  <?php
  if ($comp == true) {
    echo '<div style="margin-top: 100px; padding: 0; margin-left: 30px;">
                <div style="font-size: 30px; font-family: \'Dela Gothic One\', sans-serif; font-weight: 200;">';
    for ($ta = 0, $lb = 1; $_POST["f"] + $ta * $_POST["s"] <= $_POST["e"]; $ta++, $lb++) {
      echo $_POST["pre"] . $_POST["f"] + $ta * $_POST["s"] . $_POST["post"];
      if ($lb == 7) {
        echo '<br>';
        $lb = 0;
      }
    }
    echo '  </div><br>
              <form method="POST">
                <input type="hidden" name="f" value="">
                <input type="hidden" name="e" value="">
                <input type="hidden" name="s" value="">
                <input type="hidden" name="pre" value="">
                <input type="hidden" name="post" value="">
                <input type="submit" value="戻る" name="bb" style="width: 50px; height: 30px" >
              </form>
              </div>';
  } else {
    echo '<form style="margin-top: 70px; padding: 0; margin-left: 30px;" method="POST">
                <h2>
                    <div style="color: red; font-size: 80px; font-family: \'Dela Gothic One\', sans-serif; font-weight: 200;">F = 未記入 : 1</div>
                    <label>F：</label>
                    <input type="number" name="f" placeholder="数字を入力して下さい" value="' . (isset($_POST["f"]) ? $_POST["f"] : '') . '">
                    <br>
                    <label>E：</label>
                    <input type="number" name="e" placeholder="数字を入力して下さい" value="' . (isset($_POST["e"]) ? $_POST["e"] : '') . '">
                    <br>
                    <label>S：</label>
                    <input type="number" name="s" placeholder="数字を入力して下さい" value="' . (isset($_POST["s"]) ? $_POST["s"] : '') . '">
                    <br>
                    <hr>
                    <label>Pre：</label><br>
                    <textarea class="TextArea" name="pre" placeholder="文字列を入力してください">' . (isset($_POST["pre"]) ? $_POST["pre"] : '') . '</textarea>
                    <br>
                    <label>Post：</label><br>
                    <textarea class="TextArea" name="post" placeholder="文字列を入力してください">' . (isset($_POST["post"]) ? $_POST["post"] : '') . '</textarea> 
                    <hr><hr>
                    <input type="submit" value="送信" name="sb" style="width: 50px; height: 30px">
                </h2>
              </form>';
    if (!empty($err)) {
      echo '<h2><ul class="errorMessage" style="font-size: 33px; color: red; margin-left: 20px; font-family: \'Dela Gothic One\', sans-serif; font-weight: 7;">
                エラー<br>';
      foreach ($err as $e) {
        echo '<li>' . $e . '</li>';
      }
      echo '</ul></h2>';
    }
  }
  ?>
</body>

</html>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var loader = document.getElementById('loader');
    setTimeout(function() {
      loader.classList.add('fade-out');
    }, 2500);
  });
</script>