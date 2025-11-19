<?php

use ReelRank\Application\Services\SessionService;
use ReelRank\Application\Services\UserService;
use ReelRank\Infrastructure\Data\PersistentInput;
use ReelRank\Infrastructure\Message\Flash;

$flashMessage = new Flash();
$persistentInput = new PersistentInput();
$userService = new UserService(new SessionService());

return [
  "baseUrl" => fn(): string => baseUrl(),
  "is_dev" => fn(): bool => isDev(),
  "asset" => fn(string $filePath): string => baseUrl() . "/{$filePath}",
  "csrf_token_input" => function (): string {
    $csrfToken = bin2hex(random_bytes(64));
    $_SESSION['CSRF_TOKEN'] = $csrfToken;

    return "<input type='hidden' name='csrfToken' value='{$csrfToken}' />";
  },
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
  "flash_message" => fn(string $key): string => $flashMessage->get($key)[1] ?? '',
  "persistent_input" => fn(string $field): mixed => $persistentInput->get($field),
  "session_message" => fn(string $key): array => $flashMessage->get($key),
  'is_logged_in' => fn(): bool => $userService->isLoggedIn()
];