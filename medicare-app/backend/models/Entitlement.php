<?php

class Entitlement {
    private static $features = [
        'basic' => ['specialist_directory', 'medicine_search'],
        'pro' => ['specialist_directory', 'medicine_search', 'chat', 'med_guidelines'],
        'elite' => ['specialist_directory', 'medicine_search', 'chat', 'med_guidelines', 'telehealth', 'priority_support']
    ];

    public static function hasAccess($plan, $feature) {
        $plan = strtolower($plan);
        if (!isset(self::$features[$plan])) {
            $plan = 'basic';
        }
        return in_array($feature, self::$features[$plan]);
    }

    public static function getPlanDetails($plan) {
        $plans = [
            'basic' => [
                'name' => 'Basic',
                'price' => 'Free',
                'description' => 'Essential healthcare access',
                'features' => ['Specialist Directory', 'Medicine Search', 'Appointment Scheduling']
            ],
            'pro' => [
                'name' => 'Professional',
                'price' => '$29/mo',
                'description' => 'Complete patient-doctor orchestration',
                'features' => ['Everything in Basic', 'Secure Chat Hub', 'Detailed Medicine Guidelines', 'Unlimited History']
            ],
            'elite' => [
                'name' => 'Elite',
                'price' => '$99/mo',
                'description' => 'The ultimate clinical experience',
                'features' => ['Everything in Pro', 'Verified Expert Tier', 'Priority Support', 'Telehealth Beta access']
            ]
        ];
        return $plans[strtolower($plan)] ?? $plans['basic'];
    }
}
