
<?php
$servername = 'localhost';
$username = 'root';
$password = 'VerySecureRoot';
$database = 'sandbox';
$conn = mysqli_connect($servername, $username, $password, $database);

$debug = false; //Určeno pro kontrolu výstupu formuláře

if(!$conn) {
    $DBconnection = "Chyba připojení";
    die("Chyba připojení:<br>".mysqli_connect_error());
}
else {
    $DBconnection = "Připojena";
}


if (isset($_POST['submit'])) {

    // Kontrola správnosti vstupu
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['empNo']) && isset($_POST['password']) && is_numeric($_POST['empNo']) && strlen($_POST['empNo']) < 6) {

        // Kontrola duplicity uživatelů
        $sql_check_duplication = "SELECT id FROM uzivatel WHERE name = ? OR empNo = ?";
        $stmt_check_duplication = mysqli_prepare($conn, $sql_check_duplication);
        mysqli_stmt_bind_param($stmt_check_duplication, "ss", $_POST['name'], $_POST['empNo']);
        mysqli_stmt_execute($stmt_check_duplication);
        $result_check_duplication = mysqli_stmt_get_result($stmt_check_duplication);

        if (mysqli_num_rows($result_check_duplication) > 0) {
            echo '<script>alert("Uživatel nebo zaměstnanecké číslo již existuje")</script>';
        } else {
            // SQL dotaz pro vložení nového uživatele
            $sql_insert_reg = "INSERT INTO `uzivatel` (`id`, `name`, `empNo`, `password`) VALUES (NULL, ?, ?, ?)";
            $stmt_insert_reg = mysqli_prepare($conn, $sql_insert_reg);
            mysqli_stmt_bind_param($stmt_insert_reg, "sss", $_POST['name'], $_POST['empNo'], $hash);

            // Debug výstup
            if ($debug = true) {
                echo "<br>Uživatelský vstup:<br>Debug: " . $_POST['debug'] . "<br>Databáze: " . $DBconnection . "<br>Jméno: " . $_POST['name'] . "<br>Zam. číslo: " . $_POST['empNo'] . " String leght: " . strlen($_POST['empNo']) . "<br>Heslo: " . $_POST['password'] . "<br>Hash: " . $hash . "<br><br>SQL příkaz: " . $sql_insert_reg . "<br><br>";
            }

            // Zápis dotazu do databáze
            $newUser = mysqli_stmt_execute($stmt_insert_reg);
            mysqli_stmt_close($stmt_insert_reg);

            if (!$newUser) {
                echo '<script>alert("Chyba v SQL vstupu, zkontrolujte dotaz")</script>';
            } else {
                echo '<script>alert("Registrace proběhla úspěšně!")</script>';
            }
        }

        mysqli_stmt_close($stmt_check_duplication);
    }
    // Kontrola max. délky čísla zaměstnance
    elseif (strlen($_POST['empNo']) > 5) {
        $stLn = strlen($_POST['empNo']);
        echo '<script>alert("Zam. číslo je příliš dlouhé, musí být maximálně pěticiferné. Vaše je " . $stLn . "ciferné")</script>';
    }
}

?>


<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Tanks A Lot</title>
    <link rel="stylesheet" href="./css/stajl.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
          integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"/>
</head>
<body>

<header id="navbar">
    <div class="group">
        <a href="index.html"><img class="logo" src="img/Web%20Logo.png" alt="Logo firmy"></a>
    </div>
    <div>
        <label class="menu-btn" for="drop"><i class="fa-solid fa-bars fa-4x"></i></label>
        <input type="checkbox" id="drop">
        <div class="narrow-menu group">
            <ul>
                <li><a href="index.html"><h3 class="btn">Hlavní stránka</h3></a></li>
                <li><a href="about.html"><h3 class="btn">O nás</h3></a></li>
                <li><a href="inventory.html"><h3 class="btn">Naše sbírka</h3></a></li>
                <li><a href="kontakt.html"><h3 class="btn">Kontakt</h3></a></li>
                <li><a href="rezervace.php"><h3 class="rez-current">Rezervace</h3></a></li>
            </ul>
        </div>
    </div>
    <div class="group wide-menu">
        <a href="index.html"><h3 class="btn">Hlavní stránka</h3></a>
        <a href="about.html"><h3 class="btn">O nás</h3></a>
        <a href="inventory.html"><h3 class="btn">Naše sbírka</h3></a>
        <a href="kontakt.html"><h3 class="btn">Kontakt</h3></a>
        <a href="rezervace.php"><h3 class="rez-current">Rezervace</h3></a>
    </div>
</header>

<section id="rezervace">
    <form name="rezervace" method="post" accept-charset="utf-8" autocomplete="off">
        <div class="rez-form">
            <ul>
                <li>
                    <h3>Rezervace jízdy</h3>
                </li>
                <li>
                    <div>
                        <label for="jmeno"> Celé jméno:<span title="Povinné pole!" class="red">*</span> </label>
                    </div>
                    <div>
                        <span><input type="text" id="jmeno" name="jmeno" placeholder="Jméno" required=""></span>
                    </div>
                    <div>
                        <span><input type="text" id="prijmeni" name="prijmeni" placeholder="Příjmení" required=""></span>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="telefon"> Telefon:<span title="Povinné pole!" class="red">*</span> </label>
                    </div>
                    <div>
                        <span><input type="tel" id="telefon" name="telefon" placeholder="Tel." required=""></span>
                    </div>
                </li>
                <li data-type="email">
                    <div>
                        <label for="email"> E-mail:<span title="Povinné pole!" class="red">*</span> </label>
                    </div>
                    <div>
                        <input type="email" id="email" name="email" placeholder="E-mail" required="">
                    </div>
                </li>
                <li>
                    <div>
                        <label for="vozidlo"> Zvolte vozidlo:<span title="Povinné pole!" class="red">*</span> </label>
                    </div>
                    <div>
                        <select id="vozidlo" name="vozidlo" required="" aria-label="Zvolte vozidlo:">
                            <option value="Leopard A1A1">Leopard A1A1</option>
                            <option value="T-34">T-34</option>
                            <option value="IS-3">IS-3</option>
                            <option value="M 48">M 48</option>
                            <option value="M 47">M 47</option>
                            <option value="T-72M1">T-72M1</option>
                            <option value="Chieftain 2">Chieftain 2</option>
                            <option value="T-54">T-54</option>
                            <option value="Centurion">Centurion</option>
                        </select>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="osobyPoc"> Počet osob:<span title="Povinné pole!" class="red">*</span> </label>
                    </div>
                    <div>
                        <select id="osobyPoc" name="osobyPoc" required="" aria-label="Počet osob:">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="jizda"> Zvolte typ jízdy:<span title="Povinné pole!" class="red">*</span> </label>
                    </div>
                    <div>
                        <select id="jizda" name="jizda" required="" aria-label="Zvolte typ návštěvy:">
                            <option selected="" value="Pouze jízda">Pouze jízda (2500 Kč vč. DPH + 1000Kč/další osoba)</option>
                            <option value="Jízda a střelba">Jízda a střelba (4000 Kč vč. DPH+ 1000Kč/další osoba)</option>
                        </select>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="pozn"> Poznámky: </label>
                    </div>
                    <div>
                        <textarea id="pozn" class="pozn" name="pozn" placeholder="Vaše poznámky (max. 1000 znaků)"></textarea>
                    </div>
                </li>
                <li>
                    <div>
                        <div><button type="submit" class="submit">Odeslat</button></div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</section>

</body>
</html>