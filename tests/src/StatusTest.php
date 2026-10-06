<?php

declare(strict_types=1);

/**
 * Derafu: Enum - Yet Another List of Enumerations for PHP.
 *
 * Copyright (c) 2026 Esteban De La Fuente Rubio / Derafu <https://www.derafu.dev>
 * Licensed under the MIT License.
 * See LICENSE file for more details.
 */

namespace Derafu\TestsEnum;

use Derafu\Enum\Status;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Status::class)]
final class StatusTest extends TestCase
{
    /**
     * The predicates of each case: success, error, warning, info, neutral,
     * positive and negative.
     *
     * @return array<string, array{Status, array<string, bool>}>
     */
    public static function predicatesProvider(): array
    {
        $only = fn (string ...$true) => array_map(
            fn (string $key) => in_array($key, $true, true),
            array_combine(
                ['success', 'error', 'warning', 'info', 'neutral', 'positive', 'negative'],
                ['success', 'error', 'warning', 'info', 'neutral', 'positive', 'negative']
            )
        );

        return [
            'success' => [Status::Success, $only('success', 'positive')],
            'danger' => [Status::Danger, $only('error', 'negative')],
            'warning' => [Status::Warning, $only('warning', 'negative')],
            'info' => [Status::Info, $only('info', 'positive')],
            'primary' => [Status::Primary, $only('neutral')],
            'secondary' => [Status::Secondary, $only('neutral')],
            'light' => [Status::Light, $only('neutral')],
            'dark' => [Status::Dark, $only('neutral')],
        ];
    }

    /**
     * @param array<string, bool> $expected
     */
    #[DataProvider('predicatesProvider')]
    public function testPredicates(Status $status, array $expected): void
    {
        $this->assertSame($expected, [
            'success' => $status->isSuccess(),
            'error' => $status->isError(),
            'warning' => $status->isWarning(),
            'info' => $status->isInfo(),
            'neutral' => $status->isNeutral(),
            'positive' => $status->isPositive(),
            'negative' => $status->isNegative(),
        ]);
    }

    public function testEveryStatusHasItsBootstrapClasses(): void
    {
        foreach (Status::cases() as $status) {
            $color = $status->getColor();

            $this->assertSame($status->value, $status->getCode());
            $this->assertSame($color, $status->value);
            $this->assertSame('text-' . $color, $status->getTextClass());
            $this->assertSame('bg-' . $color, $status->getBgClass());
            $this->assertSame('border-' . $color, $status->getBorderClass());
            $this->assertSame('alert alert-' . $color, $status->getAlertClass());
            $this->assertSame('badge bg-' . $color, $status->getBadgeClass());
            $this->assertSame('btn btn-' . $color, $status->getBtnClass());
            $this->assertStringStartsWith('fa-solid fa-', $status->getIcon());
            $this->assertNotSame('', $status->getLabel());
        }
    }

    public function testIcons(): void
    {
        $this->assertSame('fa-solid fa-circle-check', Status::Success->getIcon());
        $this->assertSame('fa-solid fa-circle-xmark', Status::Danger->getIcon());
        $this->assertSame('fa-solid fa-triangle-exclamation', Status::Warning->getIcon());
        $this->assertSame('fa-solid fa-circle-info', Status::Info->getIcon());
        $this->assertSame('fa-solid fa-star', Status::Primary->getIcon());
        $this->assertSame('fa-solid fa-circle', Status::Secondary->getIcon());
        $this->assertSame('fa-solid fa-sun', Status::Light->getIcon());
        $this->assertSame('fa-solid fa-moon', Status::Dark->getIcon());
    }

    public function testFlashType(): void
    {
        $this->assertSame('success', Status::Success->getFlashType());
        $this->assertSame('error', Status::Danger->getFlashType());
        $this->assertSame('warning', Status::Warning->getFlashType());
        $this->assertSame('info', Status::Info->getFlashType());
    }

    public function testNeutralStatusesHaveNoFlashType(): void
    {
        foreach ([Status::Primary, Status::Secondary, Status::Light, Status::Dark] as $status) {
            $this->assertNull($status->getFlashType(), $status->name);
        }
    }
}
