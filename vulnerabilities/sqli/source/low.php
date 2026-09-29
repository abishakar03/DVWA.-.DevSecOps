<?php

if (isset($_REQUEST['Submit'])) {
    $id = filter_var($_REQUEST['id'] ?? '', FILTER_VALIDATE_INT);

    if ($id === false) {
        $html .= '<pre>Invalid user ID. Enter a whole number.</pre>';
        return;
    }

    switch ($_DVWA['SQLI_DB']) {
        case MYSQL:
            $connection = $GLOBALS['___mysqli_ston'];
            $stmt = mysqli_prepare(
                $connection,
                'SELECT first_name, last_name FROM users WHERE user_id = ?'
            );

            if ($stmt === false) {
                $html .= '<pre>Database query failed.</pre>';
                break;
            }

            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                $first = htmlspecialchars($row['first_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $last = htmlspecialchars($row['last_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($connection);
            break;

        case SQLITE:
            $connection = $GLOBALS['sqlite_db_connection'];
            $stmt = $connection->prepare(
                'SELECT first_name, last_name FROM users WHERE user_id = :id'
            );
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $result = $stmt->execute();

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $first = htmlspecialchars($row['first_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $last = htmlspecialchars($row['last_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
            }

            $stmt->close();
            break;
    }
}
?>
