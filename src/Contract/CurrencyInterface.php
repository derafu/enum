<?php

declare(strict_types=1);

/**
 * Derafu: Enum - Yet Another List of Enumerations for PHP.
 *
 * Copyright (c) 2026 Esteban De La Fuente Rubio / Derafu <https://www.derafu.dev>
 * Licensed under the MIT License.
 * See LICENSE file for more details.
 */

namespace Derafu\Enum\Contract;

/**
 * Contract for currency enums.
 *
 * Implement this interface in your own backed enum to make it compatible with
 * any component that formats, validates, or renders monetary amounts without
 * depending on the default Currency enum.
 *
 * @example
 *   enum GameCurrency: string implements CurrencyInterface
 *   {
 *       case Gold   = 'GOLD';
 *       case Silver = 'SILVER';
 *
 *       public function getCode(): string { return $this->value; }
 *       // ...
 *   }
 */
interface CurrencyInterface
{
    /**
     * Returns the currency code (e.g. "USD", "EUR", "CLP").
     */
    public function getCode(): string;

    /**
     * Returns the human-readable name of the currency.
     *
     * @param string $language ISO 639 language code (e.g. 'en', 'es').
     */
    public function getName(string $language = 'en'): string;

    /**
     * Returns the currency symbol (e.g. "$", "€", "₿").
     */
    public function getSymbol(): string;

    /**
     * Returns the number of decimal places used by the currency.
     *
     * For example, USD uses 2 decimals, CLP uses 0.
     */
    public function getDecimals(): int;

    /**
     * Returns the decimal separator character used by the currency.
     *
     * For example, "." for USD, "," for EUR in some locales.
     */
    public function getDecimalSeparator(): string;

    /**
     * Returns the thousands separator character used by the currency.
     *
     * For example, "," for USD, "." for CLP.
     */
    public function getThousandsSeparator(): string;

    /**
     * Validates that an amount respects the decimal precision of the currency.
     *
     * @param int|float $amount
     */
    public function isValidAmount(int|float $amount): bool;

    /**
     * Rounds an amount to the decimal precision of the currency.
     *
     * @param int|float $amount
     * @return int|float Integer when the currency has 0 decimals, float otherwise.
     */
    public function round(int|float $amount): int|float;

    /**
     * Formats an amount as a string using the currency's separators.
     *
     * Does not include the symbol. Use render() for the full representation.
     *
     * @param int|float $amount
     */
    public function format(int|float $amount): string;

    /**
     * Renders a fully formatted amount including the currency symbol.
     *
     * Uses the template returned by getTemplate() to place symbol and amount.
     *
     * @param int|float $amount
     */
    public function render(int|float $amount): string;

    /**
     * Returns the template used to render amounts.
     *
     * The template may contain the placeholders {{symbol}} and {{amount}}.
     * For example: "{{symbol}} {{amount}}" or "{{amount}} {{symbol}}".
     */
    public function getTemplate(): string;

    /**
     * Returns an array with all the currency metadata.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
