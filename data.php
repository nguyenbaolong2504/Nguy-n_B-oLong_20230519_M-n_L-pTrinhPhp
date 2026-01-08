<?php
declare(strict_types=1);

function data_path(string $file): string {
    return __DIR__ . '/../data/' . $file;
}

function read_json(string $file, array $default = []): array {
    $path = data_path($file);
    if (!file_exists($path)) return $default;
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : $default;
}

function write_json(string $file, array $data): void {
    $path = data_path($file);
    if (!is_dir(dirname($path))) mkdir(dirname($path), 0777, true);
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
