<?php

reqEtc('mysql');

function db_connection():mysqli {
    static $connection;
    if (!$connection) {
        $connection = db_connect();
    }
    return $connection;
}

function db_connect():mysqli {
    $connection = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
    if (!$connection) {
        err('DB connection error: ' . mysqli_connect_error());
    }
    if (!mysqli_select_db($connection, DB_NAME)) {
        err('DB choose error: ' . mysqli_connect_error());
    }
    return $connection;
}

function db_select(string $query) {
    $result = db_query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        yield $row;
    }
}

function db_select_first(string $query) {
    $result = db_query($query);
    return mysqli_fetch_assoc($result);
}

function db_insert(string $table, array $fields): int {
    $sql = 'INSERT INTO `' . $table . '` SET ';
    $sqlFields = array();
    foreach ($fields as $field => $value) {
        $sqlFields[] = '`' . $field . '`="' . db_escape($value) . '"';
    }
    $sql .= implode(', ', $sqlFields);
    db_query($sql);
    return db_lastId();
}

function db_update($table, $fields, $where = '') {
    $sql = 'UPDATE `' . $table . '` SET ';
    $sqlFields = array();
    foreach ($fields as $field => $value) {
        $sqlFields[] = '`' . $field . '`="' . db_escape($value) . '"';
    }
    $sql .= implode(', ', $sqlFields);
    if ($where) {
        $sql .= ' WHERE ' . $where;
    }
    db_query($sql);
    return db_countAffected();
}

/**
 * @return bool|mysqli_result
 */
function db_query(string $query) {
    $result = mysqli_query(db_connection(), $query);
    if ($result === false) {
        err('DB query error: ' . mysqli_error(db_connection()) . ' [' . $query . ']');
    }
    return $result;
}

function db_escape(string $string): string {
    return mysqli_real_escape_string(db_connection(), $string);
}

function db_lastId(): int {
    return mysqli_insert_id(db_connection());
}

function db_countAffected(): int {
    return mysqli_affected_rows(db_connection());
}
