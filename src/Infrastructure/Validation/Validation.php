<?php

namespace ReelRank\Infrastructure\Validation;

use InvalidArgumentException;
use ReelRank\Infrastructure\Data\PersistentInput;
use ReelRank\Infrastructure\Message\Flash;

class Validation
{
  use Rules;

  private const string RULE_SEPARATOR = '|';
  private const string PARAM_SEPARATOR = ':';
  private const string PARAMS_SEPARATOR = ',';

  private PersistentInput $persistentInput;
  private Flash $flash;

  private array $rules = [];
  private array $results = [];

  public function __construct()
  {
    $this->persistentInput = new PersistentInput();
    $this->flash = new Flash();
  }

  private function getRuleAndParmas(string $rule): array
  {
    if (!str_contains($rule, self::PARAM_SEPARATOR))
      return [$rule, []];

    if (substr_count($rule, self::PARAM_SEPARATOR) > 1)
      throw new InvalidArgumentException("Only one parameter can be passed at a time to each validation function.", 500);

    [$rule, $paramString] = explode(self::PARAM_SEPARATOR, $rule);
    if (empty($paramString))
      throw new InvalidArgumentException("The parameter passed to rule {$rule} cannot be empty.", 500);

    $paramString = str_contains($paramString, self::PARAMS_SEPARATOR) ? explode(self::PARAMS_SEPARATOR, $paramString) : [$paramString];

    return [$rule, $paramString];
  }

  public function validate(array $data, array $ruleList): ?array
  {
    foreach ($ruleList as $field => $rules) {
      $rules = str_contains($rules, self::RULE_SEPARATOR) ? explode(self::RULE_SEPARATOR, $rules) : [$rules];
      foreach ($rules as $rule) {
        $value = $data[$field] ?? null;
        if ($value === null)
          throw new InvalidArgumentException("In validate from Validation. The parameter was not defined in the data list.", 500);

        [$rule, $params] = $this->getRuleAndParmas($rule);
        $validateResult = $rule === 'confirmpassword' ? $this->$rule($field, $value, [$data['password'] ?? '']) : $this->$rule($field, $value, $params);

        $this->results[$field] = $validateResult;
        if ($validateResult === null)
          break;
      }
    }

    return \in_array(null, array_values($this->results)) ? null : $this->results;
  }
}