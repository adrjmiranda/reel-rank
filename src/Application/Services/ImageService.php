<?php

namespace ReelRank\Application\Services;

use ReelRank\Domain\Entities\Category;
use ReelRank\Domain\Entities\Movie;
use ReelRank\Domain\Entities\User;
use ReelRank\Domain\ValueObjects\Image;
use ReelRank\Infrastructure\Message\Flash;
use Psr\Http\Message\ServerRequestInterface as Request;

class ImageService
{
  private const array EXTENSIONS_ENABLED = ['jpg', 'jpeg', 'png', 'webp'];

  public function __construct(
    private Flash $flash
  ) {
  }

  private function uploadDirectory(string $folder): string
  {
    return empty($folder) ? rootPath() . "/public_html/img" : rootPath() . "/public_html/img/{$folder}";
  }

  public function save(Request $request, string $folder, Image $oldImage): ?string
  {
    $imagename = null;

    $uploadedFiles = $request->getUploadedFiles();
    $uploadedImage = $uploadedFiles['image'] ?? null;

    $okType = true;
    if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
      $filename = $uploadedImage->getClientFilename();
      $extension = pathinfo($filename, PATHINFO_EXTENSION);
      if (!\in_array($extension, self::EXTENSIONS_ENABLED)) {
        $this->flash->set('image', 'Somente permitidas imagens do tipo: ' . implode(', ', self::EXTENSIONS_ENABLED) . '.');
        $okType = false;
      }

      if ($okType) {
        $directory = $this->uploadDirectory($folder);
        if (!is_dir($directory))
          mkdir($directory, 0755, true);

        if ($oldImage !== null) {
          $lastImage = $directory . DIRECTORY_SEPARATOR . $oldImage->value();
          if (file_exists($lastImage)) {
            unlink($lastImage);
          }
        }

        $imagename = bin2hex(random_bytes(64)) . ".{$extension}";
        $uploadedImage->moveTo($directory . DIRECTORY_SEPARATOR . $imagename);
      }
    }

    return $imagename;
  }


}