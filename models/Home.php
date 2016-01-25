<?php
namespace models;

use components\Db as Db;
use PDO;

class Home
{
    public static function showMessages()
    {
        $db = Db::getConnection();

        $query = 'SELECT * FROM messages';
        $result = $db->prepare($query);
        $result->execute();
        $row = $result->rowCount();

        if ($row) {
            $arrayOfChunk = array();

            $query = 'SELECT * FROM messages JOIN users ON users.user_id=messages.user_id ORDER BY message_date';
            $result = $db->prepare($query);
            $result->execute();
            $rows = $result->rowCount();
            for ($j = 0; $j < $rows; $j++) {
                $chunkRow = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT, $j);
                $chunkRow['user_message'] = stripslashes($chunkRow['user_message']);

                if ($chunkRow['is_visible']) {
                    $arrayOfChunk[] = $chunkRow;
                } else {
                    continue;
                }
            }
            return $arrayOfChunk;
        }
        return false;
    }
}
