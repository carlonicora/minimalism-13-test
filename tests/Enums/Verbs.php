<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Enums;

enum Verbs: string
{
    case Post='POST';
    case Delete='DELETE';
    case Get='GET';
    case Put='PUT';
    case Patch='PATCH';
}