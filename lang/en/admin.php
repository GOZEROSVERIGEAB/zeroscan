<?php

return [
    // Navigation
    'nav' => [
        'dashboard' => 'Dashboard',
        'customers' => 'Customers',
        'settings' => 'Settings',
        'logout' => 'Log Out',
    ],

    // Auth
    'auth' => [
        'login_title' => 'Admin Login',
        'login_subtitle' => 'Enter your admin email to receive a login code',
        'email_label' => 'Email',
        'email_placeholder' => 'admin@company.com',
        'send_code' => 'Send Login Code',
        'verify_title' => 'Verify Your Identity',
        'verify_subtitle' => 'Enter the 6-digit code sent to',
        'otp_label' => 'Verification Code',
        'otp_placeholder' => '000000',
        'code_expires' => 'Code expires in 10 minutes',
        'verify_button' => 'Verify & Login',
        'resend_code' => 'Resend Code',
        'back_to_login' => 'Back to Login',
        'back_to_main' => 'Back to Main Login',
        'all_rights' => 'All rights reserved.',
        'not_authorized' => 'You are not authorized to access the admin panel.',
        'email_not_found' => 'No admin account found with this email.',
        'too_many_attempts' => 'Too many attempts. Please try again in :seconds seconds.',
        'code_sent' => 'A verification code has been sent to your email.',
        'code_resent' => 'A new verification code has been sent.',
        'code_expired' => 'The verification code has expired. Please request a new one.',
        'invalid_code' => 'Invalid verification code.',
    ],

    // Dashboard
    'dashboard' => [
        'title' => 'Dashboard',
        'subtitle' => 'Overview of all customers and platform statistics',
        'total_customers' => 'Total Customers',
        'active' => 'active',
        'on_trial' => 'on trial',
        'total_facilities' => 'Facilities',
        'total_stations' => 'Stations',
        'total_scans' => 'Total Scans',
        'this_month' => 'this month',
        'today' => 'today',
        'recent_customers' => 'Recent Customers',
        'view_all' => 'View All',
        'no_recent_customers' => 'No customers registered in the last 7 days.',
        'expiring_trials' => 'Expiring Trials',
        'upcoming' => 'upcoming',
        'no_expiring_trials' => 'No trials expiring in the next 7 days.',
        'days_left' => 'days left',
        'top_customers' => 'Top Customers by Usage',
        'no_customers' => 'No customers found.',
    ],

    // Customers
    'customers' => [
        'title' => 'Customers',
        'subtitle' => 'Manage all customer accounts and subscriptions',
        'create' => 'New Customer',
        'create_title' => 'Create Customer',
        'create_subtitle' => 'Add a new customer account to the platform',
        'edit_title' => 'Edit Customer',
        'edit_subtitle' => 'Update customer information and settings',
        'search_placeholder' => 'Search by name, email, or org number...',
        'no_customers' => 'No customers found',
        'no_customers_desc' => 'Get started by creating your first customer.',
        'create_first' => 'Create First Customer',
        'trial_ends' => 'Trial ends in :days days',
        'facilities' => 'Facilities',
        'stations' => 'Stations',
        'users' => 'Users',
        'confirm_activate' => 'Are you sure you want to activate this customer?',
        'confirm_suspend' => 'Are you sure you want to suspend this customer?',
        'confirm_reactivate' => 'Are you sure you want to reactivate this customer?',
        'created_success' => 'Customer created successfully.',
        'updated_success' => 'Customer updated successfully.',
        'activated_success' => 'Customer activated successfully.',
        'suspended_success' => 'Customer suspended successfully.',
        'trial_extended' => 'Trial extended by :days days.',
    ],

    // Status
    'status' => [
        'trial' => 'Trial',
        'active' => 'Active',
        'suspended' => 'Suspended',
        'cancelled' => 'Cancelled',
    ],

    // Filters
    'filters' => [
        'all' => 'All',
    ],

    // Table
    'table' => [
        'customer' => 'Customer',
        'status' => 'Status',
        'facilities' => 'Facilities',
        'stations' => 'Stations',
        'users' => 'Users',
        'actions' => 'Actions',
    ],

    // Actions
    'actions' => [
        'view' => 'View',
        'edit' => 'Edit',
        'activate' => 'Activate',
        'suspend' => 'Suspend',
        'reactivate' => 'Reactivate',
        'extend_trial' => 'Extend Trial +14 days',
        'view_details' => 'View Details',
        'save_changes' => 'Save Changes',
    ],

    // Wizard
    'wizard' => [
        'step_basic' => 'Basic Info',
        'step_address' => 'Address',
        'step_subscription' => 'Subscription',
        'step_limits' => 'Limits',
        'basic_info' => 'Basic Information',
        'address_info' => 'Address',
        'subscription_info' => 'Subscription',
        'limits_info' => 'Usage Limits',
        'limits_desc' => 'Leave empty for unlimited usage.',
        'previous' => 'Previous',
        'next' => 'Next',
        'create_customer' => 'Create Customer',
    ],

    // Fields
    'fields' => [
        'name' => 'Company Name',
        'org_number' => 'Organization Number',
        'email' => 'Email',
        'phone' => 'Phone',
        'address' => 'Address',
        'city' => 'City',
        'postal_code' => 'Postal Code',
        'country' => 'Country',
        'subscription_status' => 'Subscription Status',
        'trial_ends_at' => 'Trial Ends',
        'is_enterprise' => 'Enterprise Customer',
        'is_enterprise_desc' => 'Enterprise customers have access to advanced features.',
        'is_active' => 'Active',
        'is_active_desc' => 'Active customers can log in and use the platform.',
        'max_facilities' => 'Max Facilities',
        'max_stations' => 'Max Stations',
        'max_scans_per_month' => 'Max Scans per Month',
        'created_at' => 'Created',
    ],

    // Placeholders
    'placeholders' => [
        'company_name' => 'Company Name AB',
        'address' => 'Street Address 123',
        'city' => 'Stockholm',
        'unlimited' => 'Unlimited',
    ],

    // Sections
    'sections' => [
        'company_info' => 'Company Information',
        'address' => 'Address',
        'subscription_status' => 'Subscription',
        'limits' => 'Usage Limits',
        'limits_desc' => 'Leave empty for unlimited usage.',
        'usage_history' => 'Usage History',
        'details' => 'Details',
        'facilities' => 'Facilities',
        'users' => 'Users',
    ],

    // Tabs
    'tabs' => [
        'basic_info' => 'Basic Info',
        'subscription' => 'Subscription & Limits',
        'usage' => 'Usage Statistics',
    ],

    // Usage
    'usage' => [
        'no_data' => 'No usage data available.',
        'period' => 'Period',
        'scans' => 'Scans',
        'limit' => 'Limit',
        'usage_percent' => 'Usage',
    ],

    // Stats
    'stats' => [
        'facilities' => 'Facilities',
        'stations' => 'Stations',
        'scans_month' => 'Scans this Month',
        'users' => 'Users',
        'limit' => 'Limit',
    ],

    // Misc
    'current' => 'Current',
    'unlimited' => 'Unlimited',
    'days_left' => 'days left',
    'expired' => 'Expired',

    // Facilities/Users sections
    'facilities' => [
        'none' => 'No facilities created yet.',
    ],
    'users' => [
        'none' => 'No users created yet.',
    ],

    // Validation
    'validation' => [
        'name_required' => 'Company name is required.',
        'email_required' => 'Email is required.',
        'email_invalid' => 'Please enter a valid email address.',
    ],
];
