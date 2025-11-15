<?php

function rootPath(): string
{
  return dirname(dirname(__FILE__));
}

function config(string $fileName): array
{
  return require rootPath() . "/config/{$fileName}.php";
}

function directory(string $path): string
{
  return rootPath() . "/" . str_replace(".", "/", $path);
}

function viteAsset($entry): array
{
  $manifestPath = rootPath() . "/public_html/build/.vite/manifest.json";
  if (!file_exists($manifestPath)) {
    throw new Exception("Manifest file not found: $manifestPath");
  }


  $manifest = json_decode(file_get_contents($manifestPath), true);
  if (!isset($manifest[$entry])) {
    throw new Exception("Entry '$entry' not found in manifest.");
  }

  return $manifest[$entry];
}