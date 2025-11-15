<?php

return [
  "debug" => isDev(),
  "charset" => "utf-8",
  "cache" => directory("store.cache.twig"),
  "auto_reload" => isDev(),
  "strict_variables" => true,
  "optimizations" => -1
];