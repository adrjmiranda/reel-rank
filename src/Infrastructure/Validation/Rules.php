<?php

namespace ReelRank\Infrastructure\Validation;

use InvalidArgumentException;

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
    }

    return $value;
  }
}