<?php

function path(string $path): string {
    return ROOT . '/' . $path;
}

function pathEtc(string $path): string {
    return path(INC_PREFIX_ETC . '/'     . $path);
}

function pathLib(string $path): string {
    return path(INC_PREFIX_LIB . '/' . $path);
}

function pathVar(string $path): string {
    return path(INC_PREFIX_VAR . '/' . $path);
}

function req(string $path) {
    require_once $path;
}

function reqEtc(string $path) {
    req(pathEtc($path . PHP_EXT));
}

function reqLib(string $path) {
    req(pathLib($path . PHP_EXT));
}

function reqVar(string $path) {
    req(pathVar($path . PHP_EXT));
}
