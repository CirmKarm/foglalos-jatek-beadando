<?php
    session_start();

    // Ha van valami a request-ben, akkor onnan vesszuk az ertekeket. 
    if (!empty($_REQUEST)) {
        $setup = $_REQUEST;
    }
    // Egyebkent a ssetup.txt fajbol toltjuk vissza.
    else {
        $setup = include 'ssetup.txt';
    }
    //echo "<pre>";
    //print_r($_REQUEST);
    //print_r($setup);
    
    // A sessionbe is elmentjuk a beallitasokat. Innen olvassuk majd ki a jatek inditas oldalon.
    $_SESSION["game-setup"] = $setup;
    
    // Visszamentjuk a $setup valtozot az ssetup.txt fajlba.
    file_put_contents('ssetup.txt', '<?php return ' . var_export($setup, true) . ';');
    
    if (!empty($_REQUEST) && $setup["jatekvalaszt"] == "Foglalós") {
        header('Location: foglalos-index.php');
        exit();
    }
    
  ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Beállítások</title>

<link rel="stylesheet" type="text/css" href="css/beallitasok.css">
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body id="beallitasok-page">

<header>
<h1>Teljes név <br/>
<span>Valami izé </span></h1>
<nav>
<a href="index.html"> Nyítólap </a>
<a href="intro.html"> Bemutatkozas </a>
<a href="beallitasok.php"> Játék </a>
<a href="galery.html"> Galéria </a>
<a href="download.html"> Letöltés </a>
</nav>

</header>

<div id="Container">
  <div id="Header"></div>
  <div id="MainContent">
    <h3 align="center">
        <strong>ÜDV AZ OLDALON!</strong>
    </h3>
    <p>Játékok:</p>
    <ul>
      <li>Foglalós:</li>
      <blockquote>
        <p align="justify">2 játékos játszik tetszőleges méretű sakktáblán (fekete-fehér mezők), melynek a jobb felső mezőjére nem lehet bábut rakni. Felváltva rakják a bábukat, aki lerakja 1 szabad mezőre a bábuját, az a lerakott bábútól lefelé és balra lefoglal minden mezőt. Ezekre már nem lehet rakni. Az nyer, aki utoljára tud rakni! Az alábbi ábrán az „a” nyert, ő rakott 3. alkalommal, utoljára!</p>
      </blockquote>
      <li>Cserélős: </li>
      <blockquote>
        <p align="justify">1 játékos játssza, de kettő féle bábu sort (x, o) kell megcserélnie. Szemben vannak egymással a bábuk, a kettő különböző sort egy üres mező választja el. A bábu csak előre haladhat, csak üres mezőre léphet, vagy átugorhat 1 bábut, ha így üres mezőre lép. Akkor nyert, ha sikerült felcserélni a kiinduló állapotot.</p>
      </blockquote>
      <li>Kihúzós:
        <blockquote>
          <p align="justify">2 játékos játssza egy sorba kirakott véletlen számú pálcikákat látva. A beállításokban meghatározott maximális számú pálcikát vehetjük el, húzhatjuk le, az nyer, aki az utolsót leveszi.</p>
        </blockquote>
      </li>
    </ul>
  
 
<blockquote>    

  <form method="post" action="beallitasok.php"/>
    <div align="left">
    <table height="111" border="1" align="center">
      <tr>
        <td width="153" height="105">
            <div align="center">Játék</div>
            <div align="center">
                  <select name="jatekvalaszt" id="jatekvalaszt">
                    <option value="Foglalós"<?= $setup['jatekvalaszt']=='Foglalós' ? 'selected="selected"' : ''; ?>>Foglalós</option>
                    <option value="Cserélős"<?= $setup['jatekvalaszt']=='Cserélős' ? 'selected="selected"' : ''; ?>>Cserélős</option>
                    <option value="Kihúzós"<?= $setup['jatekvalaszt']=='Kihúzós' ? 'selected="selected"' : ''; ?>>Kihúzós</option>
                  </select>
            </div>
        </td>
        <td width="153">
          <div align="center">Háttérszín</div>
          <div align="center">
            <select name="hatterszin" size="1" id="hatterszin">
              <option value="DarkGray"        <?=$setup['hatterszin']=='DarkGray'       ? 'selected="selected"' : ''; ?>>Szürke</option>
              <option value="DeepSkyBlue"     <?=$setup['hatterszin']=='DeepSkyBlue'    ? 'selected="selected"' : ''; ?>>Kék</option>
              <option value="MediumSeaGreen"  <?=$setup['hatterszin']=='MediumSeaGreen' ? 'selected="selected"' : ''; ?>>Zöld</option>
              <option value="MediumPurple"    <?=$setup['hatterszin']=='MediumPurple'   ? 'selected="selected"' : ''; ?>>Lila</option>
            </select>
          </div>
        </td>
        <td width="153">
          <div align="center">Idő</div>
          <div align="center">
                <select name="idobeallitas" size="1" id="idobeallitas">
                  <option value="5perc"<?=$setup['idobeallitas']=='5perc' ? 'selected="selected"' : ''; ?>>5perc</option>
                  <option value="10perc"<?=$setup['idobeallitas']=='10perc' ? 'selected="selected"' : ''; ?>>10perc</option>
                  <option value="15perc"<?=$setup['idobeallitas']=='15perc' ? 'selected="selected"' : ''; ?>>15perc</option>
                </select>
            </div>
        </td>
        <td width="153">
          <div align="center">Bábu1</div>
          <div align="center">
            <select name="babu1" size="1" id="babu1" >
              <option value="Macska"<?=$setup['babu1']=='Macska' ? 'selected="selected"' : ''; ?>>Macska</option>
              <option value="Fóka"<?=$setup['babu1']=='Fóka' ? 'selected="selected"' : ''; ?>>Fóka</option>
              <option value="Tigris"<?=$setup['babu1']=='Tigris' ? 'selected="selected"' : ''; ?>>Tigris</option>
            </select>
          </div>
        </td>
        <td width="153" align="center" valign="middle">
          <div align="center">Bábu2</div>
          <div align="center">
            <select name="babu2" size="1" id="babu2" >
              <option value="Majom"<?=$setup['babu2']=='Majom' ? 'selected="selected"' : ''; ?>>Majom</option>
              <option value="Nyúl"<?=$setup['babu2']=='Nyúl' ? 'selected="selected"' : ''; ?>>Nyúl</option>
              <option value="Kutya"<?=$setup['babu2']=='Kutya' ? 'selected="selected"' : ''; ?>>Kutya</option>
            </select>
            </div>
        </td>
      </tr>
     </table>

    <blockquote>
        <div align="center">
          <input name="Inditas" type="submit" id="Inditas" value="Játék indítása">
        </div>

      <p align="justify">&nbsp;</p>
      <div align="right">
        <strong>A feladatot készítették: </strong>Barlangi Beáta,  Horváth Zsuzsanna, Nagy Szilárd, Péter András.
      </div>
      </blockquote>
        
        </div>
    </form>
  </div>


</body>
</html>