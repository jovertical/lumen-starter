<div>
    <h1>
        Hello <?= $user->first_name ?>!
    </h1>

    <p>
        Welcome to <?= env('APP_NAME') ?>. You can verify your account creation by visiting this
        <a href="<?= env('APP_WEB_URL') . '/auth/signup?email=' . $user->email ?>">link</a>.
    </p>
</div>