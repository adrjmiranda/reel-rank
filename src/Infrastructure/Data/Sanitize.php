<?php

namespace ReelRank\Infrastructure\Data;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface as Request;

class Sanitize
{
  use Methods;

  private const string METHOD_SEPARATOR = '|';

  private array $sanitizedData = [];

  private function getFieldValue(Request $request, string $field, mixed $default = null): mixed
  {
    $data = $request->getParsedBody() ?? [];
    return $data[$field] ?? $default;
  }

  public function sanitize(Request $request, array $data): array
  {
    foreach ($data as $field => $methods) {
      if (empty($methods))
        throw new InvalidArgumentException("Method does not empty sanitize", 500);

      $methods = str_contains($methods, self::METHOD_SEPARATOR) ? explode(self::METHOD_SEPARATOR, $methods) : [$methods];

      $value = $this->getFieldValue($request, $field, null);
      foreach ($methods as $method) {
        $value = method_exists(self::class, $method) ? $this->$method($value) : $method($value);
      }
      $this->sanitizedData[$field] = $value;
    }

    return $this->sanitizedData;
  }
}