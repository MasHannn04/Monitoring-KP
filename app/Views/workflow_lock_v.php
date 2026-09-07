<?php
// This view expects $locked_message, $locked_redirect, and $locked_button variables.
?>
<div class="content-wrapper" style="position: relative; min-height: 400px; display: flex; align-items: center; justify-content: center;">
    <div class="lock-overlay" style="background-color: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px; max-width: 500px; text-align: center; border-top: 5px solid #dc3545; z-index: 10;">
        <i class="fa-solid fa-lock" style="font-size: 50px; color: #dc3545; margin-bottom: 20px;"></i>
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 15px; color: var(--text-dark);">Akses Terkunci</h2>
        <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 30px; line-height: 1.5;">
            <?= htmlspecialchars($locked_message) ?>
        </p>
        <a href="<?= htmlspecialchars($locked_redirect) ?>" class="btn btn-primary" style="padding: 10px 25px; font-size: 14px; border-radius: 50px;">
            <i class="fa-solid fa-arrow-left"></i> <?= htmlspecialchars($locked_button) ?>
        </a>
    </div>
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('https://www.transparenttextures.com/patterns/cubes.png'); opacity: 0.03; z-index: 1; pointer-events: none;"></div>
</div>
