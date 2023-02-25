# Social Network

A project based on DDD, CQRS, and HA made with [Symfony](https://symfony.com) web framework.

Created from [Symfony Docker](https://github.com/dunglas/symfony-docker) project as starting point.

![CI](https://github.com/lcavero/social-network/workflows/CI/badge.svg)

## Build project

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.


## Abstract

This project aims to collect and serve as an example of my point of view on the application of DDD, CQRS and Hexagonal Architecture in the development of an application.
As you already know, although there are usually some common lines, each person has their own vision of how to implement these methodologies and this is just one more. In fact, it is specifically an image of how I conceive it today, and that will most likely change over time.


For this reason, and as this is more than anything a project on a personal level, a sample of my knowledge in the sector, I will try to summarize in this file the motivations behind the development strategies that I have used.

## Quality tools

In order to maintain a quality code, through git hooks, I have applied restrictions for:

    - Not being able to commit if PHPStan encounters a problem.
    - Not being able to push if the tests don't pass.

## CI

Thanks to the help of Github Ci, after every push to the repository, the application is built and tested.

## Testing

As Alistair Cockburn said: 

> Allow an application to equally be driven by users, programs, automated test or batch scripts, and to be developed and tested in isolation from its eventual run-time devices and databases.[1]

In fact, one of the motivations for the hexagonal architecture is precisely to be able to automate tests without relying on user interaction or external services that may not be available.
Following that logic, I should limit my tests to the Domain and Application layers. However, an important part is the API entry points, they have controllers with validations, role-based security, and responses. I wouldn't want to leave that untested. So I have been encouraged to use [Behat](https://docs.behat.org/en/latest/) for these cases.






## References
[1] [Hexagonal Architecture - Alistair Cockburn](https://alistair.cockburn.us/hexagonal-architecture/)

