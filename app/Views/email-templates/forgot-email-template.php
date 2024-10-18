<p>Dear <span style="font-weight: bold"> <?= $maildata['user']->name ?> </span></p>
<p>We have recived a request to reset password for your account  </p>
<p>You can reset your password by clicking the button below !  </p>
<a
        style="color: white ; background-color: #1b00ff; padding: 5px ; border-radius: 8px;text-decoration: none"
        href="<?=$maildata['actionLink']?> "  target="_blank"
>Reset Password</a>

<p style="background-color: red;padding: 3px">note : This link will be available for 15 minutes only ...</p>
