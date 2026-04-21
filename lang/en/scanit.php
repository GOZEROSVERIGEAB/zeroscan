<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ScanIT English Translations
    |--------------------------------------------------------------------------
    */

    'app_name' => 'ZeroScan',

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
        'otp_subject' => 'Your Login Code for ZeroScan',
        'otp_greeting' => 'Hello!',
        'otp_body' => 'Here is your login code:',
        'otp_expiry' => 'This code is valid for 10 minutes.',
        'otp_ignore' => 'If you did not try to log in, you can ignore this message.',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'welcome' => 'Welcome',
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
