<?php

declare(strict_types=1);

/**
 * Derafu: Enum - Yet Another List of Enumerations for PHP.
 *
 * Copyright (c) 2026 Esteban De La Fuente Rubio / Derafu <https://www.derafu.dev>
 * Licensed under the MIT License.
 * See LICENSE file for more details.
 */

namespace Derafu\Enum;

use Derafu\Enum\Contract\StatusInterface;

/**
 * General-purpose status enum backed by Bootstrap 5.3 contextual color names.
 *
 * The case value matches the Bootstrap color name directly, so it can be used
 * as a raw string wherever Bootstrap utilities are built dynamically.
 *
 * Implement StatusInterface in your own enum if you need app-specific cases
 * while keeping full compatibility with components that type-hint StatusInterface.
 */
enum Status: string implements StatusInterface
{
    /**
     * Positive outcome, operation completed successfully.
     */
    case Success = 'success';

    /**
     * Failure, validation error, or unrecoverable problem.
     */
    case Danger = 'danger';

    /**
     * Non-critical issue that deserves attention.
     */
    case Warning = 'warning';

    /**
     * Neutral informational message.
     */
    case Info = 'info';

    /**
     * Primary action or highlighted state.
     */
    case Primary = 'primary';

    /**
     * Muted, inactive, or default state.
     */
    case Secondary = 'secondary';

    /**
     * Subtle, low-contrast state.
     */
    case Light = 'light';

    /**
     * High-contrast, dark state.
     */
    case Dark = 'dark';

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {
        return match($this) {
            Status::Success   => 'Success',
            Status::Danger    => 'Danger',
            Status::Warning   => 'Warning',
            Status::Info      => 'Info',
            Status::Primary   => 'Primary',
            Status::Secondary => 'Secondary',
            Status::Light     => 'Light',
            Status::Dark      => 'Dark',
        };
    }

    /**
     * {@inheritDoc}
     */
    public function getColor(): string
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getTextClass(): string
    {
        return 'text-' . $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getBgClass(): string
    {
        return 'bg-' . $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getBorderClass(): string
    {
        return 'border-' . $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlertClass(): string
    {
        return 'alert alert-' . $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getBadgeClass(): string
    {
        return 'badge bg-' . $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getBtnClass(): string
    {
        return 'btn btn-' . $this->value;
    }

    /**
     * Font Awesome icon classes.
     *
     * User must add the fa-fw class if needed.
     *
     * {@inheritDoc}
     */
    public function getIcon(): string
    {
        return match($this) {
            Status::Success   => 'fa-solid fa-circle-check',
            Status::Danger    => 'fa-solid fa-circle-xmark',
            Status::Warning   => 'fa-solid fa-triangle-exclamation',
            Status::Info      => 'fa-solid fa-circle-info',
            Status::Primary   => 'fa-solid fa-star',
            Status::Secondary => 'fa-solid fa-circle',
            Status::Light     => 'fa-solid fa-sun',
            Status::Dark      => 'fa-solid fa-moon',
        };
    }

    /**
     * {@inheritDoc}
     */
    public function isSuccess(): bool
    {
        return $this === Status::Success;
    }

    /**
     * {@inheritDoc}
     */
    public function isError(): bool
    {
        return $this === Status::Danger;
    }

    /**
     * {@inheritDoc}
     */
    public function isWarning(): bool
    {
        return $this === Status::Warning;
    }

    /**
     * {@inheritDoc}
     */
    public function isInfo(): bool
    {
        return $this === Status::Info;
    }

    /**
     * {@inheritDoc}
     */
    public function isNeutral(): bool
    {
        return in_array($this, [
            Status::Primary,
            Status::Secondary,
            Status::Light,
            Status::Dark,
        ], strict: true);
    }

    /**
     * {@inheritDoc}
     */
    public function isPositive(): bool
    {
        return in_array($this, [
            Status::Success,
            Status::Info,
        ], strict: true);
    }

    /**
     * {@inheritDoc}
     */
    public function isNegative(): bool
    {
        return in_array($this, [
            Status::Danger,
            Status::Warning,
        ], strict: true);
    }
}
