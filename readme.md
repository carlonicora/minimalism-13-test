This project is a test environment for `minimalism v13.0`. It is designed to give a series of examples on how `minimalism` works and how to use its most basics services.

This test uses a set of services, which have some requirement. If you do not fulfil the requirements for some of the services, you just need to avoid running the tests prepared for that specific service.

| Service                            | Requirements                         |
|------------------------------------|--------------------------------------|
| minimalism-service-data-mapper     | -                                    |
 | minimalism-service-encrypter       | -                                    |
 | minimalism-service-logger          | -                                    |
 | minimalism-service-datavalidator   | -                                    |
 | minimalism-service-twig            | -                                    |
 | minimalism-service-mysql           | MySQL                                |
 | minimalism-service-cacher          | Redis                                |
 | minimalism-service-redis           | Redis                                |
 | minimalism-service-builder         | -                                    |
 | minimalism-service-mailer-mandrill | Access to Mandrillapp to send emails |
 | minimalism-service-mailer-twig     | -                                    |
| minimalism-service-auth            | MySQL                                |

# Installation

This test works with Docker, and comes with two containers ready to be used in the folder `.docker`. To run the service just use terminal and run:

```
cd .docker
docker-compose build
docker-compose up -d
docker exec -ti minimalism-v1.0 composer install
```

The system listens to the address `minimalism.dev.carlonicora.com`, which you should put in the `hosts` table of your local machine.

You will need a NGINX proxy to add in front of this to redirect the calls to `minimalism.dev.carlonicora.com`. To do so you can use the nginx proxy I use: https://github.com/carlonicora/proxy

# Configurations

To run the tests correctly, you need a `.env.testing` in your root. The file should contain the following lines

```
#minimalism_service_encrypter
# sets your encryption key
MINIMALISM_SERVICE_ENCRYPTER_KEY=encrypter_key

#minimalism-service-mysql
# it is important you use database names ending in '_functionaltest'
MINIMALISM_SERVICE_MYSQL=M13T,OAuth
M13T=host,user,password,dbname,port
OAuth=host,user,password,dbname,port

#minimalism-service-cacher
# defines if to use caching (requires redis)
MINIMALISM_SERVICE_CACHER_USE=true

#minimalism-service-redis
# the redis connection (important if you use caching)
MINIMALISM_SERVICE_REDIS_CONNECTION=host,port

#minimalism-service-mailer-mandrill
# your mandrill username and password
MINIMALISM_SERVICE_MAILER_MANDRILL_USERNAME=username
MINIMALISM_SERVICE_MAILER_MANDRILL_PASSWORD=password
```

Please note: the calls use `minimalism.dev.carlonicora.com` but uses `docker.for.mac.localhost` to define the IP of the local machine using docker networking. If you are not on MacOS, you should change the file `tests/Abstracts/AbstractFunctionalTest.php` in line 74 accordingly.

# Databases

The system uses two databases for this test: M13T and OAuth. It is important that your database names end in `_functionaltest` for the test to run correctly. Apart from that, the DB name only matters in your configurations in the `.env.testing` file.

## M13T

```
CREATE TABLE `books` (
  `bookId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`bookId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `users` (
  `userId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

## OAuth

```
CREATE TABLE `appleIds` (
  `appleId` varchar(255) NOT NULL,
  `userId` bigint unsigned NOT NULL,
  PRIMARY KEY (`appleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `apps` (
  `appId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `isTrusted` tinyint(1) DEFAULT NULL,
  `clientId` varchar(255) NOT NULL,
  `clientSecret` varchar(255) DEFAULT NULL,
  `creationTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`appId`),
  UNIQUE KEY `appId` (`appId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `appScopes` (
  `appId` bigint unsigned NOT NULL,
  `scopeId` bigint unsigned NOT NULL,
  PRIMARY KEY (`appId`,`scopeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `auths` (
  `authId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `appId` bigint unsigned NOT NULL,
  `userId` bigint unsigned NOT NULL,
  `expiration` timestamp NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`authId`),
  UNIQUE KEY `authId` (`authId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `codes` (
  `codeId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint unsigned NOT NULL,
  `code` int NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `creationTime` timestamp NOT NULL,
  `expirationTime` timestamp NOT NULL,
  PRIMARY KEY (`codeId`),
  UNIQUE KEY `codeId` (`codeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `scopes` (
  `scopeId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`scopeId`),
  UNIQUE KEY `scopeId` (`scopeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `tokens` (
  `tokenId` bigint unsigned NOT NULL AUTO_INCREMENT,
  `appId` bigint unsigned NOT NULL,
  `userId` bigint unsigned NOT NULL,
  `isUser` tinyint(1) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`tokenId`),
  UNIQUE KEY `tokenId` (`tokenId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

# Running the tests

The best way to understand how `minimalism v13` works, run the test included in `tests/Functional` with PHP Unit. The tests included are functional tests and not unit tests; they just leverage PHP Unit for simplicity and ease of use.

The PHP installation includes XDebug. The best way to understand how `minimalism` works is to run it step-by-step  