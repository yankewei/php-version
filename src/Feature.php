<?php

declare(strict_types=1);

namespace Yankewei\PHP;

enum Feature
{
    case PROPERTY_HOOKS;
    case ASYMMETRIC_VISIBILITY;
    case DEPRECATED_ATTRIBUTE;
    case WITHOUT_PARENTHESES;
}
