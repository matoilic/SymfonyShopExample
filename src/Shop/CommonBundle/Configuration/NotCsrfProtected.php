<?php

namespace Shop\CommonBundle\Configuration;

/**
 * Annotation class for @NotCsrfProtected().
 *
 * @Annotation
 */
class NotCsrfProtected
{
    public function __construct(array $data) { }
}
