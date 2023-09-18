<?php
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);

$connection = Bitrix\Main\Application::getConnection();
$file = __DIR__ .'/input.xml';
$xml = simplexml_load_file($file) or die("Error: Cannot create object");

foreach ($xml->children() as $row) {
    $title = $row->title;
    $link = $row->link;
    $description = $row->description;
    $keywords = $row->keywords;
    $query = "INSERT INTO tbl_tutorials(title,link,description,keywords) VALUES ('" . $title . "','" . $link . "','" . $description . "','" . $keywords . "')";
    $result = $connection->query($query);

    if (! empty($result)) {
        $affectedRow ++;
    } else {
        $error_message = "error";
    }
}

if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}

#10.0.000.000:	/etc/cron.d/0hourly
# "Стандарт" битрикс:
#* * * * * bitrix test -f /var/www/html/bx-site/local/1c_exchange/cron/uphol.php && { /usr/bin/php -f /var/www/html/bx-site/local/1c_exchange/cron/uphol.php; } >/dev/null 2>&1
# Вариант, адаптированный к существующему серверу
#* * * * * apache php -f /var/www/html/bx-site/local/1c_exchange/cron/uphol.php >/dev/null 2>&1
