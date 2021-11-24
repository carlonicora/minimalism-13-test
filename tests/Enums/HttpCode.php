<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Enums;

enum HttpCode: int
{
    case Ok = 200;
    case Created = 201;
    case OkNoContent = 204;
    case Unauthorized = 401;
    case AccessDenied = 403;
    case NotFound = 404;
    case Conflict = 409;
    case MethodNotAllowed = 405;
    case ValidationFailed = 412;
    case InternalServerError = 500;
}