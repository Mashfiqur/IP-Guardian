<?php
  
namespace App\Enums;
 
enum AuditLogActionTypeEnum:int
{
    case CREATE = 1;
    case UPDATE = 2;
    case SOFT_DELETE = 3;
    case RESTORE = 4;
    case DELETE = 5;
}