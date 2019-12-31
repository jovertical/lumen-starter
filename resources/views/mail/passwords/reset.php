<div>
    <h1>
        Hello <?= $user->first_name ?>!
    </h1>

    <p>
        You can reset your password by visiting this
        <a href="<?= env('APP_WEB_URL') . '/auth/password/reset?token=' . $token ?>">link</a>.
    </p>
</div>
