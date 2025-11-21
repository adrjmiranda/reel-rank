<?php

return [
  'value' => fn(object $obj): mixed => method_exists($obj, 'value') ? $obj->value() : $obj
];