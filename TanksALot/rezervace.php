<?php
$servername = 'innodb.endora.cz:3306';
$username = 'tanksalot';
$password = 'TanksALot2024';
$database = 'tanksalot';
$conn = mysqli_connect($servername, $username, $password, $database);


// Ověření připojení k DB
if(!$conn) {
    $DBconnection = "Chyba připojení";
    die("Chyba připojení:<br>".mysqli_connect_error());
}
else {
    $DBconnection = "Připojena";
}


if (isset($_POST['submit'])) {

    // Ověření zda uživatel měnil údaje v dropdown menu
    $vozidla = array("Leopard A1A1", "T-34", "IS-3", "M 47", "M 48", "T-72M1", "Chieftain 2", "T-54", "Centurion");
    $osoby = array(1,2,3);
    $jizdy = array("Pouze jízda", "Jízda a střelba");
    $vozSel = $_POST['vozidlo'];
    $osSel = $_POST['osobyPoc'];
    $jizSel = $_POST['jizda'];
    if (!in_array($vozSel, $vozidla, $strict = false)
        || !in_array($osSel, $osoby, $strict = false)
        || !in_array($jizSel, $jizdy, $strict = false)) {
        echo '<script>alert("Jedno z polí obsahuje cizí hodnotu")</script>';
        header("Refresh:0");
    }

    // Kontrola správnosti vstupu
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jmeno']) &&
        isset($_POST['prijmeni']) && isset($_POST['telefon']) &&
        isset($_POST['email']) && isset($_POST['vozidlo']) &&
        isset($_POST['osobyPoc']) && isset($_POST['jizda'])) {

            // SQL dotaz pro vložení nového uživatele, ochráněn proti SQL injection
            $sql_insert_rez = "INSERT INTO `jizdy` (`jmeno`, `prijmeni`, `telefon`, `email`, `vozidlo`, `osobyPoc`, `jizda`, `pozn`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert_rez = mysqli_prepare($conn, $sql_insert_rez);
            mysqli_stmt_bind_param($stmt_insert_rez, "ssssssss", $_POST['jmeno'], $_POST['prijmeni'], $_POST['telefon'], $_POST['email'], $_POST['vozidlo'], $_POST['osobyPoc'], $_POST['jizda'], $_POST['pozn']);

            // Debug výstup, určeno pro kontrolu výstupu formuláře
            $debug = "on";
            if ($debug = "on") {
                echo "<br>Uživatelský vstup:
                <br>Debug: " . $debug .
                "<br>Databáze: " . $DBconnection .
                "<br>Jméno: " . $_POST['jmeno'] .
                "<br>Příjmení: " . $_POST['prijmeni'] .
                "<br>Telefon: " . $_POST['telefon'] .
                "<br>Email: " . $_POST['email'] .
                "<br>Vozidlo: " . $_POST['vozidlo'] .
                "<br>Počet osob: " . $_POST['osobyPoc'] .
                "<br>Typ jízdy: " . $_POST['jizda'] .
                "<br>Poznámka: " . $_POST['pozn'] .
                "<br><br>SQL příkaz: " . $sql_insert_rez . "<br><br>";
            }
            else {
                echo '<script>console.log("Debug off")</script>;';
            }

            // Zápis dotazu do databáze
            $newRez = mysqli_stmt_execute($stmt_insert_rez);
            mysqli_stmt_close($stmt_insert_rez);

            if (!$newRez) {
                echo '<script>alert("Chyba v SQL vstupu, zkontrolujte dotaz")</script>';
            } else {
                echo '<script>alert("Rezervace proběhla úspěšně!")</script>';
            }
    }


    // Znemožňuje odeslaní prázdného formuláře
    else {
        echo '<script>alert("Zadejte všechny potřebné informace do formuláře")</script>';
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
                        <div><button type="submit" name="submit" class="submit">Odeslat</button></div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</section>

</body>
</html>