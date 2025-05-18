<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/passgen.php";
   //проверка и инициализация параметров
   $lenght = 6;
   $password = "";
   $requiredSymbols = "";
   $exludedSymbols = "";
   $numbers ="0123456789";
   $lowercase ="abcdefghijklmnopqrstuvwxyz";
   $uppercase ="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $specialSymbols ="!@#$%^&*()-_=+[]{};:,.<>?";
   $isNumbers = true;
   $isLowercase = true;
   $isUppercase = true;
   $isSpecialSymbols = true;
   $excludedCombinations = [];
   $characterPool="";
   $error="";
  //установка параметров после отпарвки формы
   if (isset($_GET["action"]) && $_GET["action"] == "gen-pass") {
     
      if(!isset($_GET["numbers"])){
        $numbers="";
        $isNumbers = false;
      }
      if(!isset($_GET["lowercase"])){
        $lowercase="";
        $isLowercase = false;
      }
      if(!isset($_GET["uppercase"])){
        $uppercase="";
        $isUppercase = false;
      }
      if(!isset($_GET["specialSymbols"])){
        $specialSymbols="";
        $isSpecialSymbols = false;
      }
      $lenght = $_GET["lenght"];
      $requiredSymbols = $_GET["requiredSymbols"];
      $exludedSymbols = $_GET["exludedSymbols"];
      $characterPool=$numbers.$lowercase.$uppercase.$specialSymbols;
      $excludedCombinations = explode(",", $_GET["excludedCombinations"]);
      $password = generatePassword($_GET["lenght"], $_GET["requiredSymbols"], $_GET["exludedSymbols"], $characterPool, ...$excludedCombinations);
        if($password=== null){
          $password="";
          $error="Ошибка ввода данных!";
        }
        
    }
 
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>PHP password generator</title>
    <style>
<?php include $_SERVER["DOCUMENT_ROOT"]."/style.css"; ?>
</style>
</head>
<body>
    <div class="container text-center main-div"><br>
  <h3 class="my-4">Генератор пароля</h3>
  <form class="form row g-3 justify-content-center" method="get" action="/" >
        <div class="mb-3 ">
          <label for="length" class="form-label text-nowrap">Количество символов</label>
          <input type="number" class="form-control mx-auto" name="lenght" min="4"  value = <?= $lenght ?>>
        </div>
        <div class="form-check">
          <input class="form-check-input mx-auto" type="checkbox" name="numbers" <?php echo $isNumbers ? "checked" : ""; ?>>
          <label class="form-check-label" for="numbers">
            0-9
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input mx-auto" type="checkbox" name="lowercase" <?php echo $isLowercase ? "checked" : ""; ?>>
          <label class="form-check-label" for="lowercase">
            a-z
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input mx-auto" type="checkbox" name="uppercase" <?php echo $isUppercase ? "checked" : ""; ?>>
          <label class="form-check-label" for="uppercase">
            A-Z
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input mx-auto" type="checkbox" name="specialSymbols" <?php echo $isSpecialSymbols ? "checked" : ""; ?>>
          <label class="form-check-label" for="specialSymbols">
            Спецсимволы
          </label>
        </div>
        <div class="form-text">
          <input class="form-control mx-auto" type="text" name="requiredSymbols" value = <?= htmlspecialchars($requiredSymbols) ?>>
          <label class="form-label" for="requiredSymbols">
            Обязательные символы
          </label>
        </div> 
        <div class="form-text">
          <input class="form-control mx-auto" type="text" name="exludedSymbols" value = <?= htmlspecialchars($exludedSymbols) ?>>
          <label class="form-label" for="exludedSymbols">
            Запрещенные символы
          </label>
        </div> 
        <div class="form-text combinations">
          <input class="form-control mx-auto combinations" type="text" name="excludedCombinations" value = <?php echo htmlspecialchars(join(",", $excludedCombinations)) ?>>
          <label class="form-label" for="excludedCombinations" >
          Введите заперщенные слова через запятую
          </label>
        </div> 
  <button type="submit" class="btn btn-primary my-4" name="action" value="gen-pass" >
    Генерировать
</button>   
</form>

 <h5><label class="my-2">Ваш пароль:</label></h5> 
 <span class="my-2" name="password"><?= htmlspecialchars($password) ?></span>
  <span class="my-2" name="error"><?= $error ?></span>
 <br><br>
</div>

</body>
</html>