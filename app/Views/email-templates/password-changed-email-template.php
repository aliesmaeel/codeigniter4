<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    Dear <span style="font-weight: bold;"><?= $maildata['user']->name ?></span>,
</p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    We wanted to inform you that your password has been successfully changed. If you did not request this change, please contact our support team immediately.
</p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    For your security, we recommend keeping your login information private and not sharing it with anyone. These credentials are confidential and should be handled with care.
</p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    <strong>Login:</strong> <?= $maildata['user']->username ?> or <?= $maildata['user']->email ?><br>
    <strong>Password:</strong> <?= $maildata['new_password'] ?>
</p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    Please make sure to update your password regularly to maintain the security of your account.
</p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
    Best regards,<br>
    <span style="font-weight: bold; color: #0056b3;">The Support Team</span><br>
    <span style="font-size: 14px; color: #888;">If you have any questions or need assistance, feel free to contact us.</span>
</p>

<!-- Footer warning -->
<p style="font-family: Arial, sans-serif; font-size: 14px; color: #888; margin-top: 20px;">
    <em>Please note: This message contains sensitive information. Ensure you do not share your password with anyone. If you did not initiate this password change, contact us immediately to secure your account.</em>
</p>
