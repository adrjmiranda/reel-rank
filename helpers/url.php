<?php

function baseUrl(): string
{
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off") ? "https" : "http";
  $host = $_SERVER["HTTP_HOST"];

  return rtrim("{$protocol}://{$host}", "/");
}