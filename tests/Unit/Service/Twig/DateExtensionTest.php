<?php

declare(strict_types=1);

namespace Buddy\Repman\Tests\Unit\Service\Twig;

use Buddy\Repman\Service\Twig\DateExtension;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final class DateExtensionTest extends TestCase
{
    private DateExtension $extension;
    private Environment $env;

    protected function setUp(): void
    {
        $this->extension = new DateExtension();
        $this->env = new Environment(new ArrayLoader());
    }

    public function testGetFilters(): void
    {
        self::assertEquals('time_diff', $this->extension->getFilters()[0]->getName());
    }

    /**
     * @dataProvider timeDiffProvider
     */
    public function testTimeDiff(string $excpeted, \DateTimeImmutable $dateTime, \DateTimeImmutable $now): void
    {
        self::assertEquals($excpeted, $this->extension->diff($this->env, $dateTime, $now));
    }

    /**
     * @return mixed[]
     */
    public function timeDiffProvider(): array
    {
        $dateTime = new \DateTimeImmutable();

        return [
            ['5 seconds ago', $dateTime->modify('-5 second'), $dateTime],
            ['1 second ago', $dateTime->modify('-1 second'), $dateTime],
            ['1 day ago', $dateTime->modify('-1 day'), $dateTime],
        ];
    }
}
