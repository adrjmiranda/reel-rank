<?php

return [
  "baseUrl" => fn(): string => baseUrl(),
  "is_dev" => fn(): bool => isDev(),
  "asset" => fn(string $filePath): string => baseUrl() . "/{$filePath}",
  "movie_img" => function (string $imgName): string {
    $baseUrl = baseUrl();
    $imgUrl = "{$baseUrl}/img/default/cape.webp";

    if (!empty($imgName))
      $imgUrl = "{$baseUrl}/img/movies/{$imgName}";

    return $imgUrl;
  },
  "user_image" => function (string $imgName): string {
    $baseUrl = baseUrl();
    $imgUrl = "{$baseUrl}/img/default/avatar.webp";

    if (!empty($imgName))
      $imgUrl = "{$baseUrl}/img/users/{$imgName}";

    return $imgUrl;
  },
  "vite_assets" => function (string $type): string {
    $viteMainRoot = env("VITE_MAIN_ROOT");
    if (isDev()) {
      return "
      <script type='module' src='http://localhost:5173/@vite/client'></script>
      <script type='module' src='http://localhost:5173/{$viteMainRoot}'></script>";
    }

    $baseUrl = baseUrl();
    $assetUrl = match ($type) {
      "js" => $baseUrl . "/build/" . viteAsset($viteMainRoot)["file"],
      "css" => viteAsset($viteMainRoot)[$type],
    };

    return match ($type) {
      "js" => " <script defer type='module' src='{$assetUrl}'></script>",
      "css" => implode(" ", array_map(fn($url) => "<link rel='stylesheet' href='{$baseUrl}/build/{$url}' />", $assetUrl)),
      default => ""
    };
  },
];