<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ScanIT English Translations
    |--------------------------------------------------------------------------
    */

    'app_name' => 'Scanit',

    'auth' => [
        'login_title' => 'Log In',
        'login_subtitle' => 'Enter your email address to log in',
        'email_label' => 'Email Address',
        'email_placeholder' => 'your@email.com',
        'send_code' => 'Send Login Code',
        'verify_title' => 'Verify Your Identity',
        'verify_subtitle' => 'Enter the six-digit code sent to your email',
        'otp_label' => 'Verification Code',
        'otp_placeholder' => '000000',
        'verify_button' => 'Verify',
        'resend_code' => 'Resend Code',
        'code_expires' => 'The code is valid for 10 minutes',
        'code_sent' => 'A login code has been sent to your email',
        'code_resent' => 'A new login code has been sent',
        'invalid_code' => 'Invalid verification code',
        'code_expired' => 'The code has expired. Request a new code.',
        'email_not_found' => 'We could not find an account with that email address',
        'back_to_login' => 'Back to login',
        'logout' => 'Log Out',
        'too_many_attempts' => 'Too many attempts. Try again in :seconds seconds.',
    ],

    'email' => [
        'otp_subject' => 'Your Login Code for Scanit',
        'otp_greeting' => 'Hello!',
        'otp_body' => 'Here is your login code:',
        'otp_expiry' => 'This code is valid for 10 minutes.',
        'otp_ignore' => 'If you did not try to log in, you can ignore this message.',
        'report_subject' => 'Your Environmental Report from :station',
        'report_title' => 'Your Environmental Report',
        'report_subtitle' => ':count items analyzed',
        'co2_saved' => 'CO2 Saved',
        'water_saved' => 'Water Saved',
        'energy_saved' => 'Energy Saved',
        'estimated_value' => 'Estimated Value',
        'scanned_items' => 'Scanned Items',
        'registered_items' => 'Your Registered Items',
        'value' => 'Value',
        'condition' => 'Condition',
        'environmental_impact' => 'Your Environmental Impact',
        'what_does_it_mean' => 'What does it actually mean?',
        'trees_equivalent' => 'trees annual CO2 absorption',
        'car_km_equivalent' => 'km of car driving avoided',
        'showers_equivalent' => 'showers saved',
        'phone_charges_equivalent' => 'phone charges saved',
        'items_reused' => 'Items Reused',
        'your_savings' => 'Your Environmental Savings',
        'greeting_friend' => 'Hello eco-friend!',
        'greeting_name' => 'Hello :name!',
        'greeting_text' => 'By giving your items a new life, you have contributed to a more sustainable future. Here is a summary of your positive environmental impact.',
        'hero_title' => 'Your effort makes a difference!',
        'hero_subtitle' => 'Thank you for choosing reuse',
        'items_registered' => ':count items registered',
        'cta_title' => 'You are an eco-hero!',
        'cta_text' => 'By choosing to reuse instead of throwing away, you have actively contributed to a more sustainable future. Keep it up!',
        'total_value_label' => 'Estimated total value:',
        'share_text' => 'Share your contribution with friends and family',
        'share_hashtag' => '#ChooseReuse #SustainableFuture',
        'powered_by' => 'Powered by',
        'disclaimer_title' => 'About the estimates',
        'disclaimer_text' => 'Values and CO2 savings are estimates based on AI analysis. Actual values may vary depending on market, condition and other factors. CO2 calculations are based on average life cycle data for product categories.',
        'footer_text' => 'Thank you for contributing to a more sustainable future through reuse!',
        'footer_together' => 'Together we make a real difference for our planet.',
        'report_generated' => 'Report generated:',
        // Environmental facts per category
        'fact_clothing' => 'Did you know that it takes about 2,700 liters of water to make a new cotton t-shirt?',
        'fact_furniture' => 'A used piece of furniture saves an average of 80% of CO2 emissions compared to a new one.',
        'fact_electronics' => 'Reusing electronics reduces mining for rare earth metals.',
        'fact_books' => 'Sharing books saves trees and reduces the environmental impact of paper production.',
        'fact_toys' => 'Most toys are made of plastic that takes hundreds of years to break down.',
        'fact_sports' => 'Reused sports equipment often works just as well as new and saves a lot of resources.',
        'fact_household' => 'By reusing household items, you reduce both waste and new production.',
        'fact_default' => 'Every item that is reused contributes to less waste in landfills.',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'welcome' => 'Welcome',
    ],

    // Facilities
    'facilities' => [
        'stations_label' => 'Stations',
        'stations_count' => ':count stations',
        'archived' => 'The facility has been archived',
        'restored' => 'The facility has been restored',
    ],

    // Stations
    'stations' => [
        'archived' => 'The station has been archived',
        'restored' => 'The station has been restored',
    ],

    // Archive functionality
    'archive' => [
        'title' => 'Archive',
        'will_be_deleted' => 'Will be permanently deleted :date (in :days days)',
        'facility_confirm' => 'Are you sure you want to archive this facility? All associated stations will also be archived. You have 7 days to undo this action.',
        'station_confirm' => 'Are you sure you want to archive this station? You have 7 days to undo this action.',
        'grace_period_info' => 'Archived items are permanently deleted after 7 days.',
    ],

    // Actions
    'actions' => [
        'restore' => 'Restore',
        'archive' => 'Archive',
    ],

    // Statistics
    'stats' => [
        'total_scans' => 'Total Scans',
        'total_items' => 'Items Analyzed',
        'total_co2' => 'CO₂ Saved (kg)',
    ],

    // Public scanning flow
    'public' => [
        'title' => 'Scan',
        'welcome_title' => 'Sort Your Items',
        'default_info_text' => 'Take pictures of your items and get a report on how they can be reused or recycled.',
        'start_scanning' => 'Start Scanning',
        'capture_title' => 'Take Pictures',
        'capture_description' => 'Photograph 1-5 items. More pictures means better analysis.',
        'images_taken' => 'Images taken: :count/:max',
        'add_image' => 'Add Image',
        'done_proceed' => 'Done - Continue',
        'processing' => 'Processing...',
        'email_title' => 'Want a Report?',
        'email_description' => 'Enter your email and we will send you a report when the analysis is complete.',
        'email_label' => 'Email Address (optional)',
        'email_placeholder' => 'your@email.com',
        'gdpr_text' => 'I accept that my email will be stored to send the report according to our',
        'privacy_policy_link' => 'privacy policy',
        'submit' => 'Submit',
        'skip_email' => 'Skip',
        'thankyou_title' => 'Thank You!',
        'thankyou_message' => 'Your images are now being processed. It usually takes a few minutes.',
        'report_will_be_sent' => 'Report will be sent to: :email',
        'scan_more' => 'Scan More Items',
        'error_no_images' => 'You must take at least one picture before continuing.',
        'cancel' => 'Cancel',
        'camera_access_denied' => 'The camera could not be opened. Check that you have granted camera permission.',
    ],

    // Validation messages
    'validation' => [
        'gdpr_required' => 'You must accept the privacy policy to enter your email.',
        'email_invalid' => 'Please enter a valid email address.',
    ],

    // Status messages
    'status' => [
        'queued' => 'Waiting in queue',
        'processing' => 'Processing',
        'completed' => 'Completed',
        'failed' => 'Failed',
    ],

    // Common
    'unknown_item' => 'Unknown item',

];
