<?php

namespace ReelRank\Infrastructure\Validation;

use InvalidArgumentException;
use ReelRank\Infrastructure\DAO\Persistence\CategoryDAO;
use ReelRank\Infrastructure\DAO\Persistence\MovieDAO;

trait Rules
{
  private function required(string $field, mixed $value): mixed
  {
    $this->persistentInput->set($field, $value);

    if (
      $value === null ||
      \is_string($value) && $value === '' ||
      \is_array($value) && \count($value) === 0
    ) {
      $this->flash->set($field, "Este campo é obrigatório.");
      return null;
    }

    return $value;
  }

  private function email(string $field, string $value): ?string
  {
    $this->persistentInput->set($field, $value);

    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->flash->set($field, "Endereço de e-mail inválido.");
      return null;
    }

    return $value;
  }

  private function alphabetical(string $field, string $value): ?string
  {
    $this->persistentInput->set($field, $value);

    if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $value)) {
      $this->flash->set($field, "Somente permitido letras e espaços.");
      return null;
    }

    return $value;
  }

  private function numeric(string $field, int|string $value): ?int
  {
    $this->persistentInput->set($field, $value);

    if (\is_int($value)) {
      return $value;
    }

    if (!preg_match('/^\d+$/', $value)) {
      $this->flash->set($field, "Somente permitido números inteiros.");
      return null;
    }

    return (int) $value;
  }

  public function confirmpassword(string $field, string $value, array $params): ?string
  {
    $this->persistentInput->set($field, $value);

    $password = $params[0] ?? '';
    if (empty($value) || $value !== $password) {
      $this->flash->set($field, "Confirmação de senha está errada.");
      return null;
    }

    return $value;
  }

  private function min(string $field, string $value, array $params): ?string
  {
    $this->persistentInput->set($field, $value);

    $limit = $params[0] ?? '';
    if (!preg_match('/^\d+$/', $limit))
      throw new InvalidArgumentException("The minimum specified must be an integer.", 500);

    $limit = (int) $limit;
    if (\strlen($value) < $limit) {
      $this->flash->set($field, "Este campo deve ter no mínimo {$limit} caracteres.");
      return null;
    }

    return $value;
  }

  private function max(string $field, string $value, array $params): ?string
  {
    $this->persistentInput->set($field, $value);

    $limit = $params[0] ?? '';
    if (!preg_match('/^\d+$/', $limit))
      throw new InvalidArgumentException("The maximum specified must be an integer.", 500);

    $limit = (int) $limit;
    if (\strlen($value) > $limit) {
      $this->flash->set($field, "Este campo deve ter no máximo {$limit} caracteres.");
      return null;
    }

    return $value;
  }

  private function validcategory(string $field, int $value): ?int
  {
    $categoryDAO = new CategoryDAO();
    $category = $categoryDAO->findOne($value);
    if (!$category) {
      $this->flash->set('categoryId', 'Categoria inválida');
      return null;
    }

    return $value;
  }

  private function between(string $field, int $value, array $params): ?int
  {
    [$min, $max] = $params;
    if ($value < $min || $value > $max) {
      $this->flash->set($field, "Valores permitidos de {$min} a {$max}");
      return null;
    }

    return $value;
  }

  private function validmovie(string $field, int $value): ?int
  {
    $movie = (new MovieDAO())->findOne($value);
    if (!$movie) {
      $this->flash->set('session_message', "Falha na requisição. O filme não existe.");
      return null;
    }

    return $value;
  }
}