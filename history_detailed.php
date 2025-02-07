<?php
session_start();
$game = htmlspecialchars($_GET['game']);
$id = htmlspecialchars($_GET['id']);
$player = htmlspecialchars($_GET['player']);

setcookie('last_page', 'history_detailed.php?id=' . $id . '&game=' . $game . '');
?>

<!doctype html>

<html lang="pl">

<head>
    <meta charset="utf-8">

    <title>Gry.mimuw</title>
    <meta name="description" content="gierki">
    <meta name="author" content="kk418331+kj418271">

    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="https://www.mimuw.edu.pl/sites/default/files/mim_mini.png" type="image/png">
</head>

<body>

    <div class="up">
        <img class="left" src="https://www.mimuw.edu.pl/sites/all/themes/mimuwtheme/images/MIM_logo_sygnet_pl.png">

        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
        <script src="clock.js">
        </script>

        <div class="right">
            <?php if ($_COOKIE['active_username'] == $player)
                echo '<form action="profile.php">
                    <input type="submit" value="PROFIL" />
                </form>';
            else
                echo '<form>
                <input type="button" value="POWRÓT" onclick="history.back()">
               </form>';
            if (!isset($_COOKIE['active_username'])) {
                echo '<form action="login_page.php">
                    <input type="submit" value="ZALOGUJ" />
                </form>';
            }

            echo '<form action="index.php">
        <input type="submit" value="STRONA GŁÓWNA" />
    </form>';

            if (isset($_COOKIE['active_username']))
                echo '<form action="logout.php">
            <input type="submit" value="WYLOGUJ" />
        </form>';
            ?>

        </div>
    </div>

    <?php
    session_start();
    require_once('database_info.php');
    require_once('query.php');

    if (!($conn = oci_connect($dbuser, $dbpass, "//labora.mimuw.edu.pl/LABS"))) {
        header('Location:error_page.php');
        exit;
    }

    $notation = query($conn, "SELECT * from h" . $game . " where id=" . $id . "");

    $arr_size = count($notation[0]);

    $player_count = 0;
    $miejsce = 'MIEJSCE_';
    for ($i = 1; $i < $arr_size - 1; $i++) {
        $miejsce_tmp = $miejsce . $i;
        if ($notation[0][$miejsce_tmp][0] != '')
            $player_count++;
    }

    $notation = $notation[0]['HISTORIA'][0];
    $table_arr = explode(" ", $notation, -1);

    $table_header = '<div class="center2">
                    <table>
                    <thead>
                        <tr>
                        <th class="header glow" style="width:5vw;">TURA</th>';

    for ($i = 0; $i < $player_count; $i++)
        $table_header .= '<th class="header glow" style="width:20vw;">' . $table_arr[$i] . '</th>';

    $table_header .= '</tr>
                    </thead>';

    $table_arr_size = count($table_arr);

    $table_body = '';

    $color = "yellow";
    $isTurn = true;
    $table_body .= '<tr style="background-color:'.$color.';">';
    for ($i = $player_count; $i < $table_arr_size; $i++) {
        if($isTurn)
            $cls = "turn";
        else
            $cls = "notation";

        $table_body .= '<td class="'.$cls.'">' . $table_arr[$i] . '</td>';
    
        $isTurn = false;
        if ($i + 2 > $player_count * 2 && $i + 2 < $table_arr_size - 1 && ($i + 2) % ($player_count + 1) == 0) {
            if($color == "yellow")
                $color = "orange";
            else
                $color = "yellow";
            $isTurn = true;
            $table_body .= '</tr><tr style="background-color:'.$color.';">';
        }
    }
    $table_body .= '</tr>';
    $table_string = $table_header .
        '<tbody>'
        . $table_body .
        '</tbody>
                    </table>
                    </div>';

    echo $table_string;
    ?>

</body>

</html>