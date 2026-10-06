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

use Derafu\Enum\Currency;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Currency::class)]
final class CurrencyTest extends TestCase
{
    public function testEveryCurrencyHasItsData(): void
    {
        $this->assertNotEmpty(Currency::cases());

        foreach (Currency::cases() as $currency) {
            $code = $currency->getCode();
            $this->assertSame($currency->value, $code);
            // XXX is "no currency": it has no symbol on purpose.
            if ($currency !== Currency::XXX) {
                $this->assertNotSame('', $currency->getSymbol(), $code);
            }
            $this->assertGreaterThanOrEqual(0, $currency->getDecimals(), $code);
            $this->assertStringContainsString('{{amount}}', $currency->getTemplate(), $code);
            $this->assertStringContainsString('{{symbol}}', $currency->getTemplate(), $code);
            // The English name is defined, so the code is never the fallback.
            $this->assertNotSame($code, $currency->getName('en'), $code);
            $this->assertNotSame('', $currency->getName('es'), $code);
        }
    }

    public function testNoCurrencyHasNoSymbol(): void
    {
        $this->assertSame('', Currency::XXX->getSymbol());
        $this->assertSame('1,234.50', Currency::XXX->format(1234.5));
        // Without the space of the template at the start.
        $this->assertSame('1,234.50', Currency::XXX->render(1234.5));
    }

    public function testNameInTheLanguageWithFallback(): void
    {
        $this->assertSame('Chilean Peso', Currency::CLP->getName());
        $this->assertSame('Peso chileno', Currency::CLP->getName('es'));
        // A language without names falls back to English.
        $this->assertSame('Chilean Peso', Currency::CLP->getName('de'));
    }

    /**
     * @return array<string, array{Currency, int|float, string}>
     */
    public static function formatProvider(): array
    {
        return [
            'CLP without decimals' => [Currency::CLP, 1234567, '1.234.567'],
            'CLP rounds' => [Currency::CLP, 1500.6, '1.501'],
            'USD' => [Currency::USD, 1234.5, '1,234.50'],
            'EUR' => [Currency::EUR, 1234.5, '1,234.50'],
            'BTC with 8 decimals' => [Currency::BTC, 0.12345678, '0.12345678'],
            'negative' => [Currency::USD, -5.5, '-5.50'],
        ];
    }

    #[DataProvider('formatProvider')]
    public function testFormat(Currency $currency, int|float $amount, string $expected): void
    {
        $this->assertSame($expected, $currency->format($amount));
    }

    public function testRender(): void
    {
        $this->assertSame('$ 1.234.567', Currency::CLP->render(1234567));
        $this->assertSame('$ -5.50', Currency::USD->render(-5.5));
        $this->assertSame('₿ 0.12345678', Currency::BTC->render(0.12345678));
        // The template can put the symbol after the amount.
        $this->assertSame('1,234.50 €', Currency::EUR->render(1234.5));
    }

    public function testRoundReturnsAnIntegerWithoutDecimals(): void
    {
        $this->assertSame(1501, Currency::CLP->round(1500.6));
        $this->assertSame(1.01, Currency::USD->round(1.005));
        $this->assertSame(2.35, Currency::USD->round(2.345));
    }

    /**
     * @return array<string, array{Currency, int|float, bool}>
     */
    public static function validAmountProvider(): array
    {
        return [
            'USD 1.15 (not exact as a float)' => [Currency::USD, 1.15, true],
            'USD 0.29' => [Currency::USD, 0.29, true],
            'USD 19.99' => [Currency::USD, 19.99, true],
            'USD 4.35' => [Currency::USD, 4.35, true],
            'USD 100.1' => [Currency::USD, 100.1, true],
            'USD integer' => [Currency::USD, 5, true],
            'USD with a float error of a sum' => [Currency::USD, 0.1 + 0.2, true],
            'USD with 3 decimals' => [Currency::USD, 1.005, false],
            'USD with more decimals' => [Currency::USD, 1.123456, false],
            'CLP integer' => [Currency::CLP, 10, true],
            'CLP float without decimals' => [Currency::CLP, 10.0, true],
            'CLP with decimals' => [Currency::CLP, 10.5, false],
            'BTC 8 decimals' => [Currency::BTC, 0.12345678, true],
            'BTC 9 decimals' => [Currency::BTC, 0.123456789, false],
            'USD big amount' => [Currency::USD, 1234567890.12, true],
            'USD big amount with 3 decimals' => [Currency::USD, 1234567890.123, false],
            'negative' => [Currency::USD, -1.15, true],
        ];
    }

    #[DataProvider('validAmountProvider')]
    public function testIsValidAmount(Currency $currency, int|float $amount, bool $expected): void
    {
        $this->assertSame($expected, $currency->isValidAmount($amount));
    }

    public function testToArray(): void
    {
        $this->assertSame([
            'code' => 'CLP',
            'name' => 'Chilean Peso',
            'symbol' => '$',
            'decimals' => 0,
            'decimal_separator' => ',',
            'thousands_separator' => '.',
            'template' => '{{symbol}} {{amount}}',
        ], Currency::CLP->toArray());
    }
}
