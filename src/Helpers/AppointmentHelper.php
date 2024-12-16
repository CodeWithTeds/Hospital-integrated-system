<?php

namespace Hospital\Management\Helpers;

class AppointmentHelper {
    public static function getStatusBadgeClass($status) {
        return match (strtolower($status)) {
            'scheduled' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show' => 'warning',
            default => 'secondary'
        };
    }
} 