<?php

define('VERSION', '1.0');

$timestart = microtime(TRUE);
$GLOBALS['status'] = array();

$unzipper = new Unzipper;
$deployer = new Deployer;

if (isset($_POST['doinstall'])) {
    // Check if an archive was selected for unzipping.
    $archive = isset($_POST['zipfile']) ? strip_tags($_POST['zipfile']) : '';

    //unzip
    $unzipper->prepareExtraction($archive, '');

    //deploy
    $deployer->deployLaravel($_POST);
}


$timeend = microtime(TRUE);
$time = round($timeend - $timestart, 4);

/**
* Class Unzipper
*/
class Unzipper {
    public $localdir = '.';
    public $zipfiles = array();

    public function __construct() {

        if ($dh = opendir($this->localdir)) {
            while (($file = readdir($dh)) !== FALSE) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'zip')
                {
                    $this->zipfiles[] = $file;
                }
            }
            closedir($dh);

            if (!empty($this->zipfiles)) {
                $GLOBALS['status'][] = '.zip soubor nalezen';
            }
            else {
                $GLOBALS['status'][] = 'Nenalezen soubor .zip';
            }
        }
    }

    /**
    * Prepare and check zipfile for extraction.
    *
    * @param string $archive
    *   The archive name including file extension. E.g. my_archive.zip.
    * @param string $destination
    *   The relative destination path where to extract files.
    */
    public function prepareExtraction($archive, $destination = '') {
        // Determine paths.
        if (empty($destination)) {
            $extpath = $this->localdir;
        }
        else {
            $extpath = $this->localdir . '/' . $destination;
            // Todo: move this to extraction function.
            if (!is_dir($extpath)) {
                mkdir($extpath);
            }
        }
        // Only local existing archives are allowed to be extracted.
        if (in_array($archive, $this->zipfiles)) {
            self::extract($archive, $extpath);
        }
    }

    /**
    * Checks file extension and calls suitable extractor functions.
    *
    * @param string $archive
    *   The archive name including file extension. E.g. my_archive.zip.
    * @param string $destination
    *   The relative destination path where to extract files.
    */
    public static function extract($archive, $destination) {
        $ext = pathinfo($archive, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'zip':
                self::extractZipArchive($archive, $destination);
                break;
            default:
                throw new Exception("bad extension");
                break;
        }
    }

    /**
    * Decompress/extract a zip archive using ZipArchive.
    *
    * @param $archive
    * @param $destination
    */
    public static function extractZipArchive($archive, $destination) {
        // Check if webserver supports unzipping.
        if (!class_exists('ZipArchive')) {
            $GLOBALS['status'][] =  'Chyba: verze php nepodporuje rozbalení souborů.';
            return;
        }

        $zip = new ZipArchive;

        // Check if archive is readable.
        if ($zip->open($archive) === TRUE) {
            // Check if destination is writable
            if (is_writeable($destination . '/')) {
                $zip->extractTo($destination);
                $zip->close();
                $GLOBALS['status'][] = 'Soubory byly rozbaleny';
            }
            else {
                $GLOBALS['status'][] = 'Chyba: chybí přístupová práva pro zápis do souborů.';
            }
        }
        else {
            $GLOBALS['status'][] =  'Chyba: špatný .zip soubor';
        }
    }
}

class Deployer {

    public function defaultLocation()
    {
        return $_SERVER['SERVER_NAME'];
    }

    private function createEnv($data)
    {
        extract($data);
        $key = base64_encode(random_bytes(32))  ;
        return
        "
APP_NAME=Knihovna
APP_ENV=production
APP_KEY=base64:$key
APP_DEBUG=false
APP_URL=$url

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=$dbHost
DB_PORT=$dbPort
DB_DATABASE=$dbName
DB_USERNAME=$dbUser
DB_PASSWORD=$dbPass

DEFAULT_USER_EMAIL=admin@gsh.cz
DEFAULT_USER_PASSWORD=knih*ovna

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=

REDIS_HOST=
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME=\"\${APP_NAME}\"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY=\"\${PUSHER_APP_KEY}\"
MIX_PUSHER_APP_CLUSTER=\"\${PUSHER_APP_CLUSTER}\"
";
    }

    private function createHTAccess(){
        return
"<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]
</IfModule>";
    }

    public function deployLaravel($data)
    {
        if(isset($data['test']))
        {
            rename('.env.server', '.env');
        }
        else file_put_contents('.env' , $this->createEnv($data));
        file_put_contents('.htaccess' , $this->createHTAccess());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Instalace knihovny</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        .form-field{
            display: block;
        }
    </style>

</head>
<body>
    <p  class="status status--<?php echo strtoupper(key($GLOBALS['status'])); ?>">
        Status: <?php echo reset($GLOBALS['status']); ?><br/>
        <span class="small">Čas zpracování: <?php echo $time; ?> sekund</span>
    </p>
    <h2>První krok</h2>
    <form action="" method="POST">
        <fieldset>
            <legend>Instalační soubor</legend>
                <label for="zipfile">Vyberte soubor s webem k rozbalení:</label>
                <select name="zipfile" size="1" class="select">
                <?php foreach ($unzipper->zipfiles as $zip) {
                    echo "<option>$zip</option>";
                } ?>
                </select>
        </fieldset>
        <fieldset>
            <legend>Umístění</legend>
                <label for="url">Zadejte adresu, na které bude web umístěn (např. knihovna.gsh.cz):</label>
                <input  class='form-field' id='url' name='url' value="<?= $deployer->defaultLocation() ?>" required>
        </fieldset>
        <fieldset>
            <legend>Databáze</legend>
            <div> Driver: mysql</div>
                <?php
                $fields = [
                    ['dbHost', 'server s databází', ''],
                    ['dbPort', 'port připojení k databázi', '3306'],
                    ['dbName', 'název databáze', ''],
                    ['dbUser','uživatelské jméno (uživatel musí mít všechna práva)',''],
                    ['dbPass','heslo','']
                ];
                foreach ($fields as $field) {
                    echo "<label  for='{$field[0]}'> {$field[1]} </label>";
                    echo "<input class='form-field' id='{$field[0]}' name='{$field[0]}' value='{$field[2]}'>";
                } ?>
        </fieldset>
        <fieldset>
        <legend> Cron </legend>
            <span> Kvůli odesílání emailů a zneplaťnování starých rezervací je potřeba pravidelné spouštění skriptu. <br>
            Systém sám spravuje naplánované úkony, spouštět je potřeba pouze hlavní skript. Na to jsou dvě možnosti:
            </span>
            <ul>
            <li>přes cli - je potřeba spustit php skript v kořenovém adresáři s názvem artisan a parametrem schedule:run,
            tj. php artisan schedule:run </li>
            <li>přes http - na adrese /cron</li>
            </ul>
            <span>Frekvence spouštění není důležitá, postačí i jednou denně.</span>
        </fieldset>
        <fieldset>
        <legend> Přesměrování </legend>
            <span>Veškerý provoz je nutno směřovat do složky public do souboru index.html (public/index.html) <br>
            Na Apache serveru se o toto postará .htaccess soubor v kořenovém adresáři, na nginx a ostatních serverech je potřeba přepisování nastavit ručně.
            </span>
                <div>
            <label for="dohtaccess">Vygenerovat .htaccess soubor</label>

            <input type="checkbox"  id='dohtaccess' name='dohtaccess' >
            </div>
        </fieldset>
        <fieldset>
        <legend> Emaily </legend>
            <label for="emailDriver">Způsob odesílání emailů</label>
            <select id='emailDriver' name='emailDriver' >
            <option value="smtp" selected>SMTP</option>
            <option value="mailjet">MailJet</option>
            </select>
        </fieldset>
        <fieldset>
        <legend> Vývojová nastavení </legend>
            <label for="test">Použít testovací nastavení serveru</label>
            <input type="checkbox" id='test' name='test' >
        </fieldset>

        <input type="submit" name="doinstall" class="submit" value="Instalovat">
    </form>
    <h2>Druhý krok</h2>
    <a href="<?= $_POST['url'] ?>/instalace">Pokračujte na instalaci serveru kliknutím na odkaz </a>
    <p class="version">Verze instalátoru: <?php echo VERSION; ?></p>
</body>
</html>
