<?php

namespace ReelRank\Application\Services;

use ReelRank\Domain\Entities\Category;
use ReelRank\Domain\Entities\Movie;
use ReelRank\Domain\Entities\User;
use ReelRank\Infrastructure\Message\Flash;
use Psr\Http\Message\ServerRequestInterface as Request;

class ImageService
{
  private const array EXTENSIONS_ENABLED = ['jpg', 'jpeg', 'png', 'webp'];

  public function __construct(
    private Flash $flash
  ) {
  }

  private function uploadDirectory(User|Movie|Category $entityData): string
  {
    $folder = match (get_class($entityData)) {
      'ReelRank\Domain\Entities\User' => '/users',
      'ReelRank\Domain\Entities\Movie' => '/movies',
      'ReelRank\Domain\Entities\Category' => '/categories',
      default => '',
    };

    return rootPath() . "/public_html/img{$folder}";
  }

  public function save(Request $request, User|Movie|Category $entityData): ?string
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
        $directory = $this->uploadDirectory($entityData);
        if (!is_dir($directory))
          mkdir($directory, 0755, true);

        if ($entityData->image() !== null) {
          $oldImage = $directory . DIRECTORY_SEPARATOR . $entityData->image()->value();
          if (file_exists($oldImage)) {
            unlink($oldImage);
          }
        }

        $imagename = bin2hex(random_bytes(64)) . ".{$extension}";
        $uploadedImage->moveTo($directory . DIRECTORY_SEPARATOR . $imagename);
      }
    }

    return $imagename;
  }


}