<?php
// Gmail SMTP Configuration
// Replace these values with your actual Gmail credentials

return [
    'smtp' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'info.sandy6@gmail.com', // Replace with your Gmail address
        'password' => 'covlrdkfargwkjgz', // Replace with your Gmail App Password
        'encryption' => 'tls',
        'from_email' => 'info.sandy6@gmail.com', // Same as username
        'from_name' => 'Team Yulsa'
    ]
];

/*
SETUP INSTRUCTIONS:

1. Enable 2-Factor Authentication on your Gmail account:
   - Go to Google Account settings
   - Security > 2-Step Verification > Turn on

2. Generate App Password:
   - Go to Google Account settings
   - Security > 2-Step Verification > App passwords
   - Select "Mail" and "Other (Custom name)"
   - Enter "Team Yulsa Website" as the name
   - Copy the 16-character password (no spaces)

3. Update this file:
   - Replace 'your-gmail@gmail.com' with your actual Gmail address
   - Replace 'your-app-password' with the 16-character app password

4. Test the configuration using test-gmail.php
*/
?>
