<?php
declare(strict_types=1);
namespace Lava\Container\exception;

use RuntimeException;
use Psr\Container\NotFoundExceptionInterface;
class NotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
    const TEMPLATE =  "%s is does not exist";
    function __construct($id)
    {
        parent::__construct(sprintf(static::TEMPLATE,$id));
    }
}