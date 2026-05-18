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
 * Contract for status enums that carry Bootstrap 5.3 visual context.
 *
 * Implement this interface in your own backed enum to make it compatible with
 * any component that renders status-aware UI (alerts, badges, buttons, etc.)
 * without depending on the default Status enum.
 *
 * All getters follow the get* convention, which means they are also accessible
 * in Twig templates without the prefix: {{ status.color }}, {{ status.icon }}.
 *
 * @example
 *   enum OrderStatus: string implements StatusInterface
 *   {
 *       case Pending  = 'pending';
 *       case Shipped  = 'shipped';
 *       case Returned = 'returned';
 *
 *       public function getLabel(): string { ... }
 *       public function getColor(): string { ... }
 *       // ...
 *   }
 */
interface StatusInterface
{
    /**
     * Returns the status code (e.g. "success", "error", "pending").
     */
    public function getCode(): string;

    /**
     * Human-readable label for the status.
     *
     * @return string e.g. "Success", "Error", "Pending"
     */
    public function getLabel(): string;

    /**
     * Returns the flash type for the status.
     *
     * @return string e.g. "success", "error", "warning", "info"
     */
    public function getFlashType(): string;

    /**
     * Bootstrap 5.3 contextual color name.
     *
     * @return string One of: primary, secondary, success, danger, warning, info, light, dark.
     */
    public function getColor(): string;

    /**
     * Bootstrap text utility class.
     *
     * @return string e.g. "text-success"
     */
    public function getTextClass(): string;

    /**
     * Bootstrap background utility class.
     *
     * @return string e.g. "bg-success"
     */
    public function getBgClass(): string;

    /**
     * Bootstrap border utility class.
     *
     * @return string e.g. "border-success"
     */
    public function getBorderClass(): string;

    /**
     * Full Bootstrap Alert component classes.
     *
     * @return string e.g. "alert alert-success"
     */
    public function getAlertClass(): string;

    /**
     * Full Bootstrap Badge component classes.
     *
     * @return string e.g. "badge bg-success"
     */
    public function getBadgeClass(): string;

    /**
     * Full Bootstrap Button component classes.
     *
     * @return string e.g. "btn btn-success"
     */
    public function getBtnClass(): string;

    /**
     * Icon classes.
     *
     * For example Font Awesome or Bootstrap Icons.
     *
     * @return string e.g. "fa-solid fa-circle-check"
     */
    public function getIcon(): string;

    /**
     * Returns true if this status represents a successful outcome.
     */
    public function isSuccess(): bool;

    /**
     * Returns true if this status represents an error or failure.
     */
    public function isError(): bool;

    /**
     * Returns true if this status represents a non-critical warning.
     */
    public function isWarning(): bool;

    /**
     * Returns true if this status represents an informational message.
     */
    public function isInfo(): bool;

    /**
     * Returns true if this status is decorative or has no semantic outcome.
     *
     * Covers primary, secondary, light, and dark in the default implementation.
     */
    public function isNeutral(): bool;

    /**
     * Returns true if this status has a positive connotation.
     *
     * Covers success and info in the default implementation.
     */
    public function isPositive(): bool;

    /**
     * Returns true if this status has a negative connotation.
     *
     * Covers danger and warning in the default implementation.
     */
    public function isNegative(): bool;
}
