<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    Dear <span style="font-weight: bold;"><?= $maildata['user']->name ?></span>,
</p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    We received a request to reset the password for your account. If you initiated this request, you can reset your password by clicking the button below:
</p>

<!-- Reset Password Button -->
<p>
    <a
            style="color: white; background-color: #1b00ff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 16px;"
            href="<?= $maildata['actionLink'] ?>" target="_blank">
        Reset Password
    </a>
</p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    If you did not request a password reset, please ignore this email. Your current password will remain unchanged.
</p>

<!-- Expiration Notice -->
<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    <span style="background-color: firebrick; color: white; padding: 5px; border-radius: 4px;">
        Note: This link will only be available for the next 15 minutes.
    </span>
</p>

<!-- Security Reminder -->
<p style="font-family: Arial, sans-serif; font-size: 14px; color: #888;">
    For security reasons, please do not share this email or your password with anyone. If you have any concerns about your account's security, please contact our support team immediately.
</p>

<!-- Footer -->
<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    Best regards,<br>
    <span style="font-weight: bold; color: #0056b3;">The Support Team</span>
</p>

